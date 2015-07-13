<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Mailbox_Connection_type extends WTypes {

var $connection = array(
	'imap' => 'imap',
	'imap.pop3' => 'pop3',
	'imap.nntp' => 'nntp'
);
}