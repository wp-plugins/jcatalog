<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_sendtest_controller extends WController {


















	function sendtest(){

		$this->skipMessage( true );

		$this->savepref();

		WPages::redirect( 'controller=apps&task=sendtestmessage' );

	}}