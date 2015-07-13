<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_form_fe_view extends Output_Forms_class {
function prepareView() {



		$allowfiles = WPref::load( 'PTICKET_NODE_ALLOWFILES' );

		if ( empty( $allowfiles ) ) $this->removeElements( 'ticket_form_fe_ticket_files_filid' );



		$ticketType = WPref::load( 'PTICKET_NODE_TKTYPE' );

		if ( $ticketType )  $this->removeElements( 'ticket_form_fe_ticket_type' );





		$isteURL  = WPref::load( 'PTICKET_NODE_SITEINTEGRATION' );

		$licenseExist = WExtension::exist( 'license.node' );

		if ( WRoles::isAdmin( 'agent' ) || !$isteURL || !$licenseExist ) $this->removeElements( 'ticket_form_fe_ticket_site' );





		$userchooseprivacy = WPref::load( 'PTICKET_NODE_USERCHOOSEPRIVACY' );

		if ( !$userchooseprivacy ) $this->removeElements( 'ticket_form_fe_ticket_private' );





		
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

				$link = WPage::link( 'controller=ticket-my' );

				$QUESTION_LINK = '<a href="'.  $link .'">' . WText::t('1244448970SMQL') .'</a>';

				$this->userN('1401197668CUMG',array('$QUESTION_LINK'=>$QUESTION_LINK));

			}


		}




		return true;



	}}