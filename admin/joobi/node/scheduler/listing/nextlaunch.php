<?php 

* @link joobi.co
* @license GNU GPLv3 */



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