<?php 

* @link joobi.co
* @license GNU GPLv3 */












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