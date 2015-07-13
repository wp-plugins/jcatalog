<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreComentshow_form extends WForms_default {

function show() {


	$status = parent::create();



	$commentButtonC = WClass::get( 'comment.button', null, 'class', false );

	if ( empty($commentButtonC) ) return true;



	if ( empty($list) ) {

		$this->content .= $commentButtonC->addComment( 'first' );	
	} else {

		$this->content .= $commentButtonC->addComment( 'addcomment' );	
	}

	return true;


}
}