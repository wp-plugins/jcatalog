<?php 

* @link joobi.co
* @license GNU GPLv3 */



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