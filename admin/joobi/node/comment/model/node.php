<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_Node_model extends WModel {







function validate() {



	
	$installed = WExtension::get( 'jtickets.application', 'wid' );

	if (!empty($installed)) {


		$this->pjid = WPref::load( 'PTICKET_NODE_TKPROJCOMMENT' );

		if ( empty($this->pjid) ) {					
			$categoryM = WModel::get( 'ticket.project' );

			$categoryM->whereE('namekey','maincategory');

			$this->pjid = $categoryM->load('lr','pjid');	
		}
	} else {

						
		$this->pjid = 2;				
	}


	return true;


}








function addValidate() {



	
	$ticketProjectMemberM = WModel::get( 'ticket.projectmembers' );

	$ticketProjectMemberM->orderBy( 'supportlevel' );

	$ticketProjectMemberM->whereE( 'pjid', $this->pjid );

	$this->assignuid = $ticketProjectMemberM->load('lr', 'uid');



	
	$trucs = WGlobals::get( 'trucs' );

	$this->_url = WGlobals::get( 'returnurl' );

	$commentMID = WModel::getID('comment');

	$authoruid = WUser::get('uid');		
	if (empty($authoruid)) {

		$authoruid=$trucs[$commentMID]['authoruid'];

	}


	$this->tktypeid = 80;					
	$this->comment = 10;				
	$this->status = 20;				
	$this->authoruid = $authoruid;

	$this->priority = 10;				
	$this->ip = WUser::get( 'ip' ); 	
	$this->private = '0';



	if ( empty($this->commenttype) ) $this->commenttype = WGlobals::get('commenttype');

	if ( empty($this->etid) ) $this->etid = WGlobals::get('etid');



	$this->score = ( !empty($trucs[$commentMID]['score']) ) ? $trucs[$commentMID]['score'] : WGlobals::get('extra');



	
	$CMTAPPROVAL = WPref::load( 'PCOMMENT_NODE_CMTAPPROVAL' );

	if ( PCOMMENT_NODE_CMTAPPROVAL ) {

		$this->publish = 0;

		$message = WMessage::get();

		$message->userN('1273127873NGVN');

	} else {

		$this->publish = 1;			
	}


	$description = $this->getChild( 'commenttrans', 'description' );

	$this->charcount = strlen( $description );

	$this->wordcount = str_word_count( $description );



	
	$this->_generateKey( $authoruid );


	return true;



}








function addExtra() {



	
	if ( WPref::load( 'PCOMMENT_NODE_CMTNOTIFYADMIN' ) ) {

		$namekey = $this->namekey;

		$title = $this->getChild( 'commenttrans', 'name' );

		$score = $this->score;



		$linkTemp = WPages::linkAdmin( 'controller=comment&search=' . $this->namekey );



		static $comNameC = null;

		if ( !empty($this->commenttype) ) {

			if ( !isset($comNameC ) ) $comNameC = WClass::get('comment.commenttype');	
			$comName = $comNameC->commentType($this->commenttype);

		} else {

			$comName = null;

		}


		$mailM = WMail::get();



		
		$params = new stdClass;

		$params->commentid = '[' . $namekey . ']';

		$params->title = $title;

		$params->description = $this->getChild( 'commenttrans', 'description' );



		if ( PCOMMENT_NODE_CMTAPPROVAL ) {

			$approveLink = WPage::routeURL( 'controller=comment&task=approve&tkid=' . $this->tkid . '&namekey=' . $this->namekey . '&score=' . $this->score.'&etid=' . $this->etid . '&commenttype=' . $this->commenttype.'&comname='.$comName,'admin', false, false, true, JOOBI_MAIN_APP );

			$params->approvalMsg = WText::t('1408411776NUFZ');	
			$params->approvalLink = '<a href = "' . $approveLink . '">' . WText::t('1408411776NUGA') . '</a>';

		} else {

			$params->approvalMsg = $params->approvalLink = '';

		}


		$params->score = $score . ' ' . WText::t('1408411776NUGB');					
		$params->link = '<a href="' . $linkTemp . '">' . WText::t('1327615780QFKY') . '</a>';		


		
		$mailM->setParameters( $params );

		$email = PCOMMENT_NODE_CMTNOTIFYEMAIL;			
		if ( empty($email) ) {

			$mailM->sendAdmin( 'notify_admin_newcomment', false );

		} else {

			$mailM->sendNow( $email, 'notify_admin_newcomment', false );

		}


	}


	return true;


}








private function _generateKey($uid) {



	$time = time() - 1229873219;

	$string = ( base_convert( ( $time ),10,36) .'-'. base_convert( ( $uid ),10,36) );	


	$this->namekey = strtoupper( $string );



	return true;


}
}