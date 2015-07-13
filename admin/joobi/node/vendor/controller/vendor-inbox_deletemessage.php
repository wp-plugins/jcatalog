<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_deletemessage_controller extends WController {




function deletemessage() {


	
	$vendid = WGlobals::get( 'id' );

	$trucs = WGlobals::get('trucs');
	$getID = $trucs['s']['mid'];

	$modelID = ( !empty( $getID ) ) ? $getID : WModel::getID( 'conversation' );

	$map = 'mcid_'. $modelID;

	$mcidA = WGlobals::get( $map );







	
	if ( !empty($mcidA) ) {

		$conversationM = WModel::get( 'conversation' );

		$conversationToM = WModel::get( 'conversation.to' );

		$conversationStatusM = WModel::get( 'conversation.status' );


				$uid = WUser::get( 'uid' );
		$conversationM = WModel::get( 'conversation' );
		$conversationM->makeLJ( 'conversation.to', 'mcid' );
		$conversationM->whereIn( 'mcid', $mcidA );
		$conversationM->whereE( 'uid', $uid, 1 );
		$sureMessageIdsA = $conversationM->load( 'lra', 'mcid' );



		$mcidA = $sureMessageIdsA;


		foreach( $mcidA as $mcid ) {

			
			$msgHaveChild = $this->_haveChild( $mcid );



			
			$msgHasParent = $this->_hasParent( $mcid );



			
			
			if ( !$msgHaveChild && !$msgHasParent ) {

				$this->_deleteMessage( 'conversation', $mcid );

				$this->_deleteMessage( 'conversation.status', $mcid );

				$this->_deleteMessage( 'conversation.to', $mcid );


			} else {

				
				$this->_tempDeleteMessage( $mcid );



				
				$foundChild = $this->_unremoveChildFound( $mcid );

				$foundParent = $this->_unremoveChildFound( $mcid );



				
				
				if ( !$foundChild && !$foundParent ) {

					$this->_deleteMessage( 'conversation', $mcid );

					$this->_deleteMessage( 'conversation.status', $mcid );

					$this->_deleteMessage( 'conversation.to', $mcid );

				}
			}
		}
	}


	$link = ( !empty($vendid) ) ? 'controller=vendor-inbox&task=listing&id='. $vendid : 'controller=vendor-inbox&task=listing';

	WPages::redirect( $link, true );


	return true;


}












private function _haveChild($mcid) {

	static $conversationM=null;

	if ( !isset($conversationM) ) $conversationM = WModel::get( 'conversation' );

	$conversationM->select( 'mcid', 0, null, 'count' );

	$conversationM->whereE( 'parent', $mcid );

	$result = $conversationM->load( 'lr' );



	$returnValue = ( !empty($result) && ( $result > 0 ) ) ? true : false;

	return $returnValue;

}












private function _hasParent($mcid) {

	static $conversationM=null;

	if ( !isset($conversationM) ) $conversationM = WModel::get( 'conversation' );

	$conversationM->select( 'parent' );

	$conversationM->whereE( 'mcid', $mcid );

	$result = $conversationM->load( 'lr' );



	$returnValue = ( !empty($result) ) ? true : false;

	return $returnValue;

}












private function _deleteMessage($modelName,$mcid) {

	static $modelA=array();

	if ( !isset( $modelA[$modelName] ) ) $modelA[$modelName] = WModel::get( $modelName );

	$modelA[$modelName]->whereE( 'mcid', $mcid );

	$modelA[$modelName]->delete();



	return true;

}














private function _tempDeleteMessage($mcid) {

	static $conversationToM=null;

	if ( !isset( $conversationToM ) ) $conversationToM = WModel::get( 'conversation.to' );

	$conversationToM->setVal( 'uid', 0 );

	$conversationToM->whereE( 'mcid', $mcid );

	$conversationToM->update();



	$this->_deleteMessage( 'conversation.status', $mcid );



	return true;

}


















private function _unremoveChildFound($mcid) {

	static $conversationM=null;

	if ( !isset($conversationM) ) $conversationM = WModel::get( 'conversation' );

	$conversationM->makeLJ( 'conversation.to', 'mcid', 'mcid', 0, 1 );

	$conversationM->select( 'mcid', 0, null, 'count' );

	$conversationM->where( 'uid', '>', 0, 1 );

	$conversationM->whereE( 'parent', $mcid, 0 );

	$result = $conversationM->load( 'lr' );



	$returnValue = ( !empty($result) && ( $result > 0 ) ) ? true : false;

	return $returnValue;

}












private function _unremoveParentFound($mcid) {

	
	static $conversationM=null;

	if ( !isset($conversationM) ) $conversationM = WModel::get( 'conversation' );

	$conversationM->whereE( 'mcid', $mcid );

	$getParentmcid = $conversationM->load( 'lr', 'parent' );



	
	static $conversationToM=null;

	if ( !isset( $conversationToM ) ) $conversationToM = WModel::get( 'conversation.to' );

	$conversationToM->whereE( 'mcid', $mcid );

	$result = $conversationToM->load( 'lr', 'uid' );



	$returnValue = ( !empty($result) && ( $result > 0 ) ) ? true : false;

	return $returnValue;

}}