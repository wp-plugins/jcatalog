<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'listing.order' );
class Mailbox_Widgetsordering_listing extends WListing_order {







	function create(){

		static $myReferenceIdTable=array();



        if ( !empty( $this->myReferenceIdTable) ){

      		if ( empty($myReferenceIdTable) ) $myReferenceIdTable = $this->myReferenceIdTable;

		}


		if ( !$this->value ) {

			$this->content = " ";

			return true;

		} else {

			if ( empty( $this->myReferenceIdTable) ) $this->myReferenceIdTable = $myReferenceIdTable;

			return parent::create();

		}


	}
}