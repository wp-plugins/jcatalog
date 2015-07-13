<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');











class Project_Helper_class {













	function updateEstimatedTime($pjid,$value) {

		
		$sql=WModel::get('project');

		$sql->select('estimatedtime');

		$sql->whereE('pjid', $pjid);

		$estimatedtime=$sql->load('lr');




		
		$sql=WModel::get('project');
		$sql->setVal('estimatedtime',$estimatedtime + $value);

		$sql->whereE('pjid', $pjid);

		$sql->update();



		return true;

	}











 	function updateDeadline($pjid,$value) {

 		$projectM=WModel::get('project');

 		$projects=$projectM->getAllParents($pjid);



 		foreach($projects as $project) {

 			$sql=WModel::get('project');

 			$sql->setval('enddate', $value);

 			$sql->whereE('pjid', $project->pjid);

 			$sql->update();

 		}





		return true;

 	}


}
