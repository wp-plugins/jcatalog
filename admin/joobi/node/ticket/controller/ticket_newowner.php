<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_newowner_controller extends WController {


	function newowner() {



		$tkid = WGlobals::get( 'tkid' );

		$uid = WGlobals::get( 'uid' );





		if ( !empty($tkid) && !empty($uid)  ) {



			$ticketM = WModel::get( 'ticket' );

			$ticketM->whereE( 'tkid', $tkid );

			$ticketM->setVal( 'authoruid', $uid );

			$ticketM->update();



		}


		WPages::redirect( 'controller=ticket' );

		return true;



	}
}