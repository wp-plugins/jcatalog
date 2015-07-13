<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_apps_preferences {
public $autocheckupdate=1;
public $beta=1;
public $distribserver=1;
public $domain=31;
public $firstrefresh=0;
public $home_site='http://www.joobi.co';
public $nextcheck=0;
public $notemail=1;
public $request='http://register.joobi.co';
}
class Role_apps_preferences {
public $autocheckupdate='admin';
public $beta='allusers';
public $distribserver='sadmin';
public $domain='allusers';
public $firstrefresh='allusers';
public $home_site='admin';
public $nextcheck='allusers';
public $notemail='admin';
public $request='allusers';
}