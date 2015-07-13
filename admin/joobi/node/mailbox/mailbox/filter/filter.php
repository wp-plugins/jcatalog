<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Filter_mailbox extends Mailbox_Mailbox_class {




	var $report = true;
	var $_msgid = 0;






	function process() {

		$SUBJECT = $this->getSubject(); 	                     
		if ( !empty($SUBJECT) ) {

			$BODY = $this->getBody(true);			     			$sender = $this->getInformation( 'sender_email' );     			$name = $this->getInformation( 'sender_name' );	     			$wordType = 0;
			$status = false;  				     

	       	$mailboxTypeT = WType::get('mailbox.type');            	       	$boxTypeT = WType::get('mailbox.box');              
			static $ruleDictionaryM = null;
			static $dictEntriesA = array();

	        	        if ( !isset($ruleDictionaryM) ) $ruleDictionaryM = WModel::get('mailbox.ruledictionary');
	        if ( empty($dictEntriesA) ) {
	        	$ruleDictionaryM->whereE( 'publish', '1' );
	        	$ruleDictionaryM->orderBy( 'core', 'DESC' );
				$ruleDictionaryM->orderBy( 'ordering', 'ASC' );
				$ruleDictionaryM->setLimit('5000');			    	$dictEntriesA = $ruleDictionaryM->load( 'ol', array('words','searchin','type') );
			}

						foreach( $dictEntriesA as $keys ) {

								$words=strtolower($keys->words);

							 	if ( $keys->searchin == 1 || $keys->searchin == 0 ) {
							    			$wordPosSubject = strpos( strtolower($SUBJECT), $words );
		    			$wordPosBody = strpos( strtolower($BODY), $words );
										$wordType=$keys->type;
				 	if ( $wordPosSubject !== false || $wordPosBody !== false ) break;
					else{
						$wordType=$mailboxTypeT->getValue('undefined');
					}
				 } elseif ($keys->searchin == 2 ){	
							    			$wordPosSubject = strpos( strtolower($SUBJECT), $words );
									 	$wordType=$keys->type;
				 	if ( $wordPosSubject !== false ) {
				 		break;
				 	} else {
						$wordType = $mailboxTypeT->getValue('undefined');
					 }
				} else {	
							    			$wordPosBody = strpos( strtolower($BODY), $words );
									 	$wordType = $keys->type;
				 	if ($wordPosBody !== false ) break;
				 	else{
						$wordType = $mailboxTypeT->getValue('undefined');
					}				}
			}

		 				switch ( $wordType ) {

				case '5':  
																		$email = $this->_getBounceEmailFromBody( $BODY );
						if ( !empty($email) ) {
							$this->addInformation( 'sender_email', $email );
							$this->addInformation( 'bouncedemail', $email );
							$sender = $email;
							$this->deleteMessage = false; 							$status = true; 
						} else {								$this->deleteMessage = false;
							$status = false;
							$sender = '';
						}

						$this->_storeMessage( $wordType, $boxTypeT->getvalue('Trash') );

						

												static $mailboxBounceC = null;
						if ( !isset($mailboxBounceC) ) $mailboxBounceC = WClass::get( 'mailbox.bounce' );
						$bounceType = $mailboxTypeT->getValue('bounce');

						$infos = $mailboxBounceC->addHandled( $sender, $bounceType );
						if ( !empty($infos) ) {
							$this->addInformation( 'bouncedemail', $sender );
							$this->addInformation( 'total', $infos->total );
							$this->addInformation( 'delay', $infos->delay );
						}				       break;

				case '35': 			  	case '20': 			  	case '30': 						$this->_storeMessage( $wordType, $boxTypeT->getvalue('Trash') );
						$this->deleteMessage=true; 						$status=true; 				           break;

			   	case '10': 						$this->_storeMessage( $wordType, $boxTypeT->getvalue('Archive') );

						$autoreplyM = WMail::get(); 						$messageInfo = null;
						$messageInfo->subject = $SUBJECT;
						$messageInfo->sender = $sender; 						$messageInfo->name = $name; 
						$autoreplyM->setParameters($messageInfo);
												$autoreplyStatus = $autoreplyM->sendNow($sender,'autoreply_message',true);

												if ($autoreplyStatus){
														$this->_storeMessage( $wordType, $boxTypeT->getvalue('Trash') );
						$this->addReport(str_replace(array('$sender'), array($sender),WText::t('1254392738GVKF')));
						} else {
														$this->_storeMessage( $wordType, $boxTypeT->getvalue('Archive') );
						$this->addReport(str_replace(array('$sender'), array($sender),WText::t('1254392738GVKG')));
						}						$this->deleteMessage=true; 						$status=true; 				           break;

	  		   	case '15': 			   	case '25': 			   	case '40': 						$this->_storeMessage( $wordType,$boxTypeT->getvalue('Inbox'));
						$this->deleteMessage=true; 						$status=true; 						break;

			  	default:

					$email = $this->_getBounceEmailFromBody( $BODY );
					if ( !empty($email) ) {
						$this->addInformation( 'sender_email', $email );
						$this->addInformation( 'bouncedemail', $email );
						$sender = $email;
						$this->deleteMessage = false; 						$status = true; 
					} else {							$this->deleteMessage = true;
						$status = false;
						$sender = '';
					}

		         			         						$mailboxTypeC = WClass::get( 'mailbox.type' );
					$mailboxTypeC->setConnector( $this->getConnector() );
					$mailboxTypeC->identifyType();
					$this->addInformation( 'box', $boxTypeT->getvalue('Inbox') );

		  }
	    } else { 
    	   	$this->addReport( WText::t('1254392738GVKH') );
    	   	return false;
	    }
		return $status;

 	}






	private function _getBounceEmailFromBody($body) {


		$resultsA = array();
		preg_match_all("/(?s)X-SubscriberID: (.+?)\n/", $body, $resultsA, PREG_PATTERN_ORDER );

		if ( !empty($resultsA[1][0]) ) $encodedEmail = $resultsA[1][0];
		if ( empty($encodedEmail) ) return false;

		$email = base64_decode( $encodedEmail );

		return $email;

	}


	






	private function _storeMessage($wordType,$box) {
		$this->addInformation( 'type', $wordType );
		$this->addInformation( 'box', $box);
		return true;
 	}






	function checkUsage() {

		static $exist=null;
		if ( isset($exist) ) return $exist;

		static $ruleDictionaryM=null;
    		if ( !isset($ruleDictionaryM) )$ruleDictionaryM = WModel::get('mailbox.ruledictionary');

		$exist = $ruleDictionaryM->tableExist();

		$message = WMessage::get();

		if (!$exist){
			$message->userE('1327442997GDYF');
			return false;
		}
		$ruleDictionaryM->where('dctid', '!=', 'null');
		$dictionaryIds = $ruleDictionaryM->load('lr');

		if ( $exist && empty($dictionaryIds ) ) {
			$message->userE('1327442997GDYG');
			return false;
		}
	 return true;
  	}
}