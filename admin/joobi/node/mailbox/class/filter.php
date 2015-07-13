<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Filter_class extends Mailbox_Mailbox_class {











function identifyFilter($SUBJECT) {

    $filterStatus=false;     $message = WMessage::get();

        $ruleDictionaryM = WModel::get('mailbox.ruledictionary');
    $ruleDictionaryM=select('words');
    $ruleDictionaryM=whereE('words',$SUBJECT);
    $wordType = $ruleDictionaryM->load('lr');

        $msgtypeT = WType::get('mailbox.type');

        $boxTypeT =WType::get('mailbox.box');

    static $mailboxMessagesM=null;
    if ( !isset($mailboxMessagesM) ) $mailboxMessagesM = WModel::get( 'mailbox.messages' );


	if (empty($wordType)) {
      $messageType = $msgtypeT->getvalue('unknown');
      $this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXN')));
	  $filterStatus;

	} else {

		$filterStatus=true;

		switch ( $wordType ) {

			case '5': 			case '10'; 			case '20'; 	        case '30'; 	        case '35'; 	        case '40'; 			 	 $box=$boxType->getvalue('archive');
			 	 $this->_updateTypeBox( $wordType, $box );
		         break;

		   case '15'; 		   case '25'; 		   case '45'; 								$mailboxMessagesM->setval( 'type', $wordType );
				$mailboxMessagesM->whereE( 'box', 1 );
				$mailboxMessagesM->update();
				break;

		  default:
			       				  $this->addReport(str_replace(array('$SUBJECT'), array($SUBJECT),WText::t('1418159587ECXO')));
				  $filterStatus=false;
		 }	}
	$messageType=$msgtypeT->getvalue('unknown');
	if ( $filterStatus==false ) {
         $mailboxMessagesM = WModel::get( 'mailbox.messages' );

					}
	else{

	    	   	}

  return $filterStatus;

 }








function _updateTypeBox($wordType,$box) {

    $mailboxMessagesM = WModel::get( 'mailbox.messages' );
	$mailboxMessagesM->setval( 'type', $wordType ); 	$mailboxMessagesM->setVal( 'box', $box ); 	$mailboxMessagesM->whereE( 'box', 1 );
	$mailboxMessagesM->update();


 }
}