<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');
 class Translation_Updatelang_controller extends WController {





	function updatelang(){

		$message=WMessage::get();
		$message->userS('1213107637HXCR');
		$langM=WClass::get('translation.helper');
		return $langM->updateLanguages();

	}
}