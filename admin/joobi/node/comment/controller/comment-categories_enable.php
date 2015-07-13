<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Comment_categories_enable_controller extends WController {








function enable() {

	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return false;


	$model = 'role.categories';

    $id = WGlobals::get( 'id' );		
    if ( empty($id) ) return true; 	        

   	    $cmtRestrictC = WClass::get('comment.restrictions');
	$cmtRestrictC->enable($id, $model);

	WPages::redirect('controller=comment-categories');

    return true;

}}