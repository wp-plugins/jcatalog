<?php 

* @link joobi.co
* @license GNU GPLv3 */












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