<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Translation_class extends WClasses {







	public function secureTranslation($itemO,$sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;

						$roleHelper = WRole::get();
		if ( WRole::hasRole( 'supportmanager' ) ) return true;

		return false;

	}

}