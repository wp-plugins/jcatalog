<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_sendtest_controller extends WController {


















	function sendtest(){

		$this->skipMessage( true );

		$this->savepref();

		WPages::redirect( 'controller=apps&task=sendtestmessage' );

	}}