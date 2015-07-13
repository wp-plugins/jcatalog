<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreTranslate_button extends WButtons_external {


	function create() {



		$useMultipleLang = WPref::load( 'PLIBRARY_NODE_MULTILANG' );
		if ( empty($useMultipleLang) ) return false;



		WPage::addJSLibrary( 'joobibox' );



		$outputLinkC = WClass::get( 'output.link' );

		$href = $outputLinkC->convertLink( 'controller=item-translate&task=edit(eid=eid)(index=popup)', '', '' );

		$this->setAddress( $href, true );



		$this->setPopup();



		return true;



	}

}