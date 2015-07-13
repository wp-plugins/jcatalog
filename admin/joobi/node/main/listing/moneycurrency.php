<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Coremoneycurrency extends WListings_default{

	function create() {
				$status = parent::create();
		if ( !defined('CURRENCY_USED') ) {
			$currencyFormatC = WClass::get('currency.format', null,'class',false);
			if ( !empty($currencyFormatC) ) $currencyFormatC->set();
		}
				if ( $this->_setup() ) {
			$dropdownPL = WView::picklist( $this->_did );

			if ( empty($dropdownPL->_didLists[0]) ) {
				$message = WMessage::get();
				$message->codeE( 'The picklist with ID :' . $this->_did . ' is not available. Check the form element with ID :' . $this->element->fid . ' to solve the problem. It can be either picklist is not publish or the Level does not match.' );
				return false;
			}
			$dropdownPL->params= $this->element;

						$dropdownPL->name= 'trucs[' . $this->modelID . '][curid]';

						$outype = $dropdownPL->_didLists[0]->outype;

									
			$curidMap = 'curid_' . $this->modelID;
			$dropdownPL->defaults = ( isset( $this->data->$curidMap ) ) ? $this->data->$curidMap : 0;

			$dropdownPL->params->classes = ( isset( $this->element->classes ) ) ? $this->element->classes : 'simpleselect';

			$picklistHTML = $dropdownPL->display();
			if ( empty( $picklistHTML ) ) return false;

			$this->content .= $picklistHTML;

				} else {
			if ( !empty( $this->curid ) ) $curid = $this->curid;
			else $curid = $this->getValue( 'curid' );

			if ( empty($curid) ) $curid = CURRENCY_USED;

						$modelName = WModel::get( $this->modelID, 'namekey' );

						$priceModel = WModel::get( $modelName . '.price', 'sid', null, false );
			if ( !empty($priceModel) ) $priceType = $this->getValue( 'type', $modelName . '.price' );
			else $priceType = 0;

			if ( !empty($priceType) && $priceType != 10 ) {
				static $prodPricesC = null;
				$priceObj = new stdClass;
				$priceObj->pid = $this->getValue( 'pid' );
				$priceObj->priceType = $priceType;
				$priceObj->price = $this->value;
				$priceObj->curidFrom = $curid;
				$priceObj->curidTo = $curid;
				$priceObj->vendid = $this->getValue( 'vendid' );
				$priceObj->link = $this->getValue( 'link' );
				$priceObj->modelID = $this->modelID;
								if ( empty( $prodPricesC ) ) $prodPricesC = WClass::get( 'product.prices', null, 'class', false );
				$this->content = $prodPricesC->showPriceHTML( $priceObj );

			} else {
								$convertedPrice = $this->value;


				$this->content = WTools::format( $convertedPrice, 'currency', $curid );

			}
		}
		return $status;

	}




	private function _setup() {

				if ( $this->element->did > 0 ) {
			$this->_did = $this->element->did;
		} else {
			return false;
		}		return true;

	}





	public function advanceSearch() {

		$lid = $this->element->lid . '-s';
		$this->content = $this->_renderPriceFormHTML( $lid );

		$this->content .= ' ' . WText::t('1242282452RPKS'). ' ';
		$lid = $this->element->lid . '-e';
		$this->content .= $this->_renderPriceFormHTML( $lid );

		return true;

	}







	public function advanceSearchLinks($memory,$sessionKey,$controller,$task) {

		static $count = 0;


		$searchObjectO = new stdClass;
		$searchObjectO->name = $this->element->name;
		$searchObjectO->typeName = $this->element->typeName;
		$searchObjectO->typeNode = $this->element->typeNode;
		$searchObjectO->modelID = $this->element->modelID;
		$searchObjectO->column = $this->element->column;
		WGlobals::setSession( $memory, $this->element->lid .'-s', $searchObjectO );
		WGlobals::setSession( $memory, $this->element->lid .'-e', $searchObjectO );

		$lidMin = $this->element->lid. '-s';
		$defaultValueMin = WGlobals::getUserState( $sessionKey . $lidMin, $lidMin, 0, '', $memory );
		$nameMin = $memory . '[' . $lidMin . ']';
		$lidMax = $this->element->lid. '-e';
		$defaultValueMax = WGlobals::getUserState( $sessionKey . $lidMax, $lidMax, 0, '', $memory );
		$nameMax = $memory . '[' . $lidMax . ']';

		$symbol = WTools::format( 1, 'currencySymbol' );

		$html = '';
				if ( !empty($defaultValueMin) || !empty($defaultValueMax) ) {

			$resetLink = 'controller=' . $controller;
			if ( !empty($task) ) $resetLink .= '&task=' . $task;
			$resetLink .= '&' . $memory . 'Reset[' . $lidMin . ']=1';
			$resetLink .= '&' . $memory . '[' . $lidMin . ']=';
			$resetLink .= '&' . $memory . 'Reset[' . $lidMax . ']=1';
			$resetLink .= '&' . $memory . '[' . $lidMax . ']=';
			$html .= '<a style="margin-bottom:10px;" class="btn btn-info" href="' . WPage::link( $resetLink ) . '">' . WText::t('1404917671CVDL') . '</a>';
		}

		$html1 = $this->_renderPriceSearchLinks( $lidMin, $nameMin, $defaultValueMin );

		$goHTml = '<span class="input-group-btn"><button class="btn btn-default" type="submit">' . WText::t('1206732365OQJJ'). '</button></span>';

		$html2 = $this->_renderPriceSearchLinks( $lidMax, $nameMax, $defaultValueMax, $goHTml );

		$html .= '<div class="advSearchElement">' . $html1 . '<div class="advSearchTo">' . WText::t('1242282452RPKS') . '</div>' . $html2 . '</div>';

		$count++;
		$formHTML = new WForm( 'advanceSearchMoneyCurrency' );
		$formHTML->hidden( 'controller', $controller );
		if ( !empty($task) ) $formHTML->hidden( 'task', 'home' );
		$formHTML->addContent( $html );


		$this->content = $formHTML->make();
		return true;

	}






	private function _renderPriceSearchLinks($lid,$name,$value,$goHTml='') {

		$curencySymbol = WPref::load( 'PCURRENCY_NODE_CODESYMBOL' );
		$hasSymbol = ( in_array( $curencySymbol, array( 'symbol', 'money', 'moneyCode' ) ) ? true : false );
		$hasCode = ( in_array( $curencySymbol, array( 'code', 'moneyNoSymbol', 'moneyCode' ) ) ? true : false );

		$html = '<div class="input-group piceValue">';
		if ( $hasSymbol ) {				$html .= '<span class="input-group-addon">' . WTools::format( 1, 'currencySymbol' ) . '</span>';
		}
		$html .= '<input class="form-control priceInput" id="' . $lid . '" type="text" maxlength="7" name="' . $name . '" value="' . $value . '">';
		if ( $hasCode ) {				$html .= '<span class="input-group-addon">' . WTools::format( 1, 'currencyCode' ) . '</span>';
		}
		if ( !empty($goHTml) ) $html .= $goHTml;
		$html .= '</div>';

		return $html;

	}






	private function _renderPriceFormHTML($lid) {

				$name = 'advsearch[' . self::$complexMapA[$lid]  . ']';
		$defaultValue = WGlobals::getUserState( self::$complexSearchIdA[$lid] , self::$complexMapA[$lid], '', 'array', 'advsearch' );

		$html = '<div class="input-group"><span class="input-group-addon">' . WTools::format( 1, 'currencySymbol' ) . '</span><input size="7" id="srchwz_'.$lid.'" class="form-control inputbox" type="text" value="'.$defaultValue.'" name="'.$name.'"/></div>';

		return $html;

	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null) {

		$lid = $element->lid . '-s';
				$this->createComplexIds( $lid, $element->map . '_' . $element->sid . '-s' );
		Output_Doc_Document::$advSearchHTMLElementIdsA[$lid] = 'srchwz_' . $lid;


				$addFitler = true;
		$range = false;

		if ( !empty($searchedTerms) ) {
			$defaultValue = $searchedTerms;

			$isStart = substr( $element->lid, -2 );
			if ( '-e' == $isStart ) $addFitler = false;
			$range = true;

		} else {
			$defaultValue = WGlobals::getUserState( self::$complexSearchIdA[$lid], self::$complexMapA[$lid], 0, 'array', 'advsearch' );
		}

		$curid = WUser::get( 'curid' );
		$PCURRENCY_NODE_PREMIUM = WPref::load('PCURRENCY_NODE_PREMIUM');
		if ( $PCURRENCY_NODE_PREMIUM != $curid ) {
			$currencyConvertC = WClass::get( 'currency.convert',null,'class',false);
			$defaultValue = $currencyConvertC->currencyConvert( $curid, $PCURRENCY_NODE_PREMIUM, $defaultValue, false );
		}
		if ( $addFitler && !empty($defaultValue) && is_numeric($defaultValue) ) {
			if ($range) $model->where( $element->map, '>=', $defaultValue, $element->asi );
			else $model->whereSearch( $element->map, $defaultValue, $element->asi, '>=', $operator );
		}

		$lid = $element->lid . '-e';
				$this->createComplexIds( $lid, $element->map . '_' . $element->sid . '-e' );
		Output_Doc_Document::$advSearchHTMLElementIdsA[$lid] = 'srchwz_' . $lid;

		$addFitler = true;
		if ( !empty($searchedTerms) ) {
			$defaultValue = $searchedTerms;
						$isStart = substr( $element->lid, -2 );
			if ( '-s' == $isStart ) $addFitler = false;
			$range = true;
		} else {
			$defaultValue = WGlobals::getUserState( self::$complexSearchIdA[$lid], self::$complexMapA[$lid], 0, 'array', 'advsearch' );
		}

		if ( $PCURRENCY_NODE_PREMIUM != $curid ) {
			$currencyConvertC = WClass::get( 'currency.convert',null,'class',false);
			$defaultValue = $currencyConvertC->currencyConvert( $curid, $PCURRENCY_NODE_PREMIUM, $defaultValue, false );
		}
		if ( $addFitler && !empty($defaultValue) && is_numeric($defaultValue) ) {
			if ( $range ) $model->where( $element->map, '<=', $defaultValue, $element->asi );
			else $model->whereSearch( $element->map, $defaultValue, $element->asi, '<=', $operator );
		}
	}

}