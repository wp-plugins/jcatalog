<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Email_Smtpsecure_type extends WTypes {


public $smtpsecure=array(

	0=> '- - -',

	'ssl'=> 'SSL',

	'tls'=> 'TLS',

);

}