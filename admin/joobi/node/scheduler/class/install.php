<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Scheduler_Install_class extends WClasses {




	public function newScheduler($namekey,$name,$description,$priority=50,$fequency=86400,$maxTime=60,$maxProcess=1,$publish=1){


		$schedulerM=WModel::get('scheduler');
		$schedulerM->whereE( 'namekey', $namekey );
		if( $schedulerM->exist()) return true;


		$schedulerM->namekey=$namekey;
		$schedulerM->core=1;
		$schedulerM->setChild( 'schedulertrans', 'name', $name );
		$schedulerM->setChild( 'schedulertrans', 'description', $description );
		$schedulerM->frequency=$fequency;
		$schedulerM->priority=$priority;
		$schedulerM->maxtime=$maxTime;
		$schedulerM->maxprocess=$maxProcess;
		$schedulerM->publish=$publish;
		$schedulerM->ptype=1;
		$schedulerM->nextdate=time() - 100000;

		$schedulerM->save();


		return true;

	}
}