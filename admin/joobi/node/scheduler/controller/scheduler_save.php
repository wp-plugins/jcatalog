<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Scheduler_save_controller extends WController {


	





	function save(){

		$trucs=WGlobals::get('trucs');



		parent::save();


		$schedulerSID=WModel::get('scheduler','sid');

		if(empty($trucs[$schedulerSID]['wid'])) return true;



		$prefScheduler=WPref::get($trucs[$schedulerSID]['wid']);

		$editController=$prefScheduler->getPref('editcontroller','');

		


		
		if(empty($editController)) return true;



		if(empty($trucs[$schedulerSID]['schid'])){

			$message=WMessage::get();

			$message->userN('1236656718FWVX');

		}else{

			WPages::redirect('controller='.$editController.'&eid='.$trucs[$schedulerSID]['schid']);

		}



		return true;



	}}