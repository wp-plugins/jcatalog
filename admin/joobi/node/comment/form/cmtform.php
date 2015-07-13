<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Comment_Cmtform_form extends WForm_layout {




function show() {
	if (! WUser::isRegistered()) {
		$controller = new stdClass;
		$controller->wid = WExtension::get( 'comment.node', 'wid' );
		$controller->level = 50;
		$controller->controller= 'comment';
		$controller->nestedView = true;
					if (!defined('PCOMMENT_NODE_CMTNONORREG')) WPref::get('comment.node');
		if (PCOMMENT_NODE_CMTNONORREG) {
			$viewC = WView::getHTML('post_comment_non_reg_fe', $controller);					$this->content = $viewC->make();
		} else {
			$message = WMessage::get();
			$MESSAGE = 'You need to log-in to Post a Comment';					$message->userW($MESSAGE);
			return '';
		}	} else {
		parent::create();
	}
return true;
}}