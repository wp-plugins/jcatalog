<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Comment_reply_delete_controller extends WController {


function delete() {





	parent::delete();

	$realVal =WGlobals::get('returnid');			
	$realVal = base64_decode($realVal);			

	return true;

}}