<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_savemessage_controller extends WController {




function savemessage() {





	
	$vendid = WController::getFormValue( 'id' );



	
	
	$taskFrom = WGlobals::get( 'task_redirect' );


	if ( $taskFrom == 'readmessage' ) {



		
		$content = WController::getFormValue( 'content' );









		$mcUID = WController::getFormValue( 'repid' );
		if ( empty($mcUID) ) $mcUID = WController::getFormValue( 'uid' );
		$mcid = WController::getFormValue( 'mcid' );



		
		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		$vendObj = $vendorHelperC->getVendor( $vendid );

		$uid = ( isset($vendObj->uid) ) ? $vendObj->uid : WUser::get( 'uid' );



		
		
		if ( empty($content) ) {


			
			$this->userN('1348175294RLLS');

			WPages::redirect( 'previous' );

			return true;


		} else {

			
			$title = $this->_getTitle( $mcid );

			$replyTitle = 'Re:'. $title;



			
			$currentTime = time();



			
			
			$conversationM = WModel::get( 'conversation' );

			$conversationM->title = $replyTitle;

			$conversationM->content = $content;

			$conversationM->top = $mcid;

			$conversationM->parent = $mcid;

			$conversationM->created = $currentTime;

			$conversationM->modified = $currentTime;

			$conversationM->uid = WUser::get( 'uid' );

			$conversationM->returnId( true );

			$conversationM->save();



			
			$getmcid = $conversationM->mcid;



			
			
			$conversationStatusM = WModel::get( 'conversation.status' );

			$conversationStatusM->setVal( 'uid', $uid );

			$conversationStatusM->setVal( 'mcid', $getmcid );

			$conversationStatusM->setVal( 'isread', 1 );

			$conversationStatusM->insert();



			
			
			$conversationToM = WModel::get( 'conversation.to' );

			$conversationToM->setVal( 'mcid', $getmcid );

			$conversationToM->setVal( 'uid', $mcUID );

			$conversationToM->insert();



			
			if ( !empty( $mcUID ) ) {


				$sendObj = new stdClass;

				$sendObj->sentToUID = $mcUID;

				$sendObj->title = $replyTitle;

				$sendObj->content = $content;

				$sendObj->datemodified = $currentTime;

				$sendObj->mcid = $getmcid;



				$this->_sendToVendor( $sendObj );

			}
		}


	} else {



		
		parent::save();



		$mcid = ( isset( $this->_model->mcid ) ) ? $this->_model->mcid : 0;

		$modelMap = 'C'. WModel::getID( 'conversation.to' );

		$sentToUID = ( isset( $this->_model->$modelMap->uid ) ) ? $this->_model->$modelMap->uid : 0;






		
		if ( !empty($mcid) ) {

			$uid = ( isset( $this->_model->uid ) ) ? $this->_model->uid : WUser::get( 'uid' );



			
			$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

			$vendObj = $vendorHelperC->getVendor( $vendid );

			$vendUID = ( isset($vendObj->uid) ) ? $vendObj->uid : $uid;



			






			
			$conversationStatusM = WModel::get( 'conversation.status' );

			$conversationStatusM->setVal( 'mcid', $mcid );

			$conversationStatusM->setVal( 'isread', 1 );

			$conversationStatusM->setVal( 'uid', $vendUID );

			$conversationStatusM->insert();


						if ( !empty( $sentToUID ) ) {

								$title = ( isset( $this->_model->title ) ) ? $this->_model->title : '';
				$content = ( isset( $this->_model->content ) ) ? $this->_model->content : '';
				$datemodified = ( isset( $this->_model->modified ) ) ? $this->_model->modified : 0;

				$sendObj = null;
				$sendObj->sentToUID = $sentToUID;
				$sendObj->title = $title;
				$sendObj->content = $content;
				$sendObj->datemodified = $datemodified;
				$sendObj->mcid = $mcid;

				$this->_sendToVendor( $sendObj );
			}
						$this->userS('1263480766IEVJ');


		}


	}





	
	$link = ( !empty($vendid) ) ? 'controller=vendor-inbox&task=listing&id='. $vendid : 'controller=vendor-inbox&task=listing';

	WPages::redirect( $link, true );

	return true;

}




private function _getTitle($mcid) {


	$conversationM = WModel::get( 'conversation' );

	$conversationM->whereE( 'mcid', $mcid);

	$title = $conversationM->load( 'lr', 'title' );



	return $title;

}




private function _sendToVendor($sendObj) {


	$sentToUID = ( isset( $sendObj->sentToUID ) ) ? $sendObj->sentToUID : 0;

	$title = ( isset( $sendObj->title ) ) ? $sendObj->title : '';

	$content = ( isset( $sendObj->content ) ) ? $sendObj->content : '';

	$datemodified = ( isset( $sendObj->datemodified ) ) ? $sendObj->datemodified : 0;

	$mcid = ( isset( $sendObj->mcid ) ) ? $sendObj->mcid : 0;



	if ( !isset($vendorHelperC) ) $vendorHelperC = WClass::get('vendor.helper',null,'class',false);

	$sentVendid = $vendorHelperC->getVendorID( $sentToUID );



	$link = WPage::routeURL( 'controller=vendor-inbox&task=readmessage&eid='. $mcid .'&titleheader='. $title .'&id='. $sentVendid .'&read=1&dtid='. $datemodified, 'home');

	$text = '<br><br>'. WText::t('1263800691NRTE') .' <a href="'. $link .'">'. WText::t('1263800691NRTF') .'</a>';

	$content .= $text;


		$currentUser = WUser::get( 'data' );


	$mailer = WMail::get();
	$mailer->replyTo( $currentUser->email, $currentUser->name );
	$mailer->sendTextNow( $sentToUID, $title, $content, true );



	return true;

}}