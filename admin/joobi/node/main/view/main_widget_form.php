<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_Main_widget_form_view extends Output_Forms_class {

	function prepareView() {



		if ( $this->getValue( 'framework_type' ) != 5 ) {

			$this->removeElements( array( 'main_widget_form_position_fieldset', 'main_widget_form_position', 'main_widget_form_ordering' ) );

		}


		return true;



	}
}