<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Mailbox_CoreAssign_listing extends WListings_default{


	





	function create() {



		$wid = $this->getValue( 'wid', 'apps' ); 
		$inbid=WGlobals::get('inbid'); 


		if ( !$this->value ) {

			$assign='<span style="color:red">'.WText::t('1206732372QTKJ').'</span>';

		}

		else {

			$assign='<span style="color:green">'.WText::t('1206732372QTKI').'</span>';

		}

		$link = WPage::routeURL('controller=mailbox-plugin&task=assign&wid='.$wid.'&inbid='.$inbid);

		$this->content = '<a href="'. $link .'">' .$assign.'</a>';



		return true;

	}}