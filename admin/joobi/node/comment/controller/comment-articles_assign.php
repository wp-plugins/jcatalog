<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_articles_assign_controller extends WController {








function assign() {

	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return false;


	$commentMID = WModel::getID('joomla.content');	

	$ids = array();
	$model = 'role.sections';
    $ids = WGlobals::get( 'id_'. $commentMID );		

			$commentC = WClass::get('comment.restrictions');
	$commentC->restrict($ids, $model);


	WPages::redirect('controller=comment-articles&task=listing');

        return true;



}}