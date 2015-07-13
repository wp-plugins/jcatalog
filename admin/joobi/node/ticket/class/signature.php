<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Signature_class extends WClasses {



	public function getUserSginature($uid) {


		if ( WRoles::isNotAdmin( 'agent' ) ) return false;

		$exist = WExtension::exist( 'contacts.node' );
		if ( $exist && !empty($uid) ) {
			$contactsDetailsM = WModel::get( 'contacts.details' );
			$contactsDetailsM->whereE( 'uid', $uid );
			return $contactsDetailsM->load( 'lr', 'signature' );
		}
		return false;

	}

}