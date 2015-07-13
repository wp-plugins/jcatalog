<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Comment_Node_install extends WInstall {


public function install(&$object)  {


		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {

				$this->_insertDefType();

	} else {

				$prodTypeM = WModel::get( 'ticket.type' );
		$prodTypeM->whereE( 'namekey', 'feedback_items' );
		$exists = $prodTypeM->exist();

		if ( ! $exists ) {
						$this->_insertDefType();
		}
	}

	return true;


}







	public function addExtensions() {

		$extension = new stdClass;
		$extension->namekey = 'comment.content.plugin';
		$extension->name = 'Joobi - Joomla Articles Commeting';
		$extension->folder = 'content';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|comment|plugin';
		$extension->core = 1;
		$extension->params = 'publish=1';
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );

	}





	private function _insertDefType() {

		$listOfTypeA  = array();
		$typeO = new stdClass;
		$typeO->tktypeid = 80;
		$typeO->name = 'Items Feeback';
		$typeO->description = 'Feeback - Items Feeback';
		$typeO->namekey = 'feedback_items';
		$typeO->type = 19;
		$typeO->publish = 0;
		$typeO->ordering = 99;
		$listOfTypeA[] = $typeO;


		$useMultipleLang = WPref::load( 'PLIBRARY_NODE_MULTILANG' );
				$lgid = 1;
		if ( $useMultipleLang ) {
						if ( !isset($lgid) ) $lgid = WUser::get( 'lgid' );
			if ( empty($lgid) ) {
				$useMultipleLangENG = WPref::load( 'PLIBRARY_NODE_MULTILANGENG' );
				$lgid = ( $useMultipleLangENG ? 1: WApplication::userLanguage() );
			}
		}
		$prodTypeM = WModel::get( 'ticket.type' );
		$ticketTypeTansM = WModel::get( 'ticket.typetrans' );

		foreach( $listOfTypeA as $oneType ) {

			$prodTypeM->setVal( 'tktypeid', $oneType->tktypeid );

			$prodTypeM->setVal( 'alias', $oneType->name );
			$prodTypeM->setVal( 'namekey', $oneType->namekey );
			$prodTypeM->setVal( 'type', $oneType->type );
			$prodTypeM->setVal( 'publish', $oneType->publish );
			$prodTypeM->setVal( 'ordering', $oneType->ordering );
			$prodTypeM->setVal( 'core', 1 );
			$prodTypeM->returnId();
			$prodTypeM->insertIgnore();

			$typeID = ( !empty($prodTypeM->tktypeid) ? $prodTypeM->tktypeid : 0 );

			if ( empty($typeID) ) continue;

			$ticketTypeTansM = WModel::get( 'ticket.typetrans' );
			$ticketTypeTansM->setVal( 'lgid', $lgid );
			$ticketTypeTansM->setVal( 'tktypeid', $typeID );
			$ticketTypeTansM->setVal( 'name', $oneType->name );
			$ticketTypeTansM->setVal( 'description', $oneType->description );
			$ticketTypeTansM->insertIgnore();

		}
		return true;

	}


}