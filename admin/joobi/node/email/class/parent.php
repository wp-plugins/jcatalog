<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Email_Parent_class extends WClasses {


	protected $mailerInfoO=null;

	protected $sentError=null;

	function __construct(){
		parent::__construct();

		$this->mailerInfoO=new stdClass;
	}




	public function setUp(){
	}





	public function getMailerInformation(){
		return $this->mailerInfoO;
	}








	public function sendSMS($countryCode,$phoneNumber,$SMSMessage){
	}

	public function getSentError(){
		return $this->sentError;
	}
}