<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_reply_delete_controller extends WController {


function delete() {





	parent::delete();

	$realVal =WGlobals::get('returnid');			
	$realVal = base64_decode($realVal);			

	return true;

}}