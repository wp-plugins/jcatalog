<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Ticket_Translation_class extends WClasses {







	public function secureTranslation($itemO,$sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;

						$roleHelper = WRole::get();
		if ( WRole::hasRole( 'supportmanager' ) ) return true;

		return false;

	}

}