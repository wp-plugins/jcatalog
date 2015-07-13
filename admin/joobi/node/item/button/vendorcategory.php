<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreVendorcategory_button extends WButtons_external {
function create() {



	if ( WRoles::isNotAdmin( 'storemanager' ) && ! WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' ) ) return false;



	return parent::create();



}}