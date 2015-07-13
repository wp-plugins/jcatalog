<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Assignable_picklist extends WPicklist {










function create() {



	
	$ticketSID = WModel::get('ticket.reply', 'sid' );

	$trucs = WGlobals::get('trucs');				
	$tkid = WGlobals::get('tkid');				
	$uid = WUser::get('uid');

	


	
	
	$ticketProjectMemberM = WModel::get( 'ticket' );

	

	$ticketProjectMemberM->makeLJ( 'ticket.projectmembers','pjid', 'pjid',  0, 1 );


	$ticketProjectMemberM->whereE( 'tkid', $tkid );

	$ticketProjectMemberM->select( 'supportlevel', 1 );

	$ticketProjectMemberM->select( 'pjid', 0 );

	$tkInfo = $ticketProjectMemberM->load( 'o' );



	
	if (empty($tkInfo->supportlevel) ) {			
		$message = WMessage::get();
		$message->userW('1330529258DZNG');
		WPages::redirect( 'controller=ticket-reply&task=listing&tkid=' . $tkid ); 

	} else {

		
		$tkInfo->supportlevel++;

		

		
		$rolids = array();

		$namekey = array( 'author', 'manager', 'admin', 'sadmin', 'supportmanager', 'agent', 'moderator' );

		$roleM = WModel::get('role');

		$roleM->whereIn( 'namekey', $namekey );

		$roleM->setLimit( 10000 );


		$rolids = $roleM->load('lra', 'rolid');

		

		$ticketProjectMemberM = WModel::get( 'ticket.projectmembers' );

		$ticketProjectMemberM->makeLJ( 'ticket', 'pjid' );

		if (!empty($tkInfo->supportlevel)) {						
			$ticketProjectMemberM->where( 'supportlevel', '<=',$tkInfo->supportlevel+1);

		} else {

			$ticketProjectMemberM->where( 'supportlevel', '<=',$tkInfo->supportlevel+2);

		}
		$ticketProjectMemberM->whereE( 'pjid', $tkInfo->pjid, 0);

		


		$ticketProjectMemberM->whereIn( 'rolid', $rolids, 2 );

		

		$ticketProjectMemberM->select( 'uid' );

		$ticketProjectMemberM->makeLJ( 'users', 'uid');

		$ticketProjectMemberM->select( 'name', 2 );

		$ticketProjectMemberM->orderBy( 'supportlevel', 'DESC' );

		$ticketProjectMemberM->groupBy('uid', 0);

		$listOfMembers = $ticketProjectMemberM->load( 'ol' );



		if ( !empty($listOfMembers) ) {

			foreach( $listOfMembers as $oneM ) {

				$this->addElement( $oneM->uid, $oneM->name );

			}
		} else {
			$message = WMessage::get();
			$message->userW('1330529258DZNG');
			WPages::redirect( 'controller=ticket-reply&task=listing&tkid=' . $tkid ); 
				
		}
	}


  return true;

}}