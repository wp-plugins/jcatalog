<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

require_once ABSPATH . WPINC . '/class-phpmailer.php';
class Joobi_Mailer extends PHPMailer {
		protected $_validMailer=true;
}