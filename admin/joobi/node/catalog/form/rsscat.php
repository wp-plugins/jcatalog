<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_CoreRsscat_form extends WForms_default {




	function show() {



		
		$catid = WGlobals::get('eid');


		$data = new stdClass;
		$data->type = 'rss';
		$data->link = WPage::link( 'controller=item-category&task=rss&catid=' . $catid . '&jdoctype=230' );
		$this->content = WPage::renderBluePrint( 'others', $data );


		return true;


	}
}