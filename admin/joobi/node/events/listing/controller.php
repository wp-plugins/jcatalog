<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Events_CoreController_listing extends WListings_default{






function create(){


		$actid=$this->getValue( 'actid', 'events.trigger' );

		
		if( $this->value){

			$controller='<span style="color:green">'.WText::t('1206732372QTKI').'</span>';

			$add=0;

		}else{

			$controller='<span style="color:red">'.WText::t('1206732372QTKJ').'</span>';

			$add=1;

		}


		$ctridGlobals=WGlobals::get('ctrid');

		
		$link=WPage::routeURL('controller=events-actions&task=addcontroller&actid='.$actid.'&ctrid='.$ctridGlobals.'&add='.$add );	






	 $this->content='<a href="'. $link .'">'.$controller.'</a>';



return true;



}}