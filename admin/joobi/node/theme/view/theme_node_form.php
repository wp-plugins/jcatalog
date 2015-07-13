<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_Theme_node_form_view extends Output_Forms_class {

	function prepareView(){


		$allowTheme=WPref::load( 'PVENDORS_NODE_ALLOWTHEME' );
		if( WRoles::isNotAdmin( 'storemanager' ) && empty( $allowTheme )) return false;


		
		$type=$this->getValue( 'type' );

		if( !in_array( $type, array( 1, 201, 50 )) ) $this->removeElements( array( 'theme_node_form_tab_catalog' ));



		
		$skinsextraExist=WExtension::exist( 'skinsextra.application' );



		if( empty($skinsextraExist)){

			$this->removeElements( array(  'theme_node_form_image_skin' ));

		}


		return true;



	}
}