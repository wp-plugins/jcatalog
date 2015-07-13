<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_comment_preferences {
public $allowreply=1;
public $cmtapproval=0;
public $cmtarticle=1;
public $cmtaverating=1;
public $cmtcharlength=500;
public $cmtdate=1;
public $cmtnonorreg=1;
public $cmtnotifyadmin=1;
public $cmtnotifyauthor=1;
public $cmtnotifyemail='';
public $cmtorder='';
public $cmtrating=1;
public $editor='';
public $getavatar=5;
}
class Role_comment_preferences {
public $allowreply='manager';
public $cmtapproval='admin';
public $cmtarticle='manager';
public $cmtaverating='manager';
public $cmtcharlength='manager';
public $cmtdate='manager';
public $cmtnonorreg='manager';
public $cmtnotifyadmin='manager';
public $cmtnotifyauthor='manager';
public $cmtnotifyemail='manager';
public $cmtorder='manager';
public $cmtrating='manager';
public $editor='manager';
public $getavatar='admin';
}