<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Mailbox_Secure_type extends WTypes {

			var $secure = array(
				0 => '- - -',
				'ssl' => 'SSL',
				'tls' => 'TLS',
  			);
}