<?php 

* @link joobi.co
* @license GNU GPLv3 */


class Mailbox_Savemessage_type extends WTypes {
	var $savemessage = array(
		0 => 'Do not keep the message in the database',
		1 => 'Only save the message if not identified properly',
		2 => 'Always save the message in the database'
	);
}