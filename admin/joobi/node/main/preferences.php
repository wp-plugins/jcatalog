<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_main_preferences {
public $categorycollapse=0;
public $chart_x_size=450;
public $chart_y_size=350;
public $clearcache=604800;
public $clearcachefreq=0;
public $dateformat=0;
public $direct_access=0;
public $direct_edit=0;
public $direct_edit_modules=1;
public $direct_translate=0;
public $frameworkcontent=1;
public $optimizedb=1;
public $showconfig=1;
public $showhiddenview=0;
public $showviewsdetails=1;
}
class Role_main_preferences {
public $categorycollapse='admin';
public $chart_x_size='admin';
public $chart_y_size='admin';
public $clearcache='admin';
public $clearcachefreq='allusers';
public $dateformat='admin';
public $direct_access='admin';
public $direct_edit='admin';
public $direct_edit_modules='manager';
public $direct_translate='admin';
public $frameworkcontent='manager';
public $optimizedb='admin';
public $showconfig='admin';
public $showhiddenview='sadmin';
public $showviewsdetails='admin';
}