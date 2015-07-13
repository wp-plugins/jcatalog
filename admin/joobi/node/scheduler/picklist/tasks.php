<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Scheduler_Tasks_picklist extends WPicklist {






	





	function create(){

		

		$lgid=WUser::get('lgid');

		$tasksM=WModel::get( 'scheduler' );

		$tasksM->makeLJ('schedulertrans','schid');


		$tasksM->whereE('publish',1);

		$tasksM->whereE('lgid',$lgid,1);

		$tasksM->select('schid');

		$tasksM->select('name',1);

		$tasksM->orderBy('name','ASC',1);

		$tasksM->setLimit(500);

		$tasks=$tasksM->load( 'ol');

		

		if(empty($tasks)) return false;

		

		foreach($tasks as $mytasks){

			$this->addElement( $mytasks->schid , $mytasks->name);

		}


		return true;

	}}