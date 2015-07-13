<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_Reply_model extends WModel {










function validate() {

	$uid = WUser::get('uid');

	
	if (!isset($this->authoruid) || empty($this->authoruid)) {

		$this->authoruid  = $uid;

		
		$this->ip = WUser::get( 'ip' );

	}
	return true;

}








function addExtra() {



	


	 $mailM = WMail::get();



	$params = $this->_sendEmail();



	if ( WPref::load( 'PCOMMENT_NODE_CMTNOTIFYADMIN' ) ) {



		$email = PCOMMENT_NODE_CMTNOTIFYEMAIL;			


		
		$mailM->setParameters( $params );



		if ( empty($email) ) {

			$mailM->sendAdmin( 'notify_admin_author_newreply', false );

		} else {

			$mailM->sendNow( $email,'notify_admin_author_newreply', false );

		}


	}

	if ( PCOMMENT_NODE_CMTNOTIFYAUTHOR ) {



		
		$replyM = WModel::get( 'comment' ); 		
		$replyM->select( 'authoruid' );

		$replyM->whereE( 'tkid', $this->tkid );

		$uid = $replyM->load( 'lr' );



		
		$mailM->setParameters($params);



		$mailM->sendNow( $uid, 'notify_admin_author_newreply', false );



	}




	return true;


}







private function _sendEmail() {

		$returnId = WGlobals::get('returnId');

		$this->_url = (!empty($this->_url)) ? $returnId : '';

		
		$prefix='C'.WModel::get('comment.replytrans','sid');

		$tkid=$this->tkid;

		$tkrid=$this->tkrid;

		$linkTemp = base64_decode($this->_url).'#'.$this->tkrid;



		$link = WPage::routeURL( 'controller=comment-reply&task=listing&tkid='.$tkid.'&returnId='.$this->_url,'home', false, false, true, 'jfeedback' );



		$link = str_replace('index2.php', 'index.php', $link);



		
		$params = new stdClass;

		$params->replyid='['.$tkrid.']';


		$params->description = $this->getChild( 'comment.replytrans', 'description' );

		$params->link = '<a href="'.$link.'">'.WText::t('1263274585KCHI').'</a>';					


	return $params;





}}