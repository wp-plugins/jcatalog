<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_readmessage_controller extends WController {




function readmessage() {


	$mcid = WGlobals::getEID();

	$isread = WGlobals::get( 'read' );

	$skip = WGlobals::get( 'skip' );

		$uid = WUser::get( 'uid' );
	$conversationM = WModel::get( 'conversation' );
	$conversationM->makeLJ( 'conversation.to' );
	$conversationM->whereE( 'mcid', $mcid );
	$conversationM->openBracket();
	$conversationM->whereE( 'uid', $uid );
	$conversationM->operator();
	$conversationM->whereE( 'uid', $uid, 1);
	$conversationM->closeBracket();
	$messageExit = $conversationM->exist();


	if ( empty($messageExit) ) return false;



	
	if ( empty($skip) ) {

		
		
		if ( !empty($isread) ) {

			$conversationStatusM = WModel::get( 'conversation.status' );

			$conversationStatusM->setVal( 'isread', 0 );

			$conversationStatusM->whereE( 'mcid', $mcid );

			$conversationStatusM->update();

		}


		
		
		if ( !empty($mcid) ) {

			$conversationM = WModel::get( 'conversation' );

			$conversationM->whereE( 'mcid', $mcid );

			$result = $conversationM->load( 'lr', 'parent' );



			if ( !empty($result) ) {

				$vendid = WGlobals::get( 'id' );

				$dtid = WGlobals::get( 'dtid' );

				$titleheader = WGlobals::get( 'titleheader' );



				
				if ( !isset($conversationM) ) $conversationM = WModel::get( 'conversation' );

				$conversationM->whereE( 'mcid', $mcid );

				$repUID = $conversationM->load( 'lr', 'uid' );



				WPages::redirect( 'controller=vendor-inbox&task=readmessage&eid='. $result .'&titleheader='. $titleheader .'&id='. $vendid .'&repid='. $repUID .'&dtid='. $dtid .'&read=0&skip=1' , true );

			}
		}
	}




	return true;


}
}