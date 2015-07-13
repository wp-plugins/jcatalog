<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_files_preferences {
public $jwplayer=1;
public $jwplayerkey='';
public $s3_accesskey='';
public $s3_bucket='';
public $s3_classtype='standard';
public $s3_secretkey='';
public $s3_weburl='s3.amazonaws.com';
}
class Role_files_preferences {
public $jwplayer='manager';
public $jwplayerkey='manager';
public $s3_accesskey='admin';
public $s3_bucket='admin';
public $s3_classtype='admin';
public $s3_secretkey='admin';
public $s3_weburl='admin';
}