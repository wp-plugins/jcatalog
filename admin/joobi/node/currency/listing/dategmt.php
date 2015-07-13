<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_CoreDategmt_listing extends WListings_default{


function create() {

	$this->content = WApplication::date( 'd F Y H:i \G\M\T O', $this->value);

	return true;

}



}