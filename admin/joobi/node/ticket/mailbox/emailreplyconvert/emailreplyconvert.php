<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Emailreplyconvert_mailbox extends Mailbox_Mailbox_class {




































	public $deleteMessage = false;



function process() {


	
	$installed = WExtension::get( 'jtickets.application', 'wid');

	if ($installed ){

		$level = WExtension::get( 'jtickets.application', 'level');

		
		if ( !defined('PTICKET_NODE_AUTOREPLY') ) WPref::get('ticket.node');

		
		if (PTICKET_NODE_AUTOREPLY){

			
			$connect =& $this->getConnector();							
			$message = WMessage::get();									
			$subject = $this->getSubject();								
			$tknamekey = '';											
			$body = $this->getBody(true);								
			$sender = $this->getInformation('sender_email');			
			$udate = time();



			
			if (!empty($subject) && !empty($body)){

				
				$tknamekey = $this->_parseSubject($subject);



				
				
				if ( !empty($tknamekey) ) {

					$reply = $this->_parseBody($body,$connect);

					if ( !empty($reply) ) {



						$htmlReply= nl2br( $reply );


						
						
						$ticketM=WModel::get('ticket');

						$ticketM->whereE('namekey',$tknamekey);

						$ticketInfo = $ticketM->load( 'o', array('tkid','authoruid','modified','assignuid','resptime','replies','priority','tktypeid','status') );



						
						if ( !empty($ticketInfo->tkid) ) $tkid = $ticketInfo->tkid;

						else return true;


						$uid = $ticketInfo->authoruid;

						$nbReplies  = $ticketInfo->replies;

						$modified = $ticketInfo->modified;



						
						
						$structure = $connect->getCurrentMessage( 'structure' );


						if (isset($structure->parts) && count($structure->parts)){				
							$emailAttachC = WClass::get('ticket.emailattachments');

							$attachmentA = $emailAttachC->getAttachment( $connect, $uid, 'Ticket ID:' . $ticketInfo->tkid );

						}


						
						$tkReplyM=WModel::get('ticket.reply');

						
						$tkReplyM->tkid = $tkid;				
						$tkReplyM->authoruid = $uid;	
						$tkReplyM->created= $udate;							
						$tkReplyM->modified=$udate;

						$tkReplyM->rolid ='1';

						$tkReplyM->publish = '1';

						$tkReplyM->wordcount = str_word_count($reply);

						$tkReplyM->charcount = strlen($reply);

						$tkReplyM->ip = WUser::get( 'ip' );

						$tkReplyM->timing = '';

						$tkReplyM->timeresp = time()-$modified;



						
						$tkReplyM->setChild('ticket.replytrans', 'description', $htmlReply); 						$tkReplyM->save( true );



						$tkReplyM->returnId();

						$tkrid = $tkReplyM->tkrid;



						
						$ticketM->whereE('tkid',$tkid);

						$ticketM->setVal('replies',++$nbReplies);

						$ticketM->setVal('status',81);						
						$ticketM->setVal('modified',$udate);

						$ticketM->update();



						
						if (!empty($attachmentA)){

							
							
							for( $ctr = 0; $ctr < count($attachmentA); $ctr++) {

								if ($attachmentA[$ctr]['is_attachment']){


									$ticketFilesM = WModel::get( 'ticket.replyfiles' );
									$ticketFilesM->tkrid = $tkrid;
									$ticketFilesM->ordering = $ctr;
									$ticketFilesM->saveItemMoveFile( $attachmentA[$ctr]['tmp_name'] );























								}

							}

						}


						
           				if ($connect->deletemsg) $this->setDeleteMSG();

           				$this->deleteMessage = true;
						return false;


					} else {

						return true;

					}
				} else {					
					return true;

				}
			} else {

				return true;

			}
			return true;

	} else {								
		return true;

	}
	return true;


}


}












private function _parseSubject($subject){



		
		$namekeyTemp = strpbrk($subject,'[');

		$tknamekey = '';


		
		if (!empty($namekeyTemp)){										
			$strlength = strlen($namekeyTemp)-2;						
			$posStart= strpos($namekeyTemp,'[')+1;						
			$tknamekey = substr($namekeyTemp,$posStart,$strlength);		
		}


	return $tknamekey;



}

















private function _parseBody($body,$connect){

 	
 		
 		$reply = '';									
 		$currMsg = $connect->getCurrentMessage();


		$host = $currMsg->from[0]->host;


		
		switch($host){

			case 'yahoo.com':

			case 'ymail.com':

			case 'live.com' :

			case 'msn.com'  :

				$patEnd = strpos($body,'________');

				$reply = substr($body,0,$patEnd);

				break;

			case 'gmail.com' :

			case 'googlemail.com' :

				$patEnd = strpos($body,'>');

				$reply = substr($body,0,$patEnd);

				break;

			default:

				$stringDash = strpos($body,'------');		


				if (empty($stringDash)){

					$stringUnderScore = strpos($body,'________');



					if (empty($stringUnderScore)){

						$stringArrow = strpos($body,'>');



						if (empty($stringArrow)){

							$stringFrom = strpos($body,'From:');



							if (empty($stringFrom)){

								$reply = $body;			
							} else {

								$reply = substr($body,0,$stringFrom);

							}
						} else {

							$reply = substr($body,0,$stringArrow);

						}
					} else {

						$reply = substr($body,0,$stringUnderScore);

					}
				} else {

					$reply = substr($body,0,$stringDash);

				}


				break;

		}


 		return $reply;


 }



}