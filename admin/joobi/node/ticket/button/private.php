<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CorePrivate_button extends WButtons_external {
function create() {





	$tkid = WGlobals::get('tkid');






	$ticketM = WModel::get('ticket');

    $ticketM->whereE( 'tkid', $tkid );

    $ticketM->select( 'private');

	$privateticket = $ticketM->load( 'lr' );



	if ($privateticket) {

		$text = WText::t('1224166212FTLB');

		
		$this->setIcon( 'unlock' );

	} else {

		$text = WText::t('1219769905FKPR');

		
		$this->setIcon( 'lock' );

	}
		


		$this->setTitle( $text );



	return true;



}}