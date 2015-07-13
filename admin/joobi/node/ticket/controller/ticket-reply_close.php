<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_reply_close_controller extends WController {








function close() {



	
	$uid = WUser::get('uid');

	$ticketReplyTransID = WModel::get('ticket.replytrans', 'sid' );

	$trucs = WGlobals::get( 'trucs' );



	if (isset($trucs[$ticketReplyTransID])) {

		$descri = $trucs[$ticketReplyTransID]['description'];



		
		if ( !empty($descri) )

		parent::save();



	}


	
	$sid = WModel::get('ticket.reply', 'sid');

	if (isset($trucs)) {				
		$tckid = $trucs[$sid]['tkid'];

	} else {						
		$tckid = WGlobals::get('tkid');

	}


	
	$this->model = WModel::get('ticket');

	
	$this->model->whereE( 'tkid', $tckid );

	$ticket = $this->model->load('o',array('created','namekey'));

	$created = $ticket->created;			
	$namekey = $ticket->namekey;



	$this->model->whereE( 'tkid', $tckid );

	$this->model->setVal( 'status', 125 );

	$this->model->setVal( 'modified', time() );

	$this->model->setVal( 'deadline', 0 );

	$this->model->setVal('lock',0);

	$this->model->setVal('read',1);

	$this->model->setVal('followup',0);

	if ( $created>0 ) $this->model->setVal( 'elapsed', time()-$created );



	$this->model->update();



	$message = WMessage::get();

	$message->userS('1248677667PZKH',array('$namekey'=>$namekey));





	if ( WRoles::isAdmin( 'agent' ) ) {

		WPages::redirect('controller=ticket' );		
	} elseif (!empty($uid)) {

		WPages::redirect('controller=ticket-my');	
	} else {

		WPages::redirect('controller=ticket');		
	}


	return true;



}}