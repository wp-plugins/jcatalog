<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Comment_categories_assign_controller extends WController {












function assign() {


	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return false;

	$commentMID = WModel::getID('joomla.categories');
	$ids = array();
    $ids = WGlobals::get( 'id_'. $commentMID );			$model = 'role.categories';

		$commentC = WClass::get('comment.restrictions');
	$commentC->restrict($ids, $model);


	WPages::redirect('controller=comment-categories');


    return true;



}}