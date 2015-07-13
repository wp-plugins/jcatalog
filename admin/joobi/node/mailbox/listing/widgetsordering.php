<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


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