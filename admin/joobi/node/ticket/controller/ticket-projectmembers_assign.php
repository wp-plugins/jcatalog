<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_projectmembers_assign_controller extends WController {



function assign() {







	$uid = WGlobals::get('uid', 0 );

	$pjid = WGlobals::get('pjid', 0 );

	$level = WGlobals::get('level');

	$rolid = WGlobals::get('role');


	if ( empty($uid) && empty( $pjid) ) return true;



	$assignM=WModel::get('ticket.projectmembers');

	$assignM->whereE('pjid',$pjid);

	$assignM->whereE('uid',$uid);


	
	WGlobals::set( 'uid', null );

	WGlobals::set( 'level', null );



	if ( $level ) {	
		return $assignM->delete();

	} else {	
		$assignM->pjid = $pjid;

		$assignM->uid = $uid;

		$assignM->role=$rolid;

		$assignM->notify=1;

		$assignM->supportlevel = 1;

		return $assignM->save();

	}


	return true;



}}