<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_CoreParentname_listing extends WListings_default{


	function create() {





		$parent = WGlobals::get( 'picklistParent', 0, 'global' );

		if ( empty($parent) ) return false;





		static $picklistP = null;



		if ( !isset($picklistP) ) $picklistP = WView::picklist( $parent );



		$value = $this->getValue( 'parent' );



		$this->content = $picklistP->getName( $value );



		return true;



	}}