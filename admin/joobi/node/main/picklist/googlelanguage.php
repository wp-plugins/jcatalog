<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Googlelanguage_picklist extends WPicklist {

	function create() {



		$languageM = WModel::get( 'library.languages' );
		$languageM->whereE( 'main', 1 );
		$languageM->orderBy( 'automatic', 'DESC' );
		$languageM->orderBy( 'availsite', 'DESC' );
		$languageM->orderBy( 'availadmin', 'DESC' );
		$languageM->orderBy( 'name', 'ASC' );
		$languagesA = $languageM->load( 'ol', array( 'lgid', 'code', 'name', 'automatic' ) );
		if ( empty($languagesA) ) return false;

		$lang = WGlobals::get( 'googleTranslateMainLg', 'en', 'global' );
		$this->addElement( '', WText::t('1242282416HAQB') );

		$useAuto = false;
		foreach( $languagesA as $oneLang ) {

									if ( !empty($oneLang->automatic) ) $useAuto = true;
			if ( $useAuto && empty($oneLang->automatic) ) continue;

			$this->addElement( $lang . '|' . $oneLang->code, $oneLang->name );

		}

		return true;



	}
}