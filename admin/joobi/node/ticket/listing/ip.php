<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'main.listing.iptracker' );
class Ticket_CoreIp_listing extends WListing_iptracker {


















public function create() {


		$showIP = false;

	if ( WPref::load( 'PTICKET_NODE_TKIP' ) ) {					
		
		$ticketAuthor = $this->getValue('authoruid');		
		$uid = $this->getValue('uid');				

		






		
		if ( WPref::load( 'PTICKET_NODE_TKIPDISPLAY' )  ) {					if ( empty($uid) || $ticketAuthor == $uid ) {
				$showIP = true;
			}		} else {
			$showIP = true;
		}


	}

	if ( $showIP ) {
		$installed = WExtension::exist( 'iptracker.node' );
		if ( $installed ) {						$this->value = ip2long($this->value);
			return parent::create();
		}	}

	return false;



}

}