<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Vendor_CoreCurr_listing extends WListings_default{




function create()

{

	$symbol = $this->getValue( 'symbol' );

	$this->content = $this->value .' ('. $symbol .')';



	return true;

}











}