<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'users.addon.joomla.joomla', JOOBI_DS_NODE );
class Users_Joomla16_addon extends Users_Joomla_addon {

	function getPicklistElement(){
		$joomla=new stdClass;
		$joomla->option='joomla';
		$joomla->label='Joomla';
		$joomla->extension='com_users';
		return $joomla;
	}	
}