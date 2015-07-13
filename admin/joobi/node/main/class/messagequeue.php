<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Main_Messagequeue_class extends WClasses {







 	public function addEmailToQueue($user,$tempdata,$link='') {

 		if ( empty($tempdata->mgid) ) {
WMessage::log( 'Main_Messagequeue_class 1, the id is not defined for the email / message ', 'Main_Messagequeue_class' );
WMessage::log( $tempdata, 'Main_Messagequeue_class' );
 			return true;
 		}

 		$messageQueueM = WModel::get( 'main.messagequeue' );
 		$messageQueueM->uid = $user->uid;
		$messageQueueM->created = time();
		$messageQueueM->mgid = $tempdata->mgid;

		if ( !empty( $tempdata->title ) ) {
			$messageQueueM->title = $tempdata->title;
		} else {
			$messageQueueM->title = substr( $tempdata->subject, 0, 100 );
		}
		$outputProcessC = WClass::get('output.process');

		if ( !empty( $tempdata->subtitle ) ) {
			$outputProcessC->setParameters( $tempdata->parameters );
			$messageQueueM->subtitle = $outputProcessC->replaceTags( $tempdata->subtitle, $user );
		} else {
			$messageQueueM->subtitle = $tempdata->subject;
		}
		if ( !empty( $link ) ) {
			$messageQueueM->link = $link;
		}
		$messageQueueM->content = $outputProcessC->replaceTags( $tempdata->body, $user );

		$messageQueueM->save();

 	}








	public function addMessageToQueue($text,$uid=0,$params=null) {
		static $myMessage = array();
		static $myMessageKey = array();

		


				if ( is_array($uid) ) {
			$allUsers = $uid;
		} else {
			$allUsers = array( $uid );
		}
		if ( !empty($allUsers) ) {

			$messageQueueM = WModel::get( 'main.messagequeue' );

			foreach( $allUsers as $myuid ) {

				$messageQueueM->uid = ( is_object($myuid) ) ? $myuid->uid : $myuid ;
				$messageQueueM->created = time();
				$messageQueueM->priority = 99;
				$messageQueueM->content = $text;
				if ( !empty($params) ) $messageQueueM->params = serialize($params);
				$messageQueueM->save();

			}
		}
		return true;

	}

}


