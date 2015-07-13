<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Project_members_assign_controller extends WController {
function assign() {



	$pjid = WGlobals::get( 'pjid' );

	$titleHeader = WGlobals::get( 'titleheader' );

	$uid = WGlobals::get( 'uid' );

	

	$projectMembersM = WModel::get( 'project.members' );

	$projectMembersM->whereE( 'uid', $uid );

	$projectMembersM->whereE( 'pjid', $pjid );

	$exist = $projectMembersM->exist();

	

	if ( $exist ) {

		$projectMembersM->whereE( 'uid', $uid );

		$projectMembersM->whereE( 'pjid', $pjid );

		$projectMembersM->delete();

	

	} else {

		$projectMembersM->setVal( 'uid', $uid );

		$projectMembersM->setVal( 'pjid', $pjid );

		$projectMembersM->setVal( 'role', 20 );

		$projectMembersM->setVal( 'notify', 1 );		

		$projectMembersM->insert();		



	

	

	}


	WPages::redirect( 'controller=project-members&task=listing&pjid=' . $pjid . '&titleheader=' . $titleHeader );

	return true;



}}