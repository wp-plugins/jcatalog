<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'category.model.node' ,JOOBI_DS_NODE );
class Project_Node_model extends Category_Node_model {

	protected $_parentIdentifier = 'root';














function validate() {



	$message= WMessage::get();



	if ( isset($this->startdate) ) {

		
		$start=explode(' ', $this->startdate);

		$start=$start[0];

 		
 		if ($this->startdate != '0000-00-00 00:00:00') {

	  		$this->startdate = strtotime( $this->startdate );

 		}

 		
 		else $this->startdate=time();

	}


 	if (isset($this->enddate) && isset($this->startdate)) {

 		if ($this->enddate != '0000-00-00 00:00:00') {

	  		$this->enddate = strtotime( $this->enddate );

 		}

 		
 		else $this->enddate=$this->startdate + 3600 * 24 * 30;



		
		if ($this->enddate < $this->startdate) {

			$message->userN('1209674941LKQQ');

			$this->enddate=$this->startdate + 3600 * 24;

		}









		
		$projectM=WModel::get('project');

		$projectM->select('enddate');

		$projectM->whereE('pjid', $this->pjid);

		$oldvalue=$projectM->load('lr');



		WPref::get('task');

		if (!empty($oldvale) && $oldvalue < $this->enddate && PTASK_NODE_PROJECTDELAYED==1) {

			$mail=WMail::get();

			
			$projectM=WModel::get('project.members');

			$projectM->makeLJ( 'users', 'uid');

			$projectM->select('email', 1);

			$projectM->select('name', 1);

			$projectM->select('uid', 1);

			$projectM->whereE('pjid', $this->pjid, 0);

			$members=$projectM->load('ol');



			
			$projectM=WModel::get('project');

			$projectM->makeLJ('projecttrans', 'pjid');

			$projectM->select('name', 1);

			$projectM->select('enddate', 0);

			$projectM->whereE('pjid', $this->pjid);

			$project=$projectM->load('o');



			
			$footer='';

			if (PTASK_NODE_FOOTER != '') {

				$footer .= "\r\n\r\n";

				$footer .= PTASK_NODE_FOOTER;

			}



			
			$namekey='';

			if (PTASK_NODE_PROJECTNAME == 1) {

				$sql=WModel::get('project');

				$sql->select('namekey');

				$sql->whereE('pjid', $this->pjid);

				$result=$sql->load('lr');


				$namekey .= 'task_';

				$namekey .= $result;

			}



			
			$plink='';

			if (PTASK_NODE_LINK == 1) {

				$plink .= "\r\n\r\n";

				$plink .= WText::t('1227581091HODI');

				$plink .= "\r\n";

				$plink .= WPage::routeURL('controller=project&task=show&eid='.$this->pjid, 'smart');

			}



			$sender = WUser::get('object');

			

			$mail->replyTo( $sender->email, $sender->name );



			
			$mail->addParameter('projectname', $project->name);

			$mail->addParameter('deadline', date('d/M/Y', $this->enddate));

			$mail->addParameter('footer', $footer);

			$mail->addParameter('namekey', $namekey);

			$mail->addParameter('plink', $plink);



			$send=true;

			
			
			if (count($members) == 1 && $members[0]->uid == $sender->uid) {

				$send=false;

			}

			
			elseif (count($members) == 1) {

				$receiver_uid=$members[0]->uid;

			}

			
			elseif ($members[0]->uid == $sender->uid) {

				$receiver_uid=$members[1]->uid;
			}

			else {

				$receiver_uid=$members[0]->uid;
			}



			
			if ($send) {

				foreach($members as $member) {

					
					
					if ($member->uid == $sender->uid) {

						continue;

					}

					else {

						$mail->address( $member->email , $member->name );

					}



				}


				
				$mail->sendNow($receiver_uid,'notification_project_delayed');

			}
		}


		
		$projectM=WModel::get('project');

		$parents=$projectM->getAllParents($this->pjid);

		if (!empty($parents)) {

			foreach($parents as $parent) {

				$projectM->select('enddate');

				$projectM->whereE('pjid', $parent->pjid);

				$parent_enddate=$projectM->load('lr');

				if ($this->enddate > $parent_enddate) {

					$projectM=WModel::get('project');

					$projectM->setVal('enddate', $this->enddate);

					$projectM->whereE('pjid', $this->pjid);

					$projectM->update();

				}

			}
		}

 	}


	return parent::validate();



}












function addValidate() {



	$this->author=WUser::get('uid');



	


	return  parent::addValidate();

}












function extra() {





	
	if ( $this->_parent != 1 ) {

		
		$sql=WModel::get('project.milestones');

		$sql->select('mileid');

		$sql->whereE('pjid', $this->_parent);

		$milestones_parent=$sql->load('lra');



		
		$sql=WModel::get('project.milestones');

		foreach($milestones_parent as $mileid) {

			$sql->setVal('pjid', $this->pjid);

			$sql->setVal('mileid', $mileid);

			$sql->setIgnore();

			$sql->insert();

		}


	}




	
	










	






	return parent::extra();



}












function addExtra() {





	
	$projectM = WModel::get('project.members');


	$projectM->pjid = $this->pjid;

	$projectM->uid = WUser::get('uid');

	$projectM->role = '1';	


	$projectM->save();



	
	if ( $this->parent!=0 ) {

		$projectM->whereE( 'pjid', $this->parent );

		$allMembers = $projectM->load( 'ol', array('uid', 'role') );



		if ( !empty($allMembers) ) {

			foreach( $allMembers as $member ) {

				if ( $member->uid==$uid ) continue;

				$projectM->pjid=$this->pjid;

				$projectM->uid=$member->uid;

				$projectM->role=$member->role;

				$projectM->save();

			}
		}


	}


	return parent::addExtra();

}
















function deleteValidate($eid=0) {



	if ( empty($eid) ) return false;



	$projectM = WModel::get('project');

	$allChildren = $projectM->getChildNode( $eid, false);



	if ( !empty($allChildren) ) {

		$message = WMessage::get();

		$message->historyE('1209674941LKQR');

		return false;

	}






	
	$sql=WModel::get('project');

	$sql->select('estimatedtime');

	$sql->select('pjid');

	$sql->whereE('pjid', $eid);

	$project=$sql->load('o');



	
	$projectM=WModel::get('project');

	$myparents = $projectM->getAllParents($project->pjid);



	$helper= WClass::get('project.helper');

	if (!empty($myparents)) {

		foreach($myparents as $parent) {

			$helper->updateEstimatedTime($parent->pjid, -$project->estimatedtime); 
		}

	}



	return parent::deleteValidate( $eid );

}
















function deleteExtra($eid=0) {



	
	$pojectExtenM = WModel::get( 'project.extension');

	$pojectExtenM->whereE( 'pjid', $eid );

	$allWid = $pojectExtenM->load( 'lra', 'wid');



	if ( !empty( $allWid ) ) {

		
		$extMembers = WModel::get('extension.members');

		$extMembers->whereE( 'uid', $this->uid );

		$extMembers->whereIn( 'wid', $allWid );

		return $extMembers->delete();

	}


	return parent::deleteExtra( $eid );

}
}