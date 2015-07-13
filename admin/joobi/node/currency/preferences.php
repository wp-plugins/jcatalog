<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_currency_preferences {
public $addcurtobasket=0;
public $codesymbol='money';
public $conversionhistory=0;
public $dcurrid=1;
public $fee=3;
public $multicur=1;
public $multicuredit=1;
public $multicurlist=1;
public $premium=1;
public $store=1;
}
class Role_currency_preferences {
public $addcurtobasket='storemanager';
public $codesymbol='storemanager';
public $conversionhistory='storemanager';
public $dcurrid='allusers';
public $fee='storemanager';
public $multicur='storemanager';
public $multicuredit='storemanager';
public $multicurlist='storemanager';
public $premium='storemanager';
public $store='admin';
}