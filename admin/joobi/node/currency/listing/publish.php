<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Currency_CorePublish_listing extends WListings_default{


	function create() {

		$output='';



		$map=$this->mapList['curid'];

		$curid=$this->data->$map;

		$map=$this->mapList['curid_ref'];

		$curid_ref=$this->data->$map;

		$map=$this->mapList['publish'];

		$publish=$this->data->$map;



		$output='<a href="'.WPage::routeURL('controller=currency-conversion&task=publish&curid='.$curid.'&curid_ref='.$curid_ref.'&publish='.$publish).'">';



		if ( $publish ) {
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'publish';
			$iconO->text = WText::t('1207306697RNMA');
			$output .= WPage::renderBluePrint( 'icon', $iconO );
		} else {
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'unpublish';
			$iconO->text = WText::t('1242282416HAQR');
			$output .= WPage::renderBluePrint( 'icon', $iconO );
		}

		$output .= '</a>';



		$this->content = $output;

		return true;

	}







}