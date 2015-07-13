<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Scheduler_Node_install extends WInstall {


public function install($object)  {


	
	return true;


}






	public function addExtensions(){

		$extension=new stdClass;
		$extension->namekey='scheduler.system.plugin';
		$extension->name='Joobi - Cron Tasks trigger';
		$extension->folder='system';
		$extension->type=50;
		$extension->publish=1;
		$extension->certify=1;
		$extension->destination='node|scheduler|plugin';
		$extension->core=1;
		$extension->params='publish=0';
		$extension->description='';

		if( $this->insertNewExtension( $extension )) $this->installExtension( $extension->namekey );

	}


}