<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Currency_CoreExample_listing extends WListings_default{










function create() {



	$this->content = WTools::format( 129.35 , 'money', $this->value );

	return true;



















}}