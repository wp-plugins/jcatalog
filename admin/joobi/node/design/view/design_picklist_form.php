<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Design_picklist_form_view extends Output_Forms_class {

	function prepareView() {



		$this->removeElements( array( 'design_picklist_form_type' ) );



		$did = $this->getValue( 'did' );

		if ( empty($did) ) {

			WGlobals::set( 'didvalues', 999999 );

		} else {

			WGlobals::set( 'didvalues', $did );

		}


		if ( $this->getValue( 'type' ) != 3 ) {

			$this->removeElements( array( 'design_picklist_form_code', 'design_picklist_form_code_extends', 'design_picklist_form_code_php' ) );

		} else {

			$this->removeElements( array( 'design_picklist_form_values', 'design_picklist_form_values_nested' ) );

		}



		return true;



	}

}