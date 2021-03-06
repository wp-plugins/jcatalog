<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_Apps_listing_view extends Output_Listings_class {





	protected function prepareView(){


		if( ! WExtension::exist( 'main.node' )){
						$refresh=WClass::get( 'apps.refresh' );
			$refresh->firstRefresh();
		}


		$distribserver=WPref::load( 'PAPPS_NODE_DISTRIBSERVER' );

		if( $distribserver==11){

			
			$this->removeMenus( array( 'apps_listing_check', 'apps_listing_divider_check', 'apps_listing_updateall' ));



		}elseif( $distribserver==99){

			
			$message=WMessage::get();
			$BETA_SITE=WPref::load( 'PINSTALL_NODE_DISTRIB_WEBSITE_BETA' );	
			$message->userN('1377368277IDOY',array('$BETA_SITE'=>$BETA_SITE));

		}elseif( $distribserver==54){

			
			$message=WMessage::get();
			$DEV_SITE=WPref::load( 'PINSTALL_NODE_DISTRIB_WEBSITE_DEV' );

			$message->userN('1377368277IDOZ',array('$DEV_SITE'=>$DEV_SITE));

		}

				$allSweetB=false;
		$appsInfoC=WCLass::get( 'apps.info' );
		$status=$appsInfoC->getPossibleCode( 'notOne', array( 'token', 'subtype', 'supermaintCare' ));
		if( !$status ) $this->removeMenus( array( 'apps_listing_updateall' ));
		else {
						if( !empty($status->token)) $allSweetB=true;
		}
		$status=$appsInfoC->getPossibleCode( 'all', array( 'token', 'subtype', 'supermaintCare' ));

				WGlobals::set( 'sweetClubTimeFree', WExtension::get( JOOBI_MAIN_APP . '.application', 'created' ));


		if( is_bool($status)){
						$LINK2CLUB='<a target="_blank" href="https://www.joobi.co/r.php?l=club">' . WText::t('1389656307QIHM') . '</a>';
			$message=WMessage::get();
			$message->userN('1389656307QIHN',array('$LINK2CLUB'=>$LINK2CLUB));


		}else{
			if( $allSweetB ) WGlobals::set( 'sweetClub', true );
			if( !empty($status->subtype)){
				WGlobals::set( 'sweetClubType', $status->subtype );
				WGlobals::set( 'sweetClubTime', $status->supermaintCare );
			}		}


		return true;



	}
}