<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_actions_addcontroller_controller extends WController {








	function addcontroller(){

		$actid=WGlobals::get('actid');

		$ctrid=WGlobals::get('ctrid');

		$add=WGlobals::get('add');



		$actionTriggerM=WModel::get( 'library.controlleraction' );	



		if( !empty($actid) && (!empty($ctrid))){

			$actionTriggerM->whereE('ctrid',$ctrid);

			$actionTriggerM->whereE('actid',$actid);

			if( $add){ 
				$actionTriggerM->setVal('ordering' , 1 );

				$actionTriggerM->setVal('publish',1 );

				$actionTriggerM->update();
			}else{  
				$actionTriggerM->setVal('publish',0 );

				$actionTriggerM->update();
			}
		}


		WPage::routeURL( 'controller=events-actions&task=listing&actid='.$actid );



		return true;

	}

}