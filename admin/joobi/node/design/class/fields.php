<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



class Design_Fields_class extends WClasses {





















	public function createField($modelID,$column,$fieldType='output.text',$usePrefix=true) {



		$designFieldsM = WModel::get( 'design.fields' );


		$designFieldsM->whereE( 'namekey', $fieldType );

		$fieldid = $designFieldsM->load( 'lr' );

		if ( empty($fieldid) ) return false;



		$designViewfieldsM = WModel::get( 'design.modelfields' );

		$designViewfieldsM->s( 'usePrefix', $usePrefix );


		$designViewfieldsM->sid = WModel::get( $modelID, 'sid' );

		$designViewfieldsM->column = $column;

		$designViewfieldsM->fieldid = $fieldid;

		$status = $designViewfieldsM->save();



		return $status;



	}
















	public function loadDefaultColumn($fieldid) {



		if ( empty($fieldid) ) return false;


		$fieldO = $this->_loadFields( $fieldid );




		$designColumnsM = WModel::get( 'design.columns' );

		if ( empty($fieldO) ) {








			$message = WMessage::get();

			$message->historyE('1356698577BYSZ');

		} else {

			$designColumnsM->type = ( !empty($fieldO->columntype) ? $fieldO->columntype : '' );

			$designColumnsM->mandatory = ( !empty($fieldO->columnmamdatory) ? $fieldO->columnmamdatory : 0 );

			$designColumnsM->default = ( !empty($fieldO->columndefault) ? $fieldO->columndefault : '' );

			$designColumnsM->attributes = ( !empty($fieldO->columnattributes) ? $fieldO->columnattributes : '' );

			$designColumnsM->size = ( !empty($fieldO->columnsize) ? $fieldO->columnsize : 0 );



		}


		$designColumnsM->checkval = true;

		$designColumnsM->core = false;

		$designColumnsM->pkey = false;

		$designColumnsM->extra = false;

		$designColumnsM->export = false;



		return $designColumnsM;



	}














	public function load($fieldid,$returnField=null) {

		if ( empty($fieldid) ) return false;

		$fieldO = $this->_loadFields( $fieldid );

		if ( empty($returnField) ) return $fieldO;



		if ( isset($fieldO->$returnField) )	return $fieldO->$returnField;

		return null;

	}
















	public function getFieldParams($fieldid,$typeRequired) {

		if ( empty($fieldid) || empty($typeRequired) ) return false;



		$fieldO = $this->_loadFields( $fieldid );



		if ( $typeRequired=='form' ) {

			$fieldName = $fieldO->form;		
		} elseif ( $typeRequired=='listing' ) {

			$fieldName = $fieldO->listing;

		} else {

			return false;

		}


		$fieldNameA = explode( '.', $fieldName );

		$viewNamekey = $fieldNameA[0] . '_params_' . $typeRequired . '_' . str_replace( '.', '_', $fieldName );




		
		
		
		
		
		
		if ( 'output_params_listing_output_selectone' == $viewNamekey ) {	
			$viewNamekey = 'output_params_form_output_select';

		}



		$viewInstance = WView::get( $viewNamekey, 'html', null, null, false );

		if ( empty($viewInstance->elements) ) return false;



		$fieldParamsA = array();

		foreach( $viewInstance->elements as $oneElement ) {

			if ( substr($oneElement->map, 0, 2) == 'p[' ) {

				$fieldParamsA[] = substr($oneElement->map, 2, -1 );

			}
		}


		return $fieldParamsA;



	}




















	public function getFieldParamsDefaultValues($fieldid,$typeRequired) {

		if ( empty($fieldid) || empty($typeRequired) ) return false;



		$fieldParamsA = $this->getFieldParams( $fieldid, $typeRequired );

		$fieldO = $this->_loadFields( $fieldid );

		if ( !empty($fieldParamsA) ) {

			$paramsA = array();

			foreach( $fieldParamsA as $oneP ) {

				if ( !empty($fieldO->$oneP) ) {

					$paramsA[] = ( $oneP . '=' . $fieldO->$oneP );

				}
			}
			return $paramsA;

		}


		return false;



	}
















	public function togglePublish($fdid,$state) {



		
		$designViewformsM = WModel::get( 'design.viewforms' );


		$designViewformsM->whereE( 'fdid', $fdid );

		$designViewformsM->setVal( 'publish', $state );

		$designViewformsM->update();



		$designViewlistingM = WModel::get( 'design.viewlistings' );


		$designViewlistingM->whereE( 'fdid', $fdid );

		$designViewlistingM->setVal( 'publish', $state );

		$designViewlistingM->update();



		




		return true;



	}
















	private function _loadFields($fieldid) {

		static $fieldsA = array();



		if ( empty($fieldid) ) return false;



		if ( !isset( $fieldsA[$fieldid] ) ) {

			$designFieldsM = WModel::get( 'design.fields' );



			if ( is_numeric( $fieldid ) ) {

				$designFieldsM->whereE( 'fieldid', $fieldid );

			} else {

				$designFieldsM->whereE( 'namekey', $fieldid );

			}




			$fieldO = $designFieldsM->load( 'o' );



			if ( !empty($fieldO) ) {

				WTools::getParams( $fieldO );

				$fieldsA[$fieldid] = $fieldO;

			}


		}


		if ( !empty($fieldsA[$fieldid]) ) return $fieldsA[$fieldid];

		return null;



	}


}