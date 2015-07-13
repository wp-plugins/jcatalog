<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Emailattachments_class extends WClasses {








function getAttachment($connector,$authorid,$subject='') {


	$structure = $connector->getCurrentMessage( 'structure' );


	$attachmentA = array();					
	for( $ctr = 0; $ctr < count($structure->parts); $ctr++ ) {


				if ( $ctr > 10 ) break;


		
		$attachmentA[$ctr] = array(

			'is_attachment'	=> false,		
			'filename' 		=> '',			
			'name'			=> '',			
			'attachment'	=> '',			
			'size'			=> '',			
			'tmp_name'		=> '',			
			'type'			=> '',			
 		);


		
		if ($structure->parts[$ctr]->ifdparameters){

			foreach($structure->parts[$ctr]->dparameters as $object){

				
				if (strtolower($object->attribute) == 'filename'){

					$attachmentA[$ctr]['is_attachment'] = true;

					$attachmentA[$ctr]['filename'] = $object->value;		
				}
			}
		}


		
		if ($structure->parts[$ctr]->ifparameters){

			foreach($structure->parts[$ctr]->parameters as $object){

				
				if (strtolower($object->attribute) == 'name'){				
					$attachmentA[$ctr]['is_attachment'] = true;

					$attachmentA[$ctr]['name'] = $object->value;			
				}
			}
		}


		
		if ( $attachmentA[$ctr]['is_attachment'] ) {


			$attachmentA[$ctr]['attachment'] = imap_fetchbody( $connector->getMailBox(), $connector->getNBMessages(), $ctr+1 );



			if ( $structure->parts[$ctr]->encoding == 3 ) {				
				$attachmentA[$ctr]['attachment'] = base64_decode($attachmentA[$ctr]['attachment']);

			}elseif ( $structure->parts[$ctr]->encoding == 4 ) { 			 
				$attachmentA[$ctr]['attachment'] = quoted_printable_decode( $attachmentA[$ctr]['attachment'] );

			}


			
			$attachmentA[$ctr]['type'] = $structure->parts[$ctr]->subtype;

			$attachmentA[$ctr]['size'] = $structure->parts[$ctr]->bytes;


						if ( $attachmentA[$ctr]['size'] > ( WPref::load( 'PTICKET_NODE_TKATTACHMAXSIZE') * 1024 ) ) {
				WMessage::log( 'Attached file too big in ticket: ' . $subject, 'email-conversion-ticket-error' );
				$subject = 'Attachement too big!';
				$bodyText = 'The email you submitted contain an attachement which is too big. The maximum size allowed is ' . PTICKET_NODE_TKATTACHMAXSIZE . ' KB';
				$mailM = WMail::get();
				$mailM->sendTextNow( $authorid, $subject, $bodyText );

				continue;
			}
						$format = WPref::load( 'PTICKET_NODE_TKATTACHFORMATS' );

			if ( !empty( $format ) ) {
				$allowedFormats = strtolower( str_replace( ' ','', $format ) );
				$allowedFormatsA = explode( ',', $allowedFormats );
				$currentFormat = strtolower( $attachmentA[$ctr]['type'] );

								if ( in_array( 'doc', $allowedFormatsA ) || in_array( 'docx', $allowedFormatsA ) ) $allowedFormatsA[] = 'msword';


				if ( !in_array( $currentFormat, $allowedFormatsA ) ) {
					WMessage::log( 'Attached file not allowed in ticket: ' . $subject, 'email-conversion-ticket-error' );
					$subject = 'Attachement format not allowed!';
					$bodyText = 'The email you submitted contain an attachement that is not allowed, please contact the webmaster for more information.';
					$mailM = WMail::get();
					$mailM->sendTextNow( $authorid, $subject, $bodyText );
					continue;
				}			}
			
			$attachmentA[$ctr]['tmp_name'] =  JOOBI_DS_TEMP . md5( $attachmentA[$ctr]['name']  ) . '-' . $ctr . '-' . time() . DS . $attachmentA[$ctr]['name'];		

			$fileHandlerC = WGet::file();						$fileHandlerC->write( $attachmentA[$ctr]['tmp_name'], $attachmentA[$ctr]['attachment'] );

		}


	}


	return $attachmentA;

}
}