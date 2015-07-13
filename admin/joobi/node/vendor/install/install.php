<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class Vendor_Node_install extends WInstall {

	public function install(&$object) {

		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {
						$this->_defaultImage();

						$usersSyncroleC = WClass::get( 'users.syncrole' );
			$usersSyncroleC->updateThisRole( 'vendor', 'manager' );
			$usersSyncroleC->updateThisRole( 'storemanager', 'admin' );
			$usersSyncroleC->process();
		}
		return true;


	}






	private function _defaultImage() {


		
		$imageM = WModel::get( 'files' );

		$imageM->whereE( 'name', 'vendorx' );

		$imageID = $imageM->load( 'lr', 'filid' );



		if ( empty($imageID) ) {

			
			$vendorM = WModel::get( 'vendor' );
			$status = $vendorM->saveItemMoveFile( JOOBI_DS_NODE .'vendor' . DS . 'install' . DS . 'image'.DS. 'vendorx.png', '', true, 'filid' );
			if ( $status ) {
				$imageM->whereE( 'name', 'vendorx' );
				$imageM->setVal( 'core', 1 );
				$imageM->update();
			}		}


		return true;


	}
}