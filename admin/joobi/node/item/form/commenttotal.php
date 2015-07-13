<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreCommenttotal_form extends WForms_default {


function show() {



	$hideComment = WGlobals::get( 'hidecomment' );

	$feedback = $this->getValue( 'feedback' );

	if ( empty( $feedback ) || ( !empty( $hideComment ) && $hideComment == 1 ) ) return false;



	

	$comment = WGlobals::get( 'itemAllowReview', false, 'global' );



	
	if ( $comment == 1 ) {



		$nbREviews = $this->getValue( 'nbreviews', $this->modelID );



		if ( !empty($nbREviews) ) {



			$pid = WGlobals::getEID();

			$commentC = WClass::get( 'comment.restrictions' );




			WGlobals::set( 'sharedItemType', 10, 'global' );

			$total = $commentC->count( $pid, false, 10 );		


		} else {

			$total = 0;

		}


		$commentButtonC = WClass::get( 'comment.button', null, 'class', false );



		if ( empty($commentButtonC) ) return true;



		$this->content = $commentButtonC->getTitle( $total, 'review' );



		return true;



	}else return false;



}
}