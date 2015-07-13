<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');
 class Project_Savemilestones_controller extends WController {








	function savemilestones() {

		$message = WMessage::get();



		$truc = WGlobals::get('trucs');



		$sid = WModel::get('milestone','sid');

		$sidpj = WModel::get('project.milestones','sid');

		$sidtrans = WModel::get('milestonetrans','sid');



		
		
		$sql=WModel::get('project');

		$sql->select('parent');

		$sql->whereE('pjid', $truc[$sidpj]['pjid']);

		$parent=$sql->load('lr');



		if ($parent != 1) {

			$message->userN('1227581089KZZR');

	

			return true;

		}



		
		if (isset($truc[$sidtrans]['name']) && empty($truc[$sidtrans]['name'])) {

			$message->userN('1227581089KZZS');

	

			return true;

		}



		
		elseif (is_array($truc) && isset($truc[$sid]) && isset($truc[$sidtrans])) {

			parent::save();



			


			
			$milestoneM=WModel::get('milestone');



			
			$projectM=WModel::get('project');

			$children=$projectM->getChildNode($truc[$sidpj]['pjid']);



			if (!empty($children)) {

				
				foreach($children as $child) {

					$sql=WModel::get('project.milestones');

					$sql->setVal('pjid', $child);

					$sql->setVal('mileid', $milestoneM->lastId());

					$sql->insert();

				}

			}



			$milestone_name=$truc[$sidtrans]['name'];

			$message->userS('1227581089KZZT',array('$milestone_name'=>$milestone_name));

			return true;

		}



		else {

			$message->userW('1227581089KZZU');

	

			return true;

		}



	}
}