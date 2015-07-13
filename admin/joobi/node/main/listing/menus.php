<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_CoreMenus_listing extends WListings_default{
function create() {



	$type = $this->getValue( 'type' );

	$yid = $this->getValue( 'yid' );

	$header = '&titleheader=' . $this->getValue( 'name' );



	switch ( $type ) {

		case 2: 
			$link = WPage::routeURL( 'controller=main-listing&yid=' . $yid . $header );

			break;

		case 51: 
		case 61: 		case 98: 		case 151: 
			$link = WPage::routeURL( 'controller=main-form&yid=' . $yid . $header );

			break;

		case 204: 
			$link = WPage::routeURL( 'controller=main-menu&yid=' . $yid . $header );

			break;





		default:

			$this->content = WText::t('1347652450ENIY');

			return true;

		break;



	}


	$this->content = '<a href="' . $link . '">' . WText::t('1206961869IGNG') . '</a>';



return true;

}}