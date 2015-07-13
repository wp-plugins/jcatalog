<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_CoreAuthorcondition_button extends WButtons_external {
	function create() {


		$canAccess = WGlobals::get( 'ticketAccessAuthor', false, 'global' );

		if ( ! $canAccess ) return false;


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