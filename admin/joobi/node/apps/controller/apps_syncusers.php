<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_syncusers_controller extends WController {

function syncusers(){



	$CMSaddon=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.import' );

	$CMSaddon->importCMSUsers( true );


	$message=WMessage::get();
	$message->userS('1337190873HKCO');


	WPages::redirect( 'controller=users' );


	return true;

}
}