<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Item_CoreNestedcomment_form extends WForm_layout {

	function show() {

		$hideComment = WGlobals::get( 'hidecomment' );
		$feedback = $this->getValue( 'feedback' );
		if ( empty( $feedback ) || ( !empty( $hideComment ) && $hideComment == 1 ) ) return false;

					$comment = WGlobals::get( 'itemAllowReview', false, 'global' );
				if ( $comment ) {

			if ( !empty($this->value) ) parent::create();

			$list = $this->content;

			if ( empty($list) ) {
				$type = 'first';
			} else $type = 'addcomment';

			$commentC = WClass::get( 'comment.button', null, 'class', false );
			if ( empty($commentC) ) return true;
			$list .= $commentC->addComment( $type, 'review' );

			$this->content = $list;
			return true;

		}
		return false;

	}
}