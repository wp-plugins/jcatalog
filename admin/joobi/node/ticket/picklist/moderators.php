<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Moderators_picklist extends WPicklist {








function create() {

	

	
	$roleM=WModel::get('role');		
	$roleM->makeLJ('roletrans','rolid');	
	$roleM->whereIn('namekey',array('author', 'manager','admin','sadmin'),0);	

	$roleM->select('rolid',0);

	$roleM->select('name',1);		
	$roleM->groupBy('rolid',1);

	$roleM->setLimit( 10000 );

	$roles=$roleM->load('ol');

  
  	

  	foreach($roles as $role) {

  		$this->addElement($role->rolid,$role->name);

  	}
  	return true;

}}