<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_sections_assign_controller extends WController {






function assign() {


		$commentMID = WModel::getID('joomla.sections');			$ids = array();
		$existIds = array();

        $ids = WGlobals::get( 'id_'. $commentMID );		
		$model = 'role.sections';

				$commentC = WClass::get('comment.restrictions');
		$commentC->restrict($ids, $model);

		WPages::redirect('controller=comment-sections');

        return true;



}}