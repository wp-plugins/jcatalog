<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'listing.datetime' );
class WListing_Coredateonly extends WListing_datetime {

	protected $dateFormat='dateonly';





	function create(){
		$this->noTimeZone=true;
		return parent::create();
	}}

