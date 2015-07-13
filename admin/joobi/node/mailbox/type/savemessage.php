<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Mailbox_Savemessage_type extends WTypes {
	var $savemessage = array(
		0 => 'Do not keep the message in the database',
		1 => 'Only save the message if not identified properly',
		2 => 'Always save the message in the database'
	);
}