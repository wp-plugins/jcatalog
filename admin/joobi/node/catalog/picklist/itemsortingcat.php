<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Itemsortingcat_picklist extends WPicklist {


	function create() {



		if ( WRoles::isAdmin( 'storemanager' ) ) { 
			
			$availableItemsA = array('ordering','newest','featured','alphabetic','reversealphabetic','oldest','recentlyupdated');

		} else {	
			
			$catitmavailsort = WGlobals::get( 'listItemsSorting', 'ordering,newest,alphabetic', 'global' );	
			$availableItemsA = WTools::pref2String( $catitmavailsort );

		}

				$choicesorting = WGlobals::get( 'choicesorting' );
		if ( empty($choicesorting) ) $choicesorting = WGlobals::get( 'catItemsSorting', '', 'global' );


		if ( !empty($choicesorting) ) {

			$availableItemsA[]= $choicesorting;

			$this->setDefault( $choicesorting );

		}
		
		$mypicklist = array();



		if ( in_array( 'ordering', $availableItemsA ) ) {

			$mypicklist['ordering'] = WText::t('1206732421RJQW');

		}


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	
	
	
	
	
	
	


		if ( in_array( 'newest', $availableItemsA ) ) {

			$mypicklist['newest'] = WText::t('1304918557EIYL');

		}
		if ( in_array( 'oldest', $availableItemsA ) ) {

			$mypicklist['oldest'] = WText::t('1307606755CNOQ');

		}


		if ( in_array( 'featured', $availableItemsA ) ) {

			$mypicklist['featured'] = WText::t('1256629159GBCH');

		}


		if ( in_array( 'alphabetic', $availableItemsA ) ) {

			$mypicklist['alphabetic'] = WText::t('1219769904NDIK');

		}
		if ( in_array( 'reversealphabetic', $availableItemsA ) ) {

			$mypicklist['reversealphabetic'] = WText::t('1307606756SRYP');

		}


		if ( in_array( 'recentlyupdated', $availableItemsA ) ) {

			$mypicklist['recentlyupdated'] = WText::t('1307606756SRYQ');

		}

		if ( in_array( 'random', $availableItemsA ) ) {
			$mypicklist['random'] = WText::t('1241592274CBNQ');
		}


		$count = count( $mypicklist );

		if ( empty($count) ) return false;

		elseif ( $count==1 ) {	
			if ( isset($mypicklist[$choicesorting]) ) return false;

		}


		foreach( $mypicklist as $key => $value ) {

			$this->addElement( $key, $value );

		}


		return true;


	}
}