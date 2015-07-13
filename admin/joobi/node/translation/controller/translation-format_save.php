<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_format_save_controller extends WController {

	function save(){



		
		$lgid=WController::getFormValue( 'lgid', 'library.languages' );
		if( empty($lgid)) return false;

				$languagesM=WModel::get( 'library.languages' );
		$languagesM->whereE( 'lgid', $lgid );
		$localeconv=$languagesM->load( 'lr', 'localeconv' );
			$localeconvO=unserialize( $localeconv );
	
		$trucs=WGlobals::get( 'trucs' );
		$XValuesA=$trucs['x'];
		foreach( $XValuesA as $oneKey=> $onePAram){

			if( $onePAram !=$localeconvO->$oneKey){
				$localeconvO->$oneKey=$onePAram;
			}
		}	
		$Newlocaleconv=serialize( $localeconvO );
			
		if( empty($Newlocaleconv)){
			$message=WMessage::get();
			$message->userE('1382065678OBIQ');
			return true;
		}
		$languagesM=WModel::get( 'library.languages' );
		$languagesM->whereE( 'lgid', $lgid );
		$languagesM->setVal( 'localeconv', $Newlocaleconv );
		$languagesM->setVal( 'core', 0 );


		$status=$languagesM->update();


		if( !empty($status)){
			$message=WMessage::get();
			$message->userS('1377884821GSJD');
		}
		$cache=WCache::get();
		$cache->resetCache( 'Language' );


		return $status;



	}
}