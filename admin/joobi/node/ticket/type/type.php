<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Type_type extends WTypes {


public $type = array(



	'10' => 'Feature Request',

	'20' => 'Bug Report',

	'100' => 'License Issue',
	'110' => 'Other Inquiries'



  );

}