<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Comment_Restrictions_class extends WClasses {








 function restrict($ids,$model){

 		if (empty($ids)) return;

 	    $restrictSections = array();
		$notRestrictedIds = array();
		$updateRoleSecZero = array();
		$updateRoleSecOne = array();
		$notInsertedIds = array();

		$existIds = array();
		$rows = array('id','comment');

				$roleM = WModel::get($model);
        $roleM->whereIn('id', $ids);
        $existIds = $roleM->load('lra', 'id');

        if ( empty($existIds) ) return false;

 	    		$notInsertedIds = array_diff($ids, $existIds);

		if (!empty($notInsertedIds)) {

						foreach($notInsertedIds as $onerid){
				$restrictSections[$onerid]->id = $onerid;
				$restrictSections[$onerid]->comment = 1;
			}			$roleM->insertMany($rows,$restrictSections);
		} else {
									$roleSecInfo = array();
			$updateRoleSec = array();
			$id = array();
			$roleM->whereIn('id', $existIds);
			$roleSecInfo = $roleM->load('ol', $rows);

			foreach($roleSecInfo as $role){
				if ($role->comment == 1){ 					$updateRoleSecZero[] = $role->id; 				} else {
					$updateRoleSecOne[] = $role->id;  				}				$id[] = $role->id;
			}
						if (!empty($updateRoleSecOne)){
				$roleM->whereIn('id', $updateRoleSecOne);
				$roleM->setVal('comment', 1);
				$roleM->update();
			}
						if (!empty($updateRoleSecZero)){
				$roleM->whereIn('id', $updateRoleSecZero);
				$roleM->setVal('comment', 0);
				$roleM->update();
			}		}
 	return true;

 }






 function enable($id,$model){

        $roleM = WModel::get($model);
        $roleM->whereE( 'id', $id );
        $exist = $roleM->load( 'o' );

        if ( empty($exist) ) {				            $roleM->setVal( 'id', $id );		            $roleM->setVal( 'comment', 1 );
            $roleM->insert();
        }else {
            $roleM->select( 'comment');			            $roleM->whereE( 'id', $id );
			$allowComment = $roleM->load('lr');

			if ($allowComment) {									$action = 0;								}else {												$action = 1;								}
			$roleM->setVal( 'comment', $action );
			$roleM->whereE( 'id', $id );
	        $roleM->update();					
	} 		return true;
 }














public function count($eid,$query=false,$value=20) {

	static $memberId = null;
	static $commentM = null;
	static $total = null;
	if ( !isset($memberId) ) $memberId =WUser::get('uid');
	if ( !isset($commentM) ) $commentM = WModel::get('comment');
	$commentM->select('tkid',0, null,'count');
	$commentM->whereE('etid', $eid,0, null,1,0,0);
	$commentM->whereE('commenttype', $value , 0, null, 0,1 );
	$commentM->whereE('comment', 10);
	$commentM->whereE('publish', 1);

		if ($query) {
		$commentM->where('score','>', 1);
	}	$commentM->whereE('authoruid', $memberId,0, null,2,0,0);
	if (!empty( $memberId)) {
		 $commentM->whereIn('private', array(0,1),0, null,0,1,0);
	} else {
		 $commentM->whereE('private', 0,0, null,0,1,0);
	}
	$commentM->whereE('private',0,0,null,0,1,1);
	$totalR = $commentM->load('lr');

	return $totalR;
}


}