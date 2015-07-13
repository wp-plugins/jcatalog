<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











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