<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_reply_back_controller extends WController {



function back() {







	$returnid = WGlobals::get( 'returnId' );			
	if (!empty($returnid)) {

		$realVal = base64_decode($returnid);

		WPages::redirect($realVal.'#comment');

	}

	else{

		
		WPages::redirect();

	}




	return true;

}}