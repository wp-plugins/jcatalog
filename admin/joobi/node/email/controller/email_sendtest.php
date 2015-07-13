<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Email_Sendtest_controller extends WController {












	function sendtest(){



		$previewClass=WClass::get('email.preview');

		$previewClass->preview();

		$previewClass->sendTestEmail();



	}
}