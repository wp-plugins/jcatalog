<?php 

* @link joobi.co
* @license GNU GPLv3 */



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