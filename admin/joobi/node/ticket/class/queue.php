<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_Queue_class extends WClasses {








	public function getMyPosition($tkid,$showMessage=true) {


		$queueposition = WPref::load( 'PTICKET_NODE_QUEUEPOSITION' );

		if ( !$queueposition ) return false;

				$ticketLoadC = WClass::get( 'ticket.load' );
		$myTicketO = $ticketLoadC->get( $tkid );

		if ( empty($myTicketO) ) return false;


				$ticketM = WModel::get( 'ticket' );
		$ticketM->makeLJ( 'ticket.project', 'pjid' );
		$ticketM->whereE( 'status', 20, 0 );
		$ticketM->whereE( 'comment', 1, 0 );
		$ticketM->whereE( 'publish', 1, 1 );
		$ticketM->where( 'modified' ,'<' , $myTicketO->modified, 0 );
		$ticketM->where( 'priority' ,'>=' , $myTicketO->priority, 0 );
		$NUMBER = $ticketM->total();
		if ( $NUMBER > 0 && $showMessage ) {
			if ( $NUMBER ==  1 ) $this->userW('1391456064JYEB');
			else  $this->userW('1391456064JYEC',array('$NUMBER'=>$NUMBER));
		}
		return $NUMBER;


	}

}