<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Vendor_Email_class extends WClasses {












public function sendNotification($uid,$emailNamekey,$param=null) {

	static $mail = null;

	if ( !isset($mail) ) $mail = WMail::get();

	if ( !empty($param) ) $mail->setParameters( $param );
	$mail->sendNow( $uid, $emailNamekey );



	return true;

}






	public function getStoreMangerContact($return='') {

		$email = WPref::load( 'PVENDORS_NODE_STOREMANAGEREMAIL' );
		$email = trim($email);

		if ( empty($email) ) {

						$uidSM = WPref::load( 'PVENDORS_NODE_SENDVERTOADMIN' );
			$uidSM = trim( $uidSM );
			$vendorC = WClass::get( 'vendor.helper', null, 'class', false );

			if ( empty($uidSM) ) {
								$uid = $vendorC->getVendor( $vendorC->getDefault(), 'uid' );

				$uid = WUser::get( 'data', $uid );

			} else {
								$email = WUser::get( 'email', $uidSM );
				if ( !empty($email) ) $uid = $uidSM;
				else $uid = $vendorC->getVendor( $vendorC->getDefault(), 'uid' );

				$uid = WUser::get( 'data', $uid );
			}
		} else {

			$uid = new stdClass;
			$uid->name = WText::t('1298350804GFLD');
			$uid->email = $email;
			$uid->uid = $uid->email;

		}
		if ( empty($return) ) {
			return $uid;
		} else {

			if ( is_int($uid) ) {
				return WUser::get( $return, $uid );
			} else {
				if ( !empty($uid->$return) ) return $uid->$return;
				else return ;
			}
		}

	}
}