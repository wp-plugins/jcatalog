<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Helper_class extends WClasses {












public function getAddress($adid) {	
	static $resultA = array();


	if ( !isset( $resultA[$adid] ) ) {

		static $addressM = null;

		if ( empty( $addressM ) ) $addressM = WModel::get( 'address' );
		$addressM->makeLJ( 'countries', 'ctyid' );
		$addressM->makeLJ( 'countries.states', 'stateid', 'stateid', 0, 2 );
		$addressM->select( 'name', 1, 'country' );

		$addressM->select( 'isocode2', 1, 'countryISO2' );
		$addressM->select( 'isocode3', 1, 'countryISO3' );
		$addressM->select( 'name', 2, 'stateName' );			$addressM->select( 'code2', 2, 'stateCode' );			$addressM->whereE( 'adid', $adid );
		$addressM->select( '*', 0 );

		$resultA[$adid] = $addressM->load( 'o' );

	}

	return $resultA[$adid];


}






public function getDefaultAddressID($uid=null) {
	static $addid = array();

	if ( empty($uid) ) $uid = WUser::get('uid');
	if ( empty($uid) ) return false;


	if ( !isset( $addid[$uid] ) ) {
		$addressM = WModel::get( 'address' );
		$addressM->whereE( 'uid', $uid );

				$addressM->orderBy( 'premium', 'DESC' );
		$addressM->orderBy( 'modified', 'DESC' );
		$addid[$uid] = $addressM->load( 'lr', 'adid' );
	}
	return $addid[$uid];

}










	public function renderAddress($adid,$style='html',$phone=true,$flag=true,$name=false,$mapLink=true) {

		if ( is_numeric($adid) ) $addressO = $this->getAddress( $adid );
		else $addressO = $adid;

		if ( empty($addressO) ) return '';

		$html = '';
		if ( $style == 'html' ) {
			$separator = '<br />';
		} else {
			$separator = $style;
		}
		if ( !empty($name) ) {
			if ( $name === true ) $name2Use = $addressO->name;
			else $name2Use = $name;

			if ( empty($name2Use) || $name2Use == 'default' ) {
				$name2Use = '';
			} else {
				if ( !empty($addressO->link) ) {
					$name2Use = '<a href="' . $addressO->link . '">' . $name2Use . '</a>';
				}
				$html .= $name2Use;
			}

		}
		$addressText = '';
		if ( !empty($addressO->address1) ) $addressText .= $addressO->address1;
		if ( !empty($addressO->address2) ) $addressText .= ( !empty($addressText)?$separator:'' ) . $addressO->address2;
		if ( !empty($addressO->address3) ) $addressText .= ( !empty($addressText)?$separator:'' ) . $addressO->address3;
		if ( !empty($addressText) ) $html .= ( !empty($html) ? $separator : '' ) . $addressText;

		$cityText = '';
		if ( !empty($addressO->city) ) $cityText .= $addressO->city;
		if ( !empty($addressO->state) ) {
			$cityText .= ' ' . $addressO->state;
		} elseif ( !empty($addressO->stateCode) )  {
			$cityText .= ' ' . $addressO->stateCode;
		}		if ( !empty($addressO->zipcode) ) $cityText .=  ' ' . $addressO->zipcode;
		$cityText = trim($cityText);
		if ( !empty($cityText) ) $html .= ( !empty($html)?$separator:'' ) . $cityText;

				if ( empty($cityText) && empty($addressText) && !empty($addressO->location) ) {
			$html .= $separator . str_replace( ',', $separator, $addressO->location);
		}

		if ( !empty($addressO->ctyid) || !empty($addressO->country) ) {
			$countryText = '';
			if ( $flag && !empty($addressO->ctyid) ) {
				$countriesHelperC = WClass::get( 'countries.helper', null, 'class', false );
				if ( !empty($countriesHelperC) ) {
					$countryText .= $countriesHelperC->getCountryFlag( $addressO->ctyid );
				}			}			if ( empty( $addressO->country ) && !empty($addressO->ctyid) ) {
								if (empty($countriesHelperC) ) $countriesHelperC = WClass::get( 'countries.helper', null, 'class', false );
				if ( !empty($countriesHelperC) ) $addressO->country = $countriesHelperC->getData( $addressO->ctyid, 'name' );
			}			if ( !empty($addressO->country) ) {
				if ( !empty($html) ) $html .= $separator;
				$html .= $countryText;
				$html .= $addressO->country;
			}		}
		if ( $phone && !empty($addressO->phone) ) {
			if ( !empty($html) ) $html .= $separator . WText::t('1242282412EESC') .':' . $addressO->phone;
		}
		if ( $mapLink && WGlobals::checkCandy(50) && !empty($addressO->adid) ) {

			$extraLink = '';
			$width = 700;
			$height = 600;
			$heightStreet = 0;
			if ( !empty($addressO->address1) ) {
				$extraLink .= '&streetView=1';
				$width = 700;
				$height = 500;
				$heightStreet = 250;
			}
						if ( !in_array( JOOBI_APP_DEVICE_TYPE, array( 'ph', 'tb' ) ) ) {
				$link = WPage::linkPopUp( 'controller=address-map&adid=' . $addressO->adid . '&width=' . $width . '&height=' . $height. $extraLink );

				$objButtonO = WPage::newBluePrint( 'prefcatalog' );
				$objButtonO->type = 'buttonReviewInCatalogPage';
				$objButtonO->link = $link;
				$objButtonO->popUpIs = true;
				$objButtonO->popUpHeight = ( $height+( $heightStreet ? $heightStreet+50:0 )+25 );
				$objButtonO->popUpWidth = $width+25;
				$objButtonO->text = WText::t('1373210357FEOT');
				$html .= $separator . WPage::renderBluePrint( 'prefcatalog', $objButtonO );
			}
		}
				if ( $style=='html' && !empty($html) ) {
			if ( WUser::isRegistered() ) {
				$html = '<p style="line-height:1.4em;">' . $html . '</p>';
			} else {
				$html = '<address>' . $html . '</address>';
			}
		}
		return $html;

	}

}