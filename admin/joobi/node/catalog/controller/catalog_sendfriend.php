<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_sendfriend_controller extends WController {

	function sendfriend() {



		$eid = WGlobals::getEID();



		$emails = $this->getFormValue( 'emails' );
		$subject = $this->getFormValue( 'subject' );
		$body = $this->getFormValue( 'body' );

		WGlobals::set( 'model', $this->getFormValue( 'model' ) );	

		if ( empty($emails) ) {
			$this->userE('1369751032MHQT');
		}
		if ( empty($subject) ) {
			$this->userE('1369751032MHQU');
		}
				if ( empty($body) ) {
			$this->historyE('1369751032MHQV');
		}
				$emailA = explode( ',', $emails );
		if ( empty($emailA) ) {
			$this->historyE('1369751032MHQW');
		}
		$usersEmail = WClass::get('users.email');
		$mailM = WMail::get();

		$mailParams = new stdClass;
		$mailParams->subject = $subject;
		$mailParams->body = str_replace( array( "\n\r", "\r\n", "\n", ), '<br />', $body);

		$count = 1;
		foreach( $emailA as $oneEmail ) {
				if ( $count > 100 ) {
				$this->adminE( 'The maximum number of friend emails have been reach.' );
				break;
			}				$count++;

			$EMAIL = trim( $oneEmail );
			if ( !$usersEmail->validateEmail($EMAIL) ) {
				$this->userE('1410373233CVZM',array('$EMAIL'=>$EMAIL));
				continue;
			}
		
			$mailM->setParameters( $mailParams );
						$mailM->replyTo( WUser::get('email'), WUser::get('name') );
			$status = $mailM->sendNow( $EMAIL, 'catalog_email_friend', false );
			if ( $status ) $this->userS('1369751032MHQY');

		}
	
		return true;



	}
}