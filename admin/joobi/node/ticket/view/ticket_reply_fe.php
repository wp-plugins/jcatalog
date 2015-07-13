<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_reply_fe_view extends Output_Forms_class {

	public function prepareView() {


		$tkid = WGlobals::get( 'tkid' );

		$ticketQueueC = WClass::get( 'ticket.queue' );
		$ticketQueueC->getMyPosition( $tkid );


		$allowfiles = WPref::load( 'PTICKET_NODE_ALLOWFILES' );

		if ( empty( $allowfiles ) ) $this->removeElements( 'ticket_reply_fe_ticket_replyfiles_filid' );



		$editClose = WPref::load( 'PTICKET_NODE_EDITCLOSE' );

		if ( !$editClose ) {



			$ticketLoadC = WClass::get( 'ticket.load' );
			$myticketO = $ticketLoadC->get( $tkid );


			if ( $myticketO->status == 125 ) {

				$this->removeMenus( array( 'ticket_reply_fe_apply', 'ticket_reply_fe_save', 'ticket_reply_fe_divider_apply' ) );

				$this->removeElements( array( 'ticket_reply_fe_save', 'ticket_reply_fe_add_a_reply' ) );

			}


		}

				if ( WExtension::exist( 'subscription.node' ) ) {

			$subscriptionCheckC = WObject::get( 'subscription.check' );
			$subscriptionCheckC->dontDeductCredits();
			$subscriptionO = $subscriptionCheckC->restriction( 'ticket_maxnumber_responses' );

			if ( !$subscriptionCheckC->getStatus( false ) ) {
				$this->removeElements( array( 'ticket_reply_fe_ticket_replytrans_description', 'ticket_reply_fe_save' ) );
				$this->removeMenus( array( 'ticket_reply_fe_save', 'ticket_reply_fe_apply' ) );
				$link = WPage::link( 'controller=subscription' );
				$SUBSCRIBE_LINK = '<a href="'.  $link .'">' . WText::t('1329161820RPTN') .'</a>';
				$this->userW('1400081599RXJU',array('$SUBSCRIBE_LINK'=>$SUBSCRIBE_LINK));
			}
		}


		return true;



	}}