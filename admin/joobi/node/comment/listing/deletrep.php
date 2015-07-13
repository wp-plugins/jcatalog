<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreDeletrep_listing extends WListings_default{






function create() {



	
		$commentO=new stdClass;

		$commentO->authoruid = $this->getValue('authoruid');			
		$tkrid = $this->getValue('tkrid');

		$commentO->tkid =WGlobals::get('tkid');

		$returnId = WView::getURI();					
		$returnIdd = WGlobals::get('returnId');			
		$commentO->delLink = WPage::routeURL('controller=comment-reply&task=delete&eid='.$tkrid.'&tkid='.$commentO->tkid.'&returnId='.$returnIdd);

		$commentO->js = 'confirmation';

		$commentO->editlink = WPage::routeURL('controller=comment-reply&task=edit&eid='.$tkrid.'&tkid='.$commentO->tkid.'&returnId='.$returnIdd);

		$editdelbtn = WClass::get('comment.editdelbtn');

		$commentO->privates=null;

		$this->content = $editdelbtn->showdeledit($commentO); 
	return true;

}}