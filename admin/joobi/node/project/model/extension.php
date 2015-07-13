<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Project_Extension_model extends WModel {










function addExtra() {



	
	$pojectExtenM = WModel::get( 'project.members');

	$pojectExtenM->whereE( 'pjid', $this->pjid );

	$allWid = $pojectExtenM->load( 'lra', 'uid');



	if ( !empty( $allWid ) ) {

		
		$extMembers = WModel::get('extension.members');



		foreach( $allWid as $uid ) {

			$extMembers->wid = $this->wid ;

			$extMembers->uid = $uid ;

			$extMembers->save();

		}


	}


	return parent::addExtra();

}
















function deleteExtra($eid=0) {



	
	$pojectExtenM = WModel::get( 'project.members');

	$pojectExtenM->whereE( 'pjid', $this->pjid );

	$allWid = $pojectExtenM->load( 'lra', 'uid');



	if ( !empty( $allWid ) ) {

		
		$extMembers = WModel::get('extension.members');

		$extMembers->whereE( 'wid', $this->wid );

		$extMembers->whereIn( 'uid', $allWid );

		return $extMembers->delete();



	}



	return true;
}









}