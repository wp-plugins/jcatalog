<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_reply_fe_noregistered_view extends Output_Forms_class {
function prepareView() {



		$editClose = WPref::load( 'PTICKET_NODE_EDITCLOSE' );

		if ( !$editClose ) {

			$tkid = WGlobals::get( 'tkid' );

			$ticketM = WModel::get( 'ticket' );

			$ticketM->whereE( 'tkid', $tkid );

			$status = $ticketM->load( 'lr', 'status' );



			if ( $status == 125 ) {

				$this->removeMenus( array( 'ticket_reply_fe_noregistered_savereg', 'ticket_reply_fe_noregistered_divider' ) );

				$this->removeElements( array( 'ticket_reply_fe_noregistered_savereg', 'ticket_reply_fe_noregistered_ticket' ) );

			}


		}

				if ( WExtension::exist( 'subscription.node' ) ) {

			$subscriptionCheckC = WObject::get( 'subscription.check' );
			$subscriptionCheckC->dontDeductCredits();
			$subscriptionO = $subscriptionCheckC->restriction( 'ticket_maxnumber_responses' );

			if ( !$subscriptionCheckC->getStatus( false ) ) {
				$this->removeElements( array( 'ticket_reply_fe_noregistered_ticket_replytrans_description', 'ticket_reply_fe_noregistered_savereg' ) );
				$this->removeMenus( array( 'ticket_reply_fe_noregistered_savereg', 'ticket_reply_fe_apply' ) );
				$link = WPage::link( 'controller=subscription' );
				$SUBSCRIBE_LINK = '<a href="'.  $link .'">' . WText::t('1329161820RPTN') .'</a>';
				$this->userW('1400081599RXJU',array('$SUBSCRIBE_LINK'=>$SUBSCRIBE_LINK));
			}
		}

		return true;



	}}