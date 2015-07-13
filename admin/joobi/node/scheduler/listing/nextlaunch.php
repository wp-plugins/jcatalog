<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.datetime' );
class Scheduler_CoreNextlaunch_listing extends WListing_datetime {
	function create(){


		if( $this->value < time()){

			$this->content='<span class="fontGreen">' . WText::t('1369751059DSKE') . '</span>';



		}else{

			return parent::create();

		}


		return true;



	}}