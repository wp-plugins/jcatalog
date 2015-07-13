<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Ticket_my_add_controller extends WController {


function add() {

	





	
	$project = WGlobals::get( 'project' );

	if ( !empty( $project ) ) {

		$project = trim( $project );

		$projectM = WModel::get('project');

		$projectM->whereE( 'namekey', $project );

		$pjid = $projectM->load( 'lr', 'pjid' );

		WGlobals::set( 'pjid', $pjid );

	}


	

	return true;

	

}









































}