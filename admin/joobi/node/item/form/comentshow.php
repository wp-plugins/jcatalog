<?php 

* @link joobi.co
* @license GNU GPLv3 */



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