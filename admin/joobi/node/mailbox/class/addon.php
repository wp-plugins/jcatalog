<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Addon_class extends WClasses {

	public $report = true;
	protected $_connector = null;
	protected $_currentMessage = null;		protected $_mbox = null;					protected $_messages = array();		




	public function getMailBox() {
		return ( isset( $this->_mbox ) ? $this->_mbox : null );
	}




	public function checkAllMessages($maxEmails=null) {

				$message = WMessage::get();

				$nbMessages = $this->getNumberOfMessages();

		if ( empty($nbMessages) ) return false;

		if ( !isset($maxEmails) ) {
			$pref = WPref::get('mailbox.node');
			$maxEmails = $pref->getPref( 'maxemails' , 50 );
		}
				if ( ( $nbMessages > $maxEmails ) && ( $maxEmails != 0 ) ){
						$NUMBEROFMESSAGE = $nbMessages - $maxEmails;
			$message->userN('1254227304QDMN',array('$NUMBEROFMESSAGE'=>$NUMBEROFMESSAGE));
		} elseif ( ( $nbMessages > $maxEmails ) && ( $maxEmails == 0 ) ) {
			$message->userN('1258010751GXJB');
		} else {
			$maxEmails = $nbMessages;
		}
		for($i = 1; $i<=$maxEmails;$i++){
			$this->_messages[] = $i;
		}
	}






	public function getNBMessages() {
		$msg = ( !empty( $this->_currentMessage->messageNB) ) ? $this->_currentMessage->messageNB : 0;
		return $msg;
	}



}