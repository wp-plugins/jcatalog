<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Email_Mailer_type extends WTypes {

public $mailer=array(


	'phpmail'=> 'PHP Mail Function',

	'sendmail'=> 'SendMail',

	'qmail'=> 'QMail',

	'smtp'=> 'SMTP Server'

);
}