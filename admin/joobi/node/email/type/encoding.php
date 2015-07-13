<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Email_Encoding_type extends WTypes {

public $encoding=array(


	'binary'=> 'Binary',

	'quoted-printable'=> 'Quoted-printable',

	'7bit'=> '7 Bit',

	'8bit'=> '8 Bit',

	'base64'=> 'Base 64'

);
}