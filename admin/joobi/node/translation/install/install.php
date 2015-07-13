<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Translation_Node_install {

	public function install(&$object){

		$this->_populateAppsTrans();

		if( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall)){
												
		}
		return true;

	}





	function version_3665(){

		$libraryModelM=WModel::get( 'library.model' );
		$libraryModelM->whereSearch( 'namekey', 'translation.' );
		$libraryModelM->whereE( 'pnamekey', '' );
		$modelsA=$libraryModelM->load( 'ol', array( 'sid', 'namekey' ));

		if( empty($modelsA)) return false;

		foreach( $modelsA as $oneModel){

			if( 'translation.en'==$oneModel->namekey ) continue;

			$libraryModelM->whereE( 'sid', $oneModel->sid );
			$libraryModelM->setVal( 'pnamekey', 'translation.en' );
			$libraryModelM->update();

		}
	}





	private function _populateAppsTrans(){

		$appsM=WModel::get( 'install.apps' );
		$appsM->select( 'wid' );
		$appsM->whereE( 'type', 1 );
		$appsM->whereE( 'publish', 1 );
		$wids=$appsM->load( 'lra' );

		$langM=WModel::get( 'library.languages' );
		$langM->whereE( 'publish', 1 );
		$lgids=$langM->load( 'lra', 'lgid' );

		$appsTransM=WModel::get( 'apps.translations' );
		foreach( $wids as $wid){
			foreach( $lgids as $lgid){
				$appsTransM->setVal( 'wid', $wid );
				$appsTransM->setVal( 'lgid', $lgid );
				$appsTransM->setVal( 'modified', time());
				$appsTransM->setVal( 'modifiedby', WUser::get( 'uid' ));
				$appsTransM->setIgnore();
				$appsTransM->insert();
			}		}
	}
}