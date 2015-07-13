<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_type_toggle_controller extends WController {

function toggle() {



	
	$cache = WCache::get();

	$cache->resetCache( 'Menus' );



	return parent::toggle();



}
}