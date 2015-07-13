<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreShowreplies_listing extends WListings_default{





function create() {



	
	WPref::load( 'PCOMMENT_NODE_ALLOWREPLY' );	
	$allowReply = PCOMMENT_NODE_ALLOWREPLY;

	if ( !$allowReply ) return false;



	static $commentrepM = null;

	static $total = 0;

	$tkid = $this->getValue('tkid');

	$txtID = $this->modelID.'_comment_fe';



	if (!isset($commentrepM)) $commentrepM = WModel::get('comment.reply');

	$commentrepM->select('tkrid',0, null,'count');

	$commentrepM->whereE('tkid', $tkid, 0, null );

	$total = $commentrepM->load('lr');



	$returnId = WView::getURI();					
	$realVal = base64_encode( $returnId );



	
	$linkseereplies = WPage::routeURL('controller=comment-reply&task=listing&tkid='.$tkid.'&returnId='.$realVal, '','popup', false, false, JOOBI_MAIN_APP );



	$text =  ( $total > 0 ) ? WText::t('1263201684IZCU') . ' <span class="badge">'  .$total . '</span>' : WText::t('1206961882TDGX');







	$objButtonO = WPage::newBluePrint( 'button' );

	$objButtonO->type = 'standard-question';

	$objButtonO->popUpIs = true;

	$objButtonO->popUpWidth = '80%';

	$objButtonO->popUpHeight = '70%';

	$objButtonO->link = $linkseereplies;

	$objButtonO->text = $text;

	$objButtonO->icon = 'fa-plus';

	$objButtonO->color = 'primary';

	$this->content = WPage::renderBluePrint( 'button', $objButtonO );



	return true;



}}