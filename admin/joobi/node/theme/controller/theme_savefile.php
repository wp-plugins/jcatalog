<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_savefile_controller extends WController {

	function savefile(){



		$themeC=WClass::get( 'theme.helper' );

		$themeC->overwriteThemeFile();



		return true;

	}
}