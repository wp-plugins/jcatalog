<?php 

* @link joobi.co
* @license GNU GPLv3 */












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