<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_module_cache_controller extends WController {








function cache() {



	$ext=WCache::get();

	$ext->resetCache();

	WPages::redirect('previous');



	return true;

}}