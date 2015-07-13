<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_reply_listing_controller extends WController {



function listing(){





	parent::listing();

	$uid =  WUser::get('uid');



	if (empty($uid)){

	$message = WMessage::get();

	$message->userW('1307514215TBVS');

	}


	return true;

}
}