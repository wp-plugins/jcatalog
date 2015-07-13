<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_CoreInstup_button extends WButtons_external {










	function create(){

			$this->setAction( 'instup' );
			$this->setTitle( WText::t('1211280056BEZM'));

return true;




		$wid=WGlobals::getEID();



		$type=WExtension::get( $wid, 'type' );



		if( $type==350){



			$helper=WClass::get('apps.helper');

			$version=$helper->getCMSModuleVersionUsingWid($wid);

			$info=new stdClass;

			if($version){

				$info->version=(int)str_replace( array('.'), array('0'), $version );

			}else{

				$info->version=0;

			}


			$extensionM=WModel::get('apps');

			$extensionM->whereE( 'wid', $wid );

			$info->lversion=(int)$extensionM->load( 'lr','lversion');

			$info->level=0;

		}else{

			
			$appsShowC=WClass::get( 'apps.show' );

			$info=$appsShowC->checkInstalled( $wid );

		}


		if( empty($info) || $info->version !=$info->lversion){



			$appsInfoC=WCLass::get( 'apps.info' );

			$status=$appsInfoC->possibleUpdate( $wid );



			if( !$status){

				return false;

			}

			















			
			$this->setAction( 'instup' );


			$this->setFullDisable();



			if( empty($info)) $this->setTitle( WText::t('1211280056BEZM'));

			else {
				$this->setTitle( WText::t('1227580898LIDX'));
			}

			return true;


		}else{

			return false;

		}


	}
}