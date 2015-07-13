<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_mailbox_preferences {
public $deletemsg=180;
public $deletestats=360;
public $identifyemail='youremail@yourdomain.com';
public $maxemails=50;
public $opentimeout=10;
public $regexbounce='deliver|daemon|fail|system|return|impos';
public $trashdelmsg=30;
}
class Role_mailbox_preferences {
public $deletemsg='manager';
public $deletestats='manager';
public $identifyemail='manager';
public $maxemails='manager';
public $opentimeout='manager';
public $regexbounce='manager';
public $trashdelmsg='manager';
}