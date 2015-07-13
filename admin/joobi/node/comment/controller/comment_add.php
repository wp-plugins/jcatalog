<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_add_controller extends WController {
function add() {


	WGlobals::setEID( 0 );

	if ( WUser::isRegistered() ) {

		$this->setView( 'comment_post_fe' );

	} else {

		if ( !defined('PCOMMENT_NODE_CMTNONORREG') ) WPref::get('comment.node');

		if ( ! PCOMMENT_NODE_CMTNONORREG ) {

			$message = WMessage::get();

			$message->userW('1327547572MFBV');

		}

	}
	return true;

}
}