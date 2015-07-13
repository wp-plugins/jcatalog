<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



class Design_element_class extends WClasses {









	public function toggleFieldState($yid,$fdid) {



		
		$designViewfieldsM = WModel::get( 'design.viewfields' );

		$designViewfieldsM->whereE( 'fdid', $fdid );

		$designViewfieldsM->whereE( 'yid', $yid );

		$exist = $designViewfieldsM->exist();



		if ( $exist ) {

			$designViewfieldsM->whereE( 'fdid', $fdid );

			$designViewfieldsM->whereE( 'yid', $yid );

			$designViewfieldsM->delete();



			
			$this->_unPublish( $yid, $fdid );

			$value = 0;



		} else {



			$designViewfieldsM->setVal( 'fdid', $fdid );

			$designViewfieldsM->setVal( 'yid', $yid );

			$designViewfieldsM->insert();



			
			$this->_publishElementForField( $yid, $fdid );



			$value = 1;

		}


		return $value;



	}
















	public function updateParent($yid,$fdid,$parentId) {





		
		$designViewfieldsM = WModel::get( 'design.viewfields' );

		$designViewfieldsM->whereE( 'fdid', $fdid );

		$designViewfieldsM->whereE( 'yid', $yid );

		$exist = $designViewfieldsM->exist();



		if ( $exist ) {

			
			$designViewfieldsM->whereE( 'fdid', $fdid );

			$designViewfieldsM->whereE( 'yid', $yid );

			$designViewfieldsM->setVal( 'parent', $parentId );

			$designViewfieldsM->update();



			
			$table = $this->_viewTableType( $yid );



			$libraryViewElementM = WModel::get( 'library.view' . $table );

			$libraryViewElementM->whereE( 'yid', $yid );

			$libraryViewElementM->whereE( 'fdid', $fdid );

			$libraryViewElementM->setVal( 'parent', $parentId );

			
			if ( 'forms' == $table ) {

				
				$libraryParentElementM = WModel::get( 'library.view' . $table );


				$libraryParentElementM->whereE( 'fid', $parentId );

				$area = $libraryParentElementM->load( 'lr', 'area' );


				$libraryViewElementM->setVal( 'area', $area );

			}




			$libraryViewElementM->update();



			
			$extensionHelperC = WCache::get();

			$extensionHelperC->resetCache( 'Views' );



		}


		return true;



	}




	public function updateEachParams($fdid) {



			
			$designModelfieldsC = WClass::get( 'design.modelfields' );

			$fieldid = $designModelfieldsC->loadFieldOnly( $fdid, 'fieldid' );




			$libraryViewM = WModel::get( 'design.viewfields' );

			$libraryViewM->whereE( 'fdid', $fdid );

			$yidA = $libraryViewM->load( 'lra', 'yid' );



			if ( empty($yidA) ) return false;



			
			
			foreach( $yidA as $yid ) {

				$newParamsA = $this->_getParamsForElement( $yid, $fdid, $fieldid );

				if ( empty($newParamsA) ) continue;



				$table = $this->_viewTableType( $yid );

				$libraryViewElementM = WModel::get( 'library.view' . $table );

				$libraryViewElementM->whereE( 'yid', $yid );

				$libraryViewElementM->whereE( 'fdid', $fdid );

				$libraryViewElementM->setVal( 'params', implode( "\n", $newParamsA ) );

				$libraryViewElementM->update();



			}


	}
























	public function getModelFieldParams($yid,$fdid,$fieldid) {




		$newParamsO = $this->_loadAllowedCurrentParams( $yid, $fdid, $fieldid );




		$newParamsA = array();

		
		if ( !empty($newParamsO) ) {

			foreach( $newParamsO as $oneK1 => $oneV1 ) {

				$newParamsA[] = $oneK1 . '=' . $oneV1;

			}
		}


		return $newParamsA;



	}


















	public function addSearchableListingElement($sid,$fdid,$dbcid,$column,$advanceSaerch=false) {



		
		$libraryViewElementM = WModel::get( 'library.viewlistings' );

		$libraryViewElementM->whereE( 'sid', $sid );

		$libraryViewElementM->whereE( 'map', $column );

		if ( $advanceSaerch ) $libraryViewElementM->setVal( 'advsearch', 1 );

		else $libraryViewElementM->setVal( 'search', 1 );

		$libraryViewElementM->update();



		$allSIDA = array();

		$allSIDA[] = $sid;




		
		$allFields = true;



		if ( $allFields ) {

			
			$libraryModelM = WModel::get( 'library.model' );

			$libraryModelM->makeLJ( 'library.model', 'dbtid', 'dbtid' );

			$libraryModelM->select( 'sid' );

			$libraryModelM->whereE( 'sid', $sid, 1 );

			$allA = $libraryModelM->load( 'lra' );



			if ( !empty($allA) && is_array($allA) ) $allSIDA = array_merge( $allSIDA, $allA );



		}




		
		
		$libraryViewM = WModel::get( 'library.view' );

		$libraryViewM->whereIn( 'sid', $allSIDA );

		$libraryViewM->whereE( 'type', 2 );

		$libraryViewM->whereE( 'fields', 1 );

		$allViewsA = $libraryViewM->load( 'lra', 'yid' );



		if ( empty($allViewsA) ) return true;



		
		$designCreateElementC = WClass::get( 'design.createlement' );

		foreach( $allViewsA as $oneView ) {

			
			$libraryViewM = WModel::get( 'library.viewlistings' );

			$libraryViewM->whereE( 'yid', $oneView );

			$libraryViewM->whereE( 'sid', $sid );

			$libraryViewM->whereE( 'map', $column );

			$viewWithMissingHiddenA = $libraryViewM->load( 'lra', 'yid' );



			if ( empty($viewWithMissingHiddenA) ) {

				$designCreateElementC->listingElement( $oneView, $fdid, true );

			}


		}


	}
















	public function setUnSearchableListingElement($sid,$dbcid,$column,$advanceSaerch=false) {



		
		$libraryViewElementM = WModel::get( 'library.viewlistings' );

		$libraryViewElementM->whereE( 'sid', $sid );

		$libraryViewElementM->whereE( 'map', $column );

		if ( $advanceSaerch ) $libraryViewElementM->setVal( 'advsearch', 1 );

		else $libraryViewElementM->setVal( 'search', 1 );

		$libraryViewElementM->update();



		return true;



	}




















	private function _getParamsForElement($yid,$fdid,$fieldid) {



		$table = $this->_viewTableType( $yid );



		
		$libraryViewElementM = WModel::get( 'library.view' . $table );

		$libraryViewElementM->whereE( 'yid', $yid );

		$libraryViewElementM->whereE( 'fdid', $fdid );

		$currentElementParams = $libraryViewElementM->load( 'lr', 'params' );



		$hasCurrent = false;

		if ( !empty($currentElementParams) ) {

			$existingParams = new stdClass;

			$existingParams->params = $currentElementParams;

			WTools::getParams( $existingParams );

			$hasCurrent = true;

	


		}




		
































		$newParamsO = $this->_loadAllowedCurrentParams( $yid, $fdid, $fieldid );



		if ( $hasCurrent ) {

			
			foreach( $existingParams as $eKey => $eVal ) {

				if ( !isset( $newParamsO->$eKey ) )	$newParamsO->$eKey = $eVal;

			}


		}


		$newParamsA = array();

		
		if ( !empty($newParamsO) ) {

			foreach( $newParamsO as $oneK1 => $oneV1 ) {

				$newParamsA[] = $oneK1 . '=' . $oneV1;

			}
		}




		return $newParamsA;



	}
















	private function _loadAllowedCurrentParams($yid,$fdid,$fieldid) {


		$table = $this->_viewTableType( $yid );


		
		$designModelfieldsC = WClass::get( 'design.modelfields' );

		$fieldPs = $designModelfieldsC->loadFieldOnly( $fdid, 'params' );


		$fieldParams = new stdClass;

		$fieldParams->params = $fieldPs;

		WTools::getParams( $fieldParams );




		
		$mainParametersC = WClass::get( 'main.parameters' );

		$functionName = 'get'.$table.'ElementEditViewParams';

		$generalAllowedA = $mainParametersC->$functionName();





		
		$designFieldsC = WClass::get( 'design.fields' );


		$specificAllowedA = $designFieldsC->getFieldParams( $fieldid, substr( $table, 0, -1 ) );



		
		if ( empty($specificAllowedA) ) {

			$allowedA = $generalAllowedA;

		} else {

			$allowedA = array_merge( $generalAllowedA, $specificAllowedA );

		}



		$newParamsO = new stdClass;

		
		foreach( $fieldParams as $oneFieldParamKey => $oneFieldParamV ) {

			if ( in_array( $oneFieldParamKey, $allowedA ) ) $newParamsO->$oneFieldParamKey = $oneFieldParamV;

		}




		return $newParamsO;

	}
















	private function _publishElementForField($yid,$fdid) {



		$exist = $this->_checkFieldExist( $yid, $fdid );



		if ( ! $exist ) {

			
			$this->_createField( $yid, $fdid );



		} else {



			
			$table = $this->_viewTableType( $yid );




			
			
			$designViewfieldsM = WModel::get( 'design.modelfields' );


			$designViewfieldsM->whereE( 'fdid', $fdid );

			$fieldsINfoO = $designViewfieldsM->load( 'o', array( 'updateall', 'fieldid' ) );




			$newParamsA = array();



			if ( !empty($fieldsINfoO) && !empty($fieldsINfoO->updateall) ) {



				$newParamsA = $this->_getParamsForElement( $yid, $fdid, $fieldsINfoO->fieldid );



			}


			$libraryViewElementM = WModel::get( 'library.view' . $table );




			$libraryViewElementM->whereE( 'yid', $yid );

			$libraryViewElementM->whereE( 'fdid', $fdid );

			$libraryViewElementM->setVal( 'publish', 1 );

			$libraryViewElementM->setVal( 'hidden', 0 );		
			if ( !empty($newParamsA) ) $libraryViewElementM->setVal( 'params', implode( "\n", $newParamsA ) );

			$libraryViewElementM->update();



		}


		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );





		return true;



	}




















	private function _unPublish($yid,$fdid) {



		$table = $this->_viewTableType( $yid );



		$libraryViewElementM = WModel::get( 'library.view' . $table );

		$libraryViewElementM->whereE( 'yid', $yid );

		$libraryViewElementM->whereE( 'fdid', $fdid );

		$libraryViewElementM->setVal( 'publish', 0 );

		$libraryViewElementM->update();





		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );



		return true;



	}








	private function _createField($yid,$fdid) {



		$table = $this->_viewTableType( $yid );



		if ( $table == 'listings' ) {

			$designCreateElementC = WClass::get( 'design.createlement' );

			$designCreateElementC->listingElement( $yid, $fdid );

		} else {

			$designCreateElementC = WClass::get( 'design.createlement' );

			$designCreateElementC->formElement( $yid, $fdid );

		}


	}






	private function _checkFieldExist($yid,$fdid) {



		$table = $this->_viewTableType( $yid );



		$libraryViewElementM = WModel::get( 'library.view' . $table );


		$libraryViewElementM->whereE( 'yid', $yid );

		$libraryViewElementM->whereE( 'fdid', $fdid );

		return $libraryViewElementM->exist();



	}






	private function _viewTableType($yid) {



		$type = WView::get( $yid, 'type' );



		if ( $type == 2 ) {

			
			$layout = 'listings';

		} else {

			
			$layout = 'forms';

		}


		return $layout;

	}




}