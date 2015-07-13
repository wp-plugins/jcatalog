<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_Node_model extends WModel {










function __construct() {



	$filid = new stdClass;

	$filid->fileType = 'images';

	$filid->folder = 'media';

	$filid->path = 'images' . DS . 'vendors';

	$filid->secure = false;

	$filid->format = array('jpg','png','gif','jpeg');



	
	$filid->thumbnail = 1;		
	$filid->maxHeight = 0;		
	$filid->maxWidth = 0;

	$filid->maxTHeight = 50;	
	$filid->maxTWidth = 50;



	$this->_fileInfo = array();

	$this->_fileInfo['filid'] = $filid;



    parent::__construct( 'vendor', 'node', 'vendid' );

}












function addExtra() {



	
	if ( empty( $this->premium ) ) {



		$uid = WUser::get('uid');

		$user = WUser::get('name');



		$mailingM = WMail::get();



		$name = !empty( $this->name ) ? $this->name : $user;

		$email = !empty( $this->email ) ? $this->email : WUser::get('email');



		$myParams = new stdClass;

		$myParams->vendName = $name;

		$myParams->vendEmail = $email;

		$myParams->vendSite =(!empty($this->website))? $this->website : '';

		if ( isset($this->created) ) $myParams->dateCreated = WApplication::date( WTools::dateFormat( 'day-date' ), $this->created );

		else $myParams->dateCreated = WApplication::date( WTools::dateFormat( 'day-date' ), time() );

		$myParams->user = $user;



		$mailingM->setParameters( $myParams );

		$emailNameKey = 'vendor_created';



		if ( WPref::load( 'PVENDOR_NODE_NEWVENDORUSER' ) ) {

			$mailingM->sendNow( $uid, $emailNameKey );

		}


		if ( WPref::load( 'PVENDOR_NODE_NEWVENDORADMIN' ) ) {

			$mailingM->sendAdmin( $emailNameKey );

		}


	}




	
	$existOrganization = WExtension::exist( 'organization.node' );

	if ( !empty($existOrganization) ) {

		$organizationDetailsM = WModel::get( 'organization.details' );

		$organizationDetailsM->setVal( 'vendid', $this->vendid );

		$organizationDetailsM->setVal( 'organization', $this->getChild( 'vendortrans', 'name' ) );

		$organizationDetailsM->setVal( 'modifiedby', WUser::get( 'uid' ) );

		$organizationDetailsM->setVal( 'modified', time() );

		$organizationDetailsM->setVal( 'created', time() );

		$organizationDetailsM->insertIgnore();



		$organizationContactsM = WModel::get( 'organization.contacts', 'object' );

		$organizationContactsM->setVal( 'vendid', $this->vendid );

		$organizationContactsM->setVal( 'uid', $this->uid );

		$organizationContactsM->insertIgnore();



	}


	return true;



}









function validate() {






	
	if ( empty($this->curid) ) {

		$this->curid = WPref::load( 'PCURRENCY_NODE_PREMIUM' );

	}




	if ( empty($this->alias) && !empty($this->name) ) $this->alias = $this->name;



	return true;


}
















	public function secureTranslation($sid,$eid) {



		$translationC = WClass::get( 'vendor.translation', null, 'class', false );

		if ( empty($translationC) ) return false;



		
		if ( !$translationC->secureTranslation( $this, $sid, $eid ) ) return false;

		return true;



	}}