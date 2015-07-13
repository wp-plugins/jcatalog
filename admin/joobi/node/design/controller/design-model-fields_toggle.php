<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_model_fields_toggle_controller extends WController {


function toggle() {






	$task = WGlobals::get( 'task' );




	
	$sid = WModel::get( 'library.view', 'sid' );

	$map = 'yid_' . $sid;

	$yidA = WGlobals::get( $map );	


	$extensionHelperC = WCache::get();

	$extensionHelperC->resetCache( 'Views' );


	$property = $this->getToggleValue( 'map' );
	$value = $this->getToggleValue( 'value' );


	if ( empty( $yidA ) ) {



		$fdid = WGlobals::getEID();



		
		if ( $property == 'publish' && !empty($fdid) ) {



			$designFieldsC = WClass::get( 'design.fields' );

			$fieldParamsA = $designFieldsC->togglePublish( $fdid, $value );



		}


		
		return parent::toggle();



	}




	
	$yid = $yidA[0];



	$fdid = self::getFormValue( 'fdid', 'design.modelfields' );



	if ( empty($fdid) ) return false;



	if ( $property == 'parent' ) {



		if ( empty($yid) ) return false;



		
		$sid = WModel::get( 'design.viewfields', 'sid' );

		$map = 'dyna_parent_' . $sid;

		$parentId = WGlobals::get( $map );

		if ( !empty($parentId) ) $parentId = $parentId[$yid];





		if ( !empty($parentId) ) {

			


			
			$designElementC = WClass::get( 'design.element' );

			$designElementC->updateParent( $yid, $fdid, $parentId );



		}


		WPages::redirect( 'controller=design-model-fields&task=edit&eid=' . $fdid );

		return true;



	} elseif ( $property == 'fdid' ) {


		
		$this->setControllerSaveOrder();

		parent::save();



		if ( empty($yid) ) return false;



		$designElementC = WClass::get( 'design.element' );

		$value = $designElementC->toggleFieldState( $yid, $fdid );


		WPages::redirect( 'controller=design-model-fields&task=edit&eid=' . $fdid );



	}


	$status = parent::toggle();



	return $status;



}}