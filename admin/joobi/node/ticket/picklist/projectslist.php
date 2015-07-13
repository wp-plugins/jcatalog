<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_Projectslist_picklist extends WPicklist {






	





	function create() {



		$ticketProjM=WModel::get('ticket.project');

		$ticketProjM->makeLJ('ticket.projecttrans','pjid');

		$ticketProjM->select('pjid', 0, 'projectid');

		$ticketProjM->orderBy('ordering', 'ASC');

		$ticketProjM->select('name', 1);

		$ticketProjM->whereE('publish', 1);

		$list = $ticketProjM->load('ol');



		if (empty($list)) return true;



		foreach($list as $project)  {

			$this->addElement($project->projectid,$project->name);

		}


   }































}