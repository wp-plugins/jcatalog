<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_sections_enable_controller extends WController {










function enable() {
	$model = 'role.sections';

    $id = WGlobals::get( 'id' );			
    if ( empty($id) ) return true; 	        

	    $cmtRestrictC = WClass::get('comment.restrictions');
    $cmtRestrictC->enable($id, $model);


	WPages::redirect('controller=comment-sections');

    return true;

}}