<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');







class Design_createlement_class extends WClasses {















	public function formElement($yid,$fdid) {




		
		$designModelfieldsC = WClass::get( 'design.modelfields' );

		$fieldO = $designModelfieldsC->loadField( $fdid );

		if ( empty($fieldO) ) return false;



		
		$designViewFormM = WModel::get( 'design.viewforms' );



		$designViewFormM->yid = $yid;

		$designViewFormM->setChild( 'design.viewformstrans', 'name', $fieldO->name );

		$designViewFormM->setChild( 'design.viewformstrans', 'description', $fieldO->description );

		$designViewFormM->core = 0;

		$designViewFormM->publish = 1;

		$designViewFormM->fdid = $fdid;

		$designViewFormM->sid = $this->_getCorrectSID( $fieldO, $yid );	
		$designViewFormM->namekey = WView::get( $yid, 'namekey' ) . '_custom_' . WModel::get( $designViewFormM->sid, 'namekey' ) . '_' . $fieldO->column;

		

		$designViewFormM->map = $fieldO->column;

		$designViewFormM->type = $fieldO->form;

		$designViewFormM->required = $fieldO->required;





		
		$typeView = WView::get( $yid, 'type' );

		if ( $typeView ==51 ) {

			$designViewFormM->rolid = $fieldO->rolid_edit;

		} else {

			$designViewFormM->rolid = $fieldO->rolid;

		}


		
		
		$trucsA = WGlobals::get( 'trucs' );

		$sidFromTrucs = WModel::get( 'design.modelfields', 'sid' );

		if ( !empty($trucsA[$sidFromTrucs]['x']) ) {

			
			$insertArrayA = array();

			foreach( $trucsA[$sidFromTrucs]['x'] as $oneV ) {

				if ( empty($oneV) ) continue;

				$insertArrayA[] = true;

			}
			
			if ( !empty($insertArrayA) ) $designViewFormM->checktype = 1;

		}




		
		$viewElementM = WModel::get( 'library.viewforms' );

		$viewElementM->whereE( 'yid', $yid );

		$viewElementM->whereE( 'parentdft', 1 );

		$parentInfoO = $viewElementM->load( 'o', array( 'fid', 'ordering', 'area' ) );



		if ( empty($parentInfoO) ) {

			$parentInfoO = new stdClass;

			$parentInfoO->fid = 0;

			$parentInfoO->ordering = 0;

			$parentInfoO->area = '';

		}


		$designViewFormM->parent = $parentInfoO->fid;

		$designViewFormM->area = $parentInfoO->area;



		$designViewFormM->ordering = $fieldO->ordering + $parentInfoO->ordering + 10;	


		
		
		if ( !empty($fieldO->initialvalue) ) $designViewFormM->initial = $fieldO->initialvalue;

		
		
		$designElementC = WClass::get( 'design.element' );

		$fieldParamsA = $designElementC->getModelFieldParams( $yid, $fdid, $fieldO->fieldid );



		if ( !empty($fieldParamsA) ) $designViewFormM->params = implode( "\n", $fieldParamsA );

		$designViewFormM->save();



	}
















	public function listingElement($yid,$fdid,$hidden=false) {



		
		$designModelfieldsC = WClass::get( 'design.modelfields' );

		$fieldO = $designModelfieldsC->loadField( $fdid );

		if ( empty($fieldO) ) return false;




		




		
		$designViewListingM = WModel::get( 'design.viewlistings' );

		$designViewListingM->setIgnore();



		$designViewListingM->yid = $yid;

		$designViewListingM->setChild( 'design.viewlistingstrans', 'name', $fieldO->name );

		$designViewListingM->setChild( 'design.viewlistingstrans', 'description', $fieldO->description );

		$designViewListingM->core = 0;

		$designViewListingM->publish = 1;

		$designViewListingM->fdid = $fdid;

		$designViewListingM->sid = $this->_getCorrectSID( $fieldO, $yid );	
		$designViewListingM->map = $fieldO->column;

		$designViewListingM->search = $fieldO->searchable;

		$designViewListingM->advsearch = $fieldO->advsearchable;

		$designViewListingM->type = $fieldO->listing;

		if ( $hidden ) $designViewListingM->hidden = 1;





		$designViewListingM->rolid = $fieldO->rolid;



		
		$viewElementM = WModel::get( 'library.viewlistings' );

		$viewElementM->whereE( 'yid', $yid );

		$viewElementM->whereE( 'parentdft', 1 );

		$parentInfoO = $viewElementM->load( 'o', array('lid', 'ordering' ) );



		if ( empty($parentInfoO) ) {

			$parentInfoO = new stdClass;

			$parentInfoO->lid = 0;

			$parentInfoO->ordering = 0;

		}


		
		$designViewListingM->namekey = WView::get( $yid, 'namekey' ) . '_custom_' . WModel::get( $designViewListingM->sid, 'namekey' ) . '_' . $fieldO->column;



		$designViewListingM->parent = $parentInfoO->lid;



		$designViewListingM->ordering = $fieldO->ordering + $parentInfoO->ordering + 5;	




		$designElementC = WClass::get( 'design.element' );

		$fieldParamsA = $designElementC->getModelFieldParams( $yid, $fdid, $fieldO->fieldid );









		if ( !empty($fieldParamsA) ) $designViewListingM->params = implode( "\n", $fieldParamsA );





		$designViewListingM->save();





	}
















	private function _getCorrectSID($fieldO,$yid) {



		if ( !empty($fieldO->translate) ) {



			
			


			$sid = WView::get( $yid, 'sid' );




			if ( 20 == WModel::get( $sid , 'type' ) ) {	
				return $sid;

			} else {

				$modelName = WModel::get( $sid, 'namekey' );

				return WModel::get( $modelName . 'trans' , 'sid' );

			}


		} else {



			
			
			


			if ( WPref::load( 'PDESIGN_NODE_FIELDALLTABLE' ) ) {





				$sid = $this->_getRigthSID( $yid, $fieldO->sid );



				
				$namekey = WModel::get( $sid, 'namekey' );

				$namekeyA = explode( '.', $namekey );

				if ( count($namekeyA) <= 1 ) return $sid;





				


				
				$model = WModel::get( $fieldO->sid, 'namekey' );

				$modelA = explode( '.', $model );



				$sidView = WView::get( $yid, 'sid' );

				$modelView = WModel::get( $sidView, 'namekey' );

				$modelViewA = explode( '.', $modelView );



				if ( $modelA[0] != $modelViewA[0] ) {



					$finalModel = $modelViewA[0];

					if ( !empty($modelA[1]) ) $finalModel .= '.' . $modelA[1];



					return WModel::get( $finalModel, 'sid' );



				} else {

					return $this->_getRigthSID( $yid, $fieldO->sid );


				}


			} else {

				return $this->_getRigthSID( $yid, $fieldO->sid );


			}





		}




	}
















	private function _getRigthSID($yid,$fieldSID) {



		$sid = WView::get( $yid, 'sid' );

		


		$field = WModel::get( $sid, 'fields' );



		if ( $field ) {

			return $sid;

		} else {

			return $fieldSID;

		}


	}






}