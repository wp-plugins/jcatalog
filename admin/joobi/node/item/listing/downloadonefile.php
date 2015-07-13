<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreDownloadonefile_listing extends WListings_default{


function create() {



	$filid = $this->getValue( 'filid' );

	$myKey = WTools::randomString( 100, false );

	WGlobals::setSession( 'order', 'secretKey-' . $filid, md5( $myKey . JOOBI_SITE_TOKEN . $filid ) );



	
	$link = WPage::routeURL( 'controller=item&task=downloadall&bfrhead=1&eid='. $filid . '&secretkey=' . $myKey, '', false, false, true, null, true );



	$this->content = '<a target="_blank" href="'.$link.'">'.WText::t('1206961905BHAV').'</a>';



	return true;



}}