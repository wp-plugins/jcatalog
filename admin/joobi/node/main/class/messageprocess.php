<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Main_Messageprocess_class extends WClasses {







 	public function getMobileNotification($uid=0,$mobileId='') {

 		if ( empty($uid) ) return array();

 		 		 		$mainMessagequeueM = WModel::get( 'main.messagequeue' );
 		$mainMessagequeueM->whereE( 'uid', $uid );
 		$mainMessagequeueM->whereE( 'isread', 0 );
 		$mainMessagequeueM->orderBy( 'created', 'ASC' );
 		$mainMessagequeueM->setLimit( 10 );
 		$mainMessagequeueM->select( 'mgqid' );
 		$mainMessagequeueM->select( 'title' );
 		$mainMessagequeueM->select( 'subtitle' );
 		$mainMessagequeueM->select( 'content' );
 		$mainMessagequeueM->select( 'link' );
 		$notifA = $mainMessagequeueM->load( 'ol' );

 		if ( empty($notifA) ) return array();

 		$mobileNotifA = array();
 		$queueToUpdateA = array();
 		$emailHelperC = WClass::get( 'email.conversion' );
 		foreach( $notifA as $one ) {

 			$alertO = new stdClass;
 			$alertO->id = $one->mgqid;	 			$alertO->title = $emailHelperC->HTMLtoText( $one->title, false, false, true );
 			$alertO->subtitle = $emailHelperC->HTMLtoText( $one->subtitle, false, true );
 			if ( !empty($one->link) ) {
 				$alertO->link = $one->link;
 			} else {
 				if ( !empty($one->content) ) $alertO->content = $emailHelperC->HTMLtoText( $one->content, false, true );
 			}
 			$mobileNotifA[] = $alertO;

 			$queueToUpdateA[] = $one->mgqid;

 		}

 		$mainMessagequeueM->whereIn( 'mgqid', $queueToUpdateA );
 		$mainMessagequeueM->setVal( 'isread', 1 );
 		$mainMessagequeueM->update();

 		return $mobileNotifA;











 	}







}