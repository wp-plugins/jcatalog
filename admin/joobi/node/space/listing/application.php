<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Space_CoreApplication_listing extends WListings_default{






function create() {

	$assign=false;



	$pjidREF = WGlobals::get( 'wsid' );



	$map=$this->mapList['wid'];

	$wid=$this->data->$map;



	$map=$this->mapList['wsid'];

	$wsid=$this->data->$map;



	$assign = ( $wsid==$pjidREF ) ? true : false;



	if ( $assign ) {

		$assignText='<span style="color:green">'.WText::t('1206732372QTKI').'</span>';

	}

	else {

		$assignText='<span style="color:red">'.WText::t('1206732372QTKJ').'</span>';

	}



	$link = WPage::routeURL('controller=space-applications&task=assign').'&wid='.$wid.'&wsid='.$pjidREF . '&doit='.(int)$assign ;

	$this->content = '<a href="'. $link .'">' .$assignText.'</a>';

	return true;




}























}