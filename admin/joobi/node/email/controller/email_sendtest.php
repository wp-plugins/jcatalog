<?php 

* @link joobi.co
* @license GNU GPLv3 */

 class Email_Sendtest_controller extends WController {












	function sendtest(){



		$previewClass=WClass::get('email.preview');

		$previewClass->preview();

		$previewClass->sendTestEmail();



	}
}