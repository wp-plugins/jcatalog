<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Credentials_class extends WClasses {


public function getTypeName($credentialsID) {
	static $typeA = array();

	$myCredentialO = $this->_loadCredentials( $credentialsID );
	if ( empty($myCredentialO) ) return false;

	return $myCredentialO->typeNamekey;

}







public function loadFromID($credentialsID,$return=null) {

	return $this->_loadCredentials( $credentialsID, null, $return );

}









public function picklistFromCategory(&$object,$category=0,$firstValuesA=array()) {
	static $queryRA = array();

	if ( empty( $queryRA[$category] ) ) {

		$mainCredentialsM = WModel::get( 'main.credential' );
		$mainCredentialsM->makeLJ( 'main.credentialtype', 'crdidtype' );
		if ( !empty($category) ) {
				$mainCredentialsM->whereE( 'category', $category, 1 );
		}		$mainCredentialsM->whereE( 'publish', 1 );
		$queryRA[$category] = $mainCredentialsM->load( 'ol', array( 'alias', 'crdid') );
	}
	$object->addElement( 0, WText::t('1357343462IBXT') );

	if ( !empty($firstValuesA) ) {
		foreach( $firstValuesA as $categoryFirst => $val ) {
			$object->addElement( $categoryFirst, $val );
		}	}
	if ( !empty($queryRA[$category]) ) {
		foreach( $queryRA[$category] as $one ) {
			$object->addElement( $one->crdid, $one->alias );
		}	}
	return true;

}








public function picklistFromType(&$object,$type=0,$firstValuesA=array()) {
	static $queryRA = array();

	$key = serialize( $type );
	if ( empty( $queryRA[$key] ) ) {

		$mainCredentialsM = WModel::get( 'main.credential' );
		$mainCredentialsM->makeLJ( 'main.credentialtype', 'crdidtype' );
		if ( !empty($type) ) {
			if ( is_array($type) ) {
				$mainCredentialsM->whereIn( 'namekey', $type, 1 );
			} else {
				$mainCredentialsM->whereE( 'namekey', $type, 1 );
			}		}		$mainCredentialsM->whereE( 'publish', 1 );
		$queryRA[$key] = $mainCredentialsM->load( 'ol', array( 'alias', 'crdid') );
	}
	$object->addElement( 0, WText::t('1357343462IBXT') );

	if ( !empty($firstValuesA) ) {
		foreach( $firstValuesA as $keyFirst => $val ) {
			$object->addElement( $keyFirst, $val );
		}	}
	if ( !empty($queryRA[$key]) ) {
		foreach( $queryRA[$key] as $one ) {
			$object->addElement( $one->crdid, $one->alias );
		}	}
	return true;

}






public function loadFromType($credentialType=0,$return=null) {

	return $this->_loadCredentials( null, $credentialType, $return );

}







private function _loadCredentials($credentialsID=null,$type=null,$return=null) {
	static $credentialsA = array();

	if ( !isset($credentialsA[$credentialsID]) ) {

		$mainCredentialsM = WModel::get( 'main.credential' );
		$mainCredentialsM->select( 'namekey', 1, 'typeNamekey' );
		$mainCredentialsM->select( '*' );
		$mainCredentialsM->makeLJ( 'main.credentialtype' , 'crdidtype' );

		if ( !empty($credentialsID) ) $mainCredentialsM->whereE( 'crdid' , $credentialsID );
		elseif ( !empty($type) ) {
			if ( is_numeric( $type ) ) {
				$mainCredentialsM->whereE( 'crdidtype' , $type, 1 );
			} else {
				$mainCredentialsM->whereE( 'namekey' , $type, 1 );
			}			$mainCredentialsM->orderBy( 'premium', 'DESC' );
			$mainCredentialsM->orderBy( 'ordering' );
		} else {
			return false;
		}		$mainCredentialsM->whereE( 'publish', 1 );
		$myCredentialO = $mainCredentialsM->load( 'o' );
		if ( empty( $myCredentialO) ) return false;

		WTools::getParams( $myCredentialO );

		$credentialsID = $myCredentialO->crdid;
		$credentialsA[$credentialsID] = $myCredentialO;

	}
	if ( empty($return) ) {
		return $credentialsA[$credentialsID];
	} elseif ( isset( $credentialsA[$credentialsID]->$return ) ) {
		return $credentialsA[$credentialsID]->$return;
	} else return null;

}

}