<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Email_Mailer_type extends WTypes {

public $mailer=array(


	'phpmail'=> 'PHP Mail Function',

	'sendmail'=> 'SendMail',

	'qmail'=> 'QMail',

	'smtp'=> 'SMTP Server'

);
}