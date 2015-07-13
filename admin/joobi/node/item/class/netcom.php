<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'netcom.class.client' );
class Item_Netcom_class extends Netcom_Client_class {







	public $APIVersion = '1.0';







	public $APIUserID = 0;






	public $servicesCredentials = array(
		'importInsert' => 'vendors',
		'importUpdate' => 'vendors',
		'delete' => 'vendors',
		'export' => 'vendors'
	);







	public function importInsert($data) {

				if ( version_compare( $this->APIVersion, '1.0', '<=' ) ) {

			return $this->_usingImportFct( $data, false );

		} else {
			return $this->createResponseMessage( false, 'API version not supported' );
		}
	}





	public function importUpdate($data) {

				if ( version_compare( $this->APIVersion, '1.0', '<=' ) ) {

			return $this->_usingImportFct( $data, true );

		} else {
			return $this->createResponseMessage( false, 'API version not supported' );
		}
	}






	public function export($data) {

				if ( version_compare( $this->APIVersion, '1.0', '<=' ) ) {

			return $this->_usingExpotFct( $data, true );

		} else {
			return $this->createResponseMessage( false, 'API version not supported' );
		}
	}







	public function delete($data) {

WMessage::log( $data, 'webnserice-delete' );

				if ( version_compare( $this->APIVersion, '1.0', '<=' ) ) {

			if ( empty($data['id']) ) return $this->createResponseMessage( false, 'Item to delete not defined!' );

			$idsA = $data['id'];

WMessage::log( $idsA, 'webnserice-delete' );
WMessage::log( '$ids-end', 'webnserice-delete' );

			if ( !is_array($idsA) && is_string($idsA) ) $idsA = explode( ',', $idsA );


			if ( !is_array($idsA) ) $idsA = array( $idsA );
WMessage::log( '$idsA', 'webnserice-delete' );
WMessage::log( $idsA, 'webnserice-delete' );


			$itemM = WModel::get( 'item' );
			$status = false;
			if ( is_array($idsA) ) {
				$status = false;

				foreach( $idsA as $Onepid ) {

					if ( !is_numeric($Onepid) ) {
						$itemM->whereE( 'namekey', $Onepid );
					} else {
						$itemM->whereE( 'pid', $Onepid );
					}					$itemM->whereE( 'vendid', $this->APIUserID );
					$Onepid = $itemM->load( 'r', 'pid' );


					if ( !empty($Onepid) ) {
						$itemM->whereE( 'vendid', $this->APIUserID );
						$itemM->whereE( 'pid', $Onepid );
						$status = $status || $itemM->delete();
					} else {
											}
				}
			}

			if ( $status ) return $this->createResponseMessage( true, 'Successfully deleted data!' );
			else return $this->createResponseMessage( false, 'Error deleting data!' );

		} else {
			return $this->createResponseMessage( false, 'API version not supported' );
		}
	}








	private function _usingImportFct($data,$allowUpdate=false) {

				if ( empty( $this->APIUserID ) ) {
			return $this->createResponseMessage( false, 'Vendor could not be identified' );
		}
		if ( empty( $data ) ) {
			return $this->createResponseMessage( false, 'No data specified' );
		}
		$params = new stdClass;
		$params->error = false;
		$params->filetype = 'text/csv';
		$params->allowupdate = $allowUpdate;

		$header = '';
		$content = '';


				foreach( $data as $property => $value ) {
			$header .= $property . '|';

			if ( empty($value) ) $value = '';
			$content .= $value . '|';
		}

		$filecontent = $header . "\r" . $content;

		$importC = WClass::get( 'item.import' );
		$import = $importC->processItemImport( $params, $filecontent, $this->APIUserID );


		if ( $import ) {
			return $this->createResponseMessage( true, 'Successfully imported data!' );
		} else {
			return $this->createResponseMessage( false, 'An error occured while importing data.' );
		}
	}






	private function _usingExpotFct($data) {

				if ( empty( $this->APIUserID ) ) {
			return $this->createResponseMessage( false, 'Vendor could not be identified' );
		}
		if ( empty($data['itemType']) ) return $this->createResponseMessage( false, 'The item type need to be specified.' );

		$itemType = $data['itemType'];

		if ( !empty($data['columns']) ) {
			if ( !is_array($data['columns']) && is_string($data['columns']) ) $columnsA = explode( ',', $data['columns'] );
		} else {
			$columnsA = array();
		}
		if ( !empty($data['languageCode']) ) {
			$language = trim( $data['languageCode'] );
			$lgid = WLanguage::get( $language, 'lgid' );
			if ( empty($lgid) ) return $this->createResponseMessage( false, 'The language code was not regonized.' );
		} else {
			$lgid = 1;
		}


		$itemExportC = WClass::get( 'item.export' );
		$allItemA = $itemExportC->exportItems( $itemType, $columnsA, $lgid, $this->APIUserID );


		if ( !empty($allItemA) ) {

			$header = array_shift( $allItemA );
			$headerA = explode( '|', $header );
			$allExportedA = array();
			foreach( $allItemA as $oneItem ) {
				$itemA = explode( '|', $oneItem );
				$newItem = new stdClass;
				foreach( $itemA as $key => $oneVal ) {
					$porp = $headerA[$key];
					$newItem->$porp = $oneVal;
				}				$allExportedA[] = $newItem;

			}
			return $this->createResponseMessage( true, $allExportedA );
		} elseif ( $allItemA===false ) {
			return $this->createResponseMessage( false, 'An error occured while exporting data.' );
		} else {
			return $this->createResponseMessage( true, $allItemA );
		}
	}
}