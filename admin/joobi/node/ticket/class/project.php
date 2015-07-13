<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

















class Ticket_project_class extends WClasses {



	







	var $projectID='';

	







	var $projectName='';



	







	var $_jProject=0;

	







	var $_message;





	





	function __construct($init=''){

		if ($init==''){

			if ( (PTICKET_NODE_TKPROJECT) && WGlobals::checkCandy(50) )

				$this->_jProject='1';

		}

		$this->_message= WMessage::get();

	}
















	function setPjID($tkid){

		$ticketM=WModel::get('ticket');

		$ticketM->whereE('tkid',$tkid);

		if ($this->_jProject)

			$this->projectID=$ticketM->load('lr','pjid');

		else

			$this->projectID=$ticketM->load('lr','pjid');

		return $this->projectID;

	}



	









	function setPjName($projectId='',$lgid='1'){

		
		if (($projectId=='')&&($this->projectID=='')){

			$this->_message->userE('1215507799GMTI');

			return '';

		}

		
		if ($projectId!='') $this->projectID=$projectId;

		
		if ($this->_jProject){

			$projectM=WModel::get('projecttrans');

			$projectM->whereE('pjid',$this->projectID);

		}

		else {

			$projectM=WModel::get('ticket.projecttrans');

			$projectM->whereE('pjid',$this->projectID);

		}

		$projectM->whereE('lgid',$lgid);

		$this->projectName=$projectM->load('lr','name');

		return $this->projectName;

	}



	













	function alterProjectAssignedPersons($title,$content,$ticketid='',$lgid='1'){

		if ($ticketid!='')

			$this->setPjID($ticketid);

		$this->setPjName();



		$assigned = $this->assignedPeople();



		
		if (!empty($assigned)){

			$mail=WMail::get();

			$user = array();

			foreach($assigned AS $person){

				$user[] = WUser::get('data',$person);


			}

			$mail->sendTextQueue( $user, $title, $content );

		}

	}






	







	function assignedPeople(){

		if ($this->_jProject){

			$assignM=WModel::get('project.members');

			$assignM->whereE('pjid',$this->projectID);

		}

		else{

			$assignM=WModel::get('ticket.projectmembers');

			$assignM->whereE('pjid',$this->projectID);

		}

		return $assignM->load('lra','uid');

	}























	function jProjectManagement($switchOn=true){




		return true;



			
			
			$defaultProject=1;

			$jProject=0;

			if ($switchOn){

				$defaultProject=0;

				$jProject=1;

			}





			
				
			$controller=null;

			$controller->wid = WExtension::get( 'ticket','wid');

			$yids['form']= WView::get( 'task_form', 'yid');



			$formElemM=WModel::get('library.viewforms');

			$this->_updateTicketForm($defaultProject,$yids['form'],'pjid',$formElemM);
			$this->_updateTicketForm($jProject,$yids['form'],'pjid',$formElemM);


				
			$ticketPjSid=WModel::get('ticket.project','sid');

			$ticketPjSidTr=WModel::get('ticket.projecttrans','sid');

			$projectSid=WModel::get('project','sid');

			$projectSidTr=WModel::get('projecttrans','sid');








			$listElemM=WModel::get('library.viewlistings');

			$this->_updateTicketsList($defaultProject,$yids,array($ticketPjSid,$ticketPjSidTr),$listElemM);
			$this->_updateTicketsList($jProject,$yids,array($projectSid,$projectSidTr),$listElemM);


				
			$listElemM->setVal('publish',$jProject);

			$listElemM->whereE('yid',WView::get( 'project_listing', 'yid'));

			$listElemM->whereE('sid',WModel::get('project','sid'));

			$listElemM->whereE('map','ticket');

			$listElemM->update();





			
			$pickM=WModel::get('library.picklist');

			$pickM->whereIn('namekey',array('ticket_projecttrans_all','projects_namekey_list'));

			$OLdidsD=$pickM->load('ol',array('namekey','did'));
			$didsD=$this->_turnToArray($OLdidsD);



			$pickM->whereIn('namekey',array('jprojecttrans_all','jprojects_namekey_list'));

			$OLdidsJ=$pickM->load('ol',array('namekey','did'));
			$didsJ=$this->_turnToArray($OLdidsJ);



			$viewPickM=WModel::get('library.viewpicklist');

			if ($defaultProject){

				$this->_deleteViewPicklist($didsJ,$yids,$viewPickM);

				$this->_saveViewPicklist($didsD,$yids,$viewPickM);

			}

			else{

				$this->_deleteViewPicklist($didsD,$yids,$viewPickM);

				$this->_saveViewPicklist($didsJ,$yids,$viewPickM);

			}





			
			$yids['menu']= WView::get( 'jtickets_main', 'yid');



			$menuElemM=WModel::get('library.viewmenus');

			$this->_updateTicketMenu($defaultProject,$yids['menu'],'ticket.project',$menuElemM);
			$this->_updateTicketMenu($jProject,$yids['menu'],'project',$menuElemM);




			
			$filterM=WModel::get( 'library.viewfilters', 'object' );

			$this->_updateFilter($defaultProject,'only_published_projects',$filterM);
			$this->_updateFilter($jProject,'only_published_jprojects',$filterM);
	}



	













	function _updateTicketForm($publishValue,$yid,$map,$formElemM){

		$formElemM->setVal('publish',$publishValue);

		$formElemM->whereE('yid',$yid);

		$formElemM->whereE('map',$map);

		$formElemM->update();

	}



	













	function _updateTicketsList($publishValue,$yids,$sids,$listElemM){

		$listElemM->setVal('publish',$publishValue);

		$listElemM->whereIn('yid',$yids);

		$listElemM->whereIn('sid',$sids);

		$listElemM->update();

	}



	













	function _deleteViewPicklist($dids,$yids,$viewPickM){

		$viewPickM->whereIn('did',$dids);

		$viewPickM->whereIn('yid',$yids);

		$viewPickM->delete();

	}



	













	function _saveViewPicklist($dids,$yids,$viewPickM){

		$viewPickM->yid=$yids['backend'];

		$viewPickM->did=$dids['all'];

		$viewPickM->save();



		$viewPickM->yid=$yids['frontendpu'];

		$viewPickM->did=$dids['list'];

		$viewPickM->save();



		$viewPickM->yid=$yids['frontendpr'];

		$viewPickM->did=$dids['list'];

		$viewPickM->save();

	}



	













	function _updateTicketMenu($publishValue,$yid,$action,$menuElemM){

		$menuElemM->setVal('publish',$publishValue);

		$menuElemM->whereE('yid',$yid);

		$menuElemM->whereE('action',$action);

		$menuElemM->update();

	}



	











	function _turnToArray($OLdids){

		$dids=array();

		$namekey='';

		foreach($OLdids as $obj){

			$namekeyArr=explode('_',$obj->namekey);

			$namekey=$namekeyArr[sizeof($namekeyArr)-1];
			$dids[$namekey]=$obj->did;

		}

		return $dids;

	}



	











	function _updateFilter($publishValue,$namekey,$filterM){

		$filterM->setVal('publish',$publishValue);

		$filterM->whereE('namekey',$namekey);

		$filterM->update();

	}



 }