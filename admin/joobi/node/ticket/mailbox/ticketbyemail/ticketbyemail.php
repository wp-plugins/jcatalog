<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Ticketbyemail_mailbox extends Mailbox_Mailbox_class {



















function process() {



	$installedV = WExtension::get( 'jtickets.application', 'wid');					

	if ($installedV ) {




		if ( WPref::load( 'PTICKET_NODE_TICKETBYEMAIL' ) ) {



						$noOfMsgsV = $this->getNumberOfMessages();
			if ( empty($noOfMsgsV) ) return false;					
			$emailSubjectV = $this->getSubject();						
			$emailSenderV = $this->getInformation('sender_email');				
			$connectorV =& $this->getConnector();						
			$dateCreatedV = time();

			$emailBodyTempV = $this->getBody( true );						


			
			$senderEmailV = $this->getInformation('sender_email');				
			$senderNameV = $this->getInformation('sender_name');				
			$fromNameV = $this->getInformation('from_name');
			$cleanName = false;
						if ( $senderNameV == $senderEmailV ) {
				if ( !empty($fromNameV) ) $senderNameV = $fromNameV;
				else $cleanName = true;
			} else {
				$cleanName = true;
			}						if ( $cleanName ) {
				$senderNameV = str_replace( array( $senderEmailV, '<' . $senderEmailV .'>' ), '', $senderNameV );
			}			$senderNameV = trim( $senderNameV );

			$mailDateV = time();



			


			$authoruidV = WUser::get( 'uid', $senderEmailV );



			





			if ( empty($authoruidV) ) {


				if ( WPref::load( 'PTICKET_NODE_EMAILNEWACCOUNT' ) ) {

					$usersCredentialC = WUser::credential();
					$authoruidV = $usersCredentialC->ghostAccount( $senderEmailV, $senderNameV, false, null, null, true );









				} else {

					return true;							
				}
			}


			
			static $categoryM = null;

			static $categoryIDV = null;


			if ( !isset($categoryM) ) {

				$categoryM = WModel::get( 'ticket.project' );

				
				$categoryM->whereE( 'namekey', 'maincategory' );

			 	$categoryIDV = $categoryM->load( 'lr', 'pjid' );		
			}


			
			static $categoryMmbrsM = null;

			static $assignUidV = null;

			if ( !isset($categoryMmbrsM) ) {

				$categoryMmbrsM = WModel::get('ticket.projectmembers');

				
				$categoryMmbrsM->whereE( 'pjid', $categoryIDV) ;

				$categoryMmbrsM->orderby('supportlevel');

				$assignUidV = $categoryMmbrsM->load( 'lr', 'uid' );

			}

			if ( empty($emailBodyTempV) ) $emailBodyTempV = 'Empty email';


			
			if (empty($emailSubjectV)){

				$emailSubjectV = substr($emailBodyTempV,0,50).'...';

			}


			

			$emailBodyV = nl2br( $emailBodyTempV );


			
			
			$structure = $connectorV->getCurrentMessage( 'structure' );


			if (isset($structure->parts) && count($structure->parts)){				
				$emailAttachC = WClass::get('ticket.emailattachments');

				$attachmentA = $emailAttachC->getAttachment( $connectorV, $authoruidV, $emailSubjectV );

			}

			
			
			$ticketM = WModel::get('ticket');


			$ticketM->pjid = $categoryIDV;

			$ticketM->created = $mailDateV;

			$ticketM->modified = $mailDateV;

			$ticketM->assignuid = $assignUidV;			
			$ticketM->authoruid = $authoruidV;			
			$ticketM->priority = 10;				
			$ticketM->status = 20;					
			$ticketM->private = 1;

			$ticketM->tktypeid = 50; 					
			$ticketM->rolid = 1;



			
			$ticketM->setChild('tickettrans', 'name', $emailSubjectV ); 			$ticketM->setChild('tickettrans', 'description', $emailBodyV ); 			$ticketM->returnId();

			$ticketM->save( true );					
			$tkidV = $ticketM->tkid;



			
			if (!empty($attachmentA)){

				
				
				for($ctr = 0; $ctr < count($attachmentA); $ctr++){

					if ($attachmentA[$ctr]['is_attachment']){

					$ticketFilesM = WModel::get( 'ticket.files' );
					$ticketFilesM->tkid = $tkidV;
					$ticketFilesM->ordering = $ctr;
					$ticketFilesM->saveItemMoveFile( $attachmentA[$ctr]['tmp_name'] );


















					}
				}
			}

			
           	if ( !empty($connectorV->deletemsg) ) $this->setDeleteMSG();

           	$this->deleteMessage = true;
           	return false;



		} else {
			$message = WMessage::get();
			$message->userW('1325527934LWRY');
		}
	} else {

		return true;

	}

	return true;


}

}