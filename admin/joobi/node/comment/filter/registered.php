<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Comment_Registered_filter {






function create() {

	$loguid = 1;	

	if (WUser::isRegistered())	$loguid = WUser::get('uid');	



	return $loguid ;

}}