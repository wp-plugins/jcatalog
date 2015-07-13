<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_articles_enable_controller extends WController {








function enable() {

	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return true;


	$model = 'role.content';
	$id = WGlobals::get( 'id' );			
	if ( empty($id) ) return true; 	        
	    $cmtRestrictC = WClass::get('comment.restrictions');
    $cmtRestrictC->enable($id, $model);

	WPages::redirect('controller=comment-articles');

    return true;

}}