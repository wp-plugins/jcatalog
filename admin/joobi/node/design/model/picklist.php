<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Picklist_model extends WModel {


	function addValidate() {



		
		if ( empty( $this->type ) ) $this->type = 1;



		
		if ( empty( $this->publish ) ) $this->publish = 1;





		
		$this->core = 0;



	
		if ( !empty( $this->x['sidmemory']) ) {

			$this->sid = $this->x['sidmemory'];

		}


		
		if ( !empty( $this->sid ) ) {

			$modelName = WModel::get( $this->sid, 'namekey' );

			$this->wid = WExtension::get( $modelName, 'wid' );

	
	
	
		}




		if ( empty( $this->wid ) ) $this->wid = WExtension::get( 'design.node', 'wid' );



		
		if ( empty( $this->namekey ) ) $this->namekey = str_replace( '.', '_', WExtension::get( $this->wid, 'namekey' ) ) . '_' . WGlobals::filter( $this->getChild( 'design.picklisttrans', 'name' ), 'alnum' );

		$this->namekey = strtolower( $this->namekey );





		return true;



	}





	function validate() {

				if ( !empty( $this->parent ) ) {
			$picklistM = WModel::get( 'library.picklist' );
			$picklistM->whereE( 'namekey', $this->parent );
			$picklistM->setVal( 'isparent', 1 );
			$picklistM->update();
		}
		return true;

	}

}