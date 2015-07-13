<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



 class Project_Members_model extends WModel {















 	function addExtra() {





















		
		$projectM = WModel::get('project');

		$allChildren = $projectM->getChildNode( $this->pjid, false);

		if ( !empty($allChildren) ) {

			$projectMembersM = WModel::get('project.members');

			foreach( $allChildren as $child ) {

				$projectMembersM->uid = $this->uid;

				$projectMembersM->pjid = $child;

				$projectMembersM->role = $this->role;

				$projectMembersM->save();

			}
		}




 		return parent::addExtra();

 	}
















 	function deleteExtra($eid=0) {




		if ( !isset( $this->pjid ) ) {

			return false;

		}
		
		$pojectExtenM = WModel::get( 'project.extension');

		$pojectExtenM->whereE( 'pjid', $this->pjid );

		$allWid = $pojectExtenM->load( 'lra', 'wid');



		if ( !empty( $allWid ) ) {

			
			$extMembers = WModel::get('extension.members');

			$extMembers->uid = $this->uid;

			$extMembers->whereE( 'uid', $this->uid );

			$extMembers->whereIn( 'wid', $allWid );

			return $extMembers->delete();

		}


		
		$projectM = WModel::get('project');

		$allChildren = $projectM->getChildNode( $this->pjid, false);

		if ( !empty($allChildren) ) {

			$projectMembersM = WModel::get('project.members');

			$projectMembersM->whereE( 'uid', $this->uid );

			$projectMembersM->whereIn( 'pjid', $allChildren );

			return $projectMembersM->delete();

		}





		return true;

 	}






 }


