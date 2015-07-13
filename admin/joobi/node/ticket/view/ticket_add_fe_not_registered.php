<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_add_fe_not_registered_view extends Output_Forms_class {
function prepareView() {



		$ticketType = WPref::load( 'PTICKET_NODE_TKTYPE' );

		if ( $ticketType )  $this->removeElements( 'ticket_add_fe_not_registered_ticket_type' );



		
		if ( WExtension::exist( 'subscription.node' ) ) {



			$subscriptionCheckC = WObject::get( 'subscription.check' );

			$subscriptionCheckC->dontDeductCredits();

			$subscriptionO = $subscriptionCheckC->restriction( 'ticket_maxnumber' );



			if ( !$subscriptionCheckC->getStatus( false ) ) {

				$this->removeElements( 'ticket_form_fe_tickettrans_description' );

				$this->removeMenus( 'ticket_form_fe_save' );

				$link = WPage::link( 'controller=subscription' );

				$SUBSCRIBE_LINK = '<a href="'.  $link .'">' . WText::t('1329161820RPTN') .'</a>';

				$this->userW('1400081599RXJU',array('$SUBSCRIBE_LINK'=>$SUBSCRIBE_LINK));

			}


		}


		return true;



	}}