<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Project_Roleid_filter {
function create() {


	$rolidA = array();

	
	$roleHelper = WRole::get();
	$rolidA[] = $roleHelper->getRole( 'project_member', 'rolid' );
	$rolidA[] = $roleHelper->getRole( 'project_manager', 'rolid' );

	return $rolidA;

}}