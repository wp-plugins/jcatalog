<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_CoreSelectcheckout_listing extends WListings_default {
function create() {



	$selectedid = WGlobals::get('selectedid');

	$basketaddtype = WGlobals::get('basketaddtype');



	if ( $this->value == $selectedid ) {



		$iconO = WPage::newBluePrint( 'icon' );

		$iconO->icon = 'yes';

		$iconO->text = WText::t('1206732372QTKI');

		$display = WPage::renderBluePrint( 'icon', $iconO );



	} else {



		$iconO = WPage::newBluePrint( 'icon' );

		$iconO->icon = 'cancel';

		$iconO->text = WText::t('1206732372QTKJ');

		$display = WPage::renderBluePrint( 'icon', $iconO );



	}


	$link = 'controller=basket-address&task=selectaddress&selectedid='. $this->value .'&basketaddtype='. $basketaddtype;

	$this->content = '<a href="'. WPage::routeURL( $link ) .'">'. $display .'</a>';



	return true;



}}