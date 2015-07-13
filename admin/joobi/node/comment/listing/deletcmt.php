<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreDeletcmt_listing extends WListings_default{






function create() {



	if (!WUser::isRegistered()) return false;



	$widCat = WExtension::get( 'comment.node', 'wid' );

	if ( !empty($widCat) ) {


		WPage::addJSFile( 'node/comment/js/compile.js' );

	}


	$commentO=new stdClass;

	$commentO->authoruid = $this->getValue('authoruid');		
	$commentO->tkid = $this->getValue('tkid');

	$score = $this->getValue('score');			
	$commentO->privates = $this->getValue('private');

	$returnId = WView::getURI();					
	$realVal = base64_encode($returnId);				
	$etid=WGlobals::getEID();	
	$option = WGlobals::getApp();

	if ($option == 'com_content') $option = JOOBI_MAIN_APP;

	$commentO->delLink = 'index.php?option='.$option.'&controller=comment&task=delete&eid='.$commentO->tkid.'&etid='.$etid.'&score='.$score.'&returnid='.$realVal;

	$commentO->js = 'deleteComment';

	$commentO->editlink = WPage::routeURL('controller=comment&task=edit&eid='.$commentO->tkid.'&etid='.$etid.'&returnid='.$realVal,'', 'popup' ,false, false, JOOBI_MAIN_APP );

	$editdelbtn = WClass::get('comment.editdelbtn');		
	$this->content = $editdelbtn->showdeledit( $commentO ); 


	return true;

}}