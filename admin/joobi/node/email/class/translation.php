<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Email_Translation_class extends WClasses {







	public function secureTranslation($emailO,$sid,$eid){

		$uid=WUser::get( 'uid' );
		if( empty($uid)) return false;

				if( WRole::hasRole( 'manager' )) return true;

		return false;

	}

}