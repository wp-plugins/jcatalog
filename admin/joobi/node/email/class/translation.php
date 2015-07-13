<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Email_Translation_class extends WClasses {







	public function secureTranslation($emailO,$sid,$eid){

		$uid=WUser::get( 'uid' );
		if( empty($uid)) return false;

				if( WRole::hasRole( 'manager' )) return true;

		return false;

	}

}