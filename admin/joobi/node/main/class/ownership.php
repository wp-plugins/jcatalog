<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Main_Ownership_class extends WClasses {





	public function getOwner($showMessage=false) {

		$controller = WGlobals::get( 'controller' );
		if ( empty($controller) ) {
			if ( $showMessage ) $this->codeE( 'The ownership of this element could not be found.' );
		}

		$eid = WGlobals::getEID();
				$exist = WModel::modelExist( $controller, 'sid', null, false );
		if ( !$exist ) return false;

		$modelM = WModel::get( $controller, 'object', null, false );

		$noClass = false;
		if ( empty($modelM) ) {
			if ( $showMessage ) $this->codeE( 'The model does not exist for: ' . $controller );
			$noClass = true;
			return false;
		}
		if ( $modelM->columnExists( 'uid' ) ) {
			$pk = $modelM->getPK();
			$modelM->whereE( $modelM->getPK() , $eid );
			$uid = $modelM->load( 'lr', 'uid' );
		} else {
			if ( $showMessage ) $this->codeE( 'The uid column does not exist for the model: ' . $controller );
			return false;
		}

		$systemF = WGet::file();
		if ( ! $systemF->exist( $controller . '.ownership' ) ) {
			if ( $showMessage ) $this->codeE( 'The ownership class is not defined for the node: ' . $controller );
			return false;
		}

		return $uid;

	}
}