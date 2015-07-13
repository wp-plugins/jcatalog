<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_lang_save_controller extends WController {

	function save(){




		$status=parent::save();



		
		$cache=WCache::get();
		$cache->resetCache( array( 'Translation', 'Views', 'Language', 'Menus', 'Model' ));


		return $status;


	}
}