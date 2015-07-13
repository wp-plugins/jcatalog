<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreCommentcount_form extends WForms_default {










function show() {





	
	$MESSAGE = WText::t('1206961912MJQH');



	
	$eid = WGlobals::getEID();

	$option = WGlobals::getApp();		
	static $commentM = null;

	static $total = null;



	
	$secValue = WClass::get('comment.commenttype');

	$value = $secValue->comValue($option);

	$loguid = WUser::get('uid');



	
	if (!isset($commentM)) {

		$commentM = WModel::get('comment');

		$commentM->select('tkid',0, null,'count');

		$commentM->whereE('etid', $eid,0, null,1,0,0);

		$commentM->whereE('commenttype', $value ,0,null,0,1);

		$commentM->whereE('comment', 10);


		
		$commentM->whereE('authoruid', $loguid,0, null,2,0,0);

		$commentM->whereIn('private', array(0,1),0, null,0,1,0);

		$commentM->whereE('private',0,0,null,0,1,1);


		$total = $commentM->load('lr');


	}
	$this->_totalComments = $total;



	$this->value ='<a name=comment>' . $MESSAGE . ' ( '.$total.' ) </a>';



	return parent::create();

}}