<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Space_members_assign_controller extends WController {




function assign() {







	$uid = WGlobals::get('uid', 0, 'get' );

	$wsid = WGlobals::get('wsid', 0, 'get' );

	$doit = WGlobals::get('doit', 0, 'get' );


	$assignM=WModel::get('space.members');

	$assignM->whereE('wsid',$wsid);

	$assignM->whereE('uid',$uid);




	if ( $doit ) {	
		return $assignM->delete();

	} else {	
		$assignM->wsid = $wsid;

		$assignM->uid = $uid;

		return $assignM->save();

	}




	return true;



}}