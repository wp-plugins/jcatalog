<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Ticketcategory_picklist extends WPicklist {














	function create() {



		$eid = WGlobals::getEID();

		$uid = WUser::get('uid');



		$ticketProjM = WModel::get( 'ticket.project' );

		$ticketProjM->makeLJ( 'ticket.projecttrans', 'pjid', 'pjid', 0, 1 );

		$ticketProjM->makeLJ( 'project.members', 'uid', 'uid', 0, 2 );

		$ticketProjM->select( 'name', 1 );

		$ticketProjM->select( array( 'pjid', 'parent' ) );

		$ticketProjM->whereLanguage( 1 );




		$ticketProjM->whereE( 'uid', $uid, 0, null, 1 );

		$ticketProjM->whereE( 'namekey', 'root', 0, null, 0, 0, 1 );			$ticketProjM->whereE( 'uid', $uid, 2, null, 0, 1, 1 );

		$ticketProjM->whereE( 'publish', 1 );

		$ticketProjM->orderBy( 'frontend' );

		$ticketProjM->checkAccess();


		if ( !empty($eid) ) $ticketProjM->where( 'pjid', '!=', $eid ); 
		$ticketProjM->setLimit( 5000 );

		$ticketProjM->indexResult( 'pjid' );

		$categories = $ticketProjM->load('ol');



		$parent = array();

		$parent['pkey'] = 'pjid';

		$parent['parent'] = 'parent';

		$parent['name'] = 'name';



		if ( !empty($categories) ) {

			$childOrderParent=array();

			$list = WOrderingTools::getOrderedList( $parent, $categories, 1, false, $childOrderParent );

		} else {

			$list = array();

		}




















		foreach( $list as $itemList ) {

			$this->addElement($itemList->pjid, $itemList->name);

		}


	return true;



   }}