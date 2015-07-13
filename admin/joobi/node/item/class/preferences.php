<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Item_Preferences_class extends WClasses {







	function onSavePref($preferencesA) {

		$pref = WPref::get( 'catalog.node' );
		
		$allMultipleSelectA = array( 'itmavailsort', 'catitmavailsort', 'itmmouseover', 'catitmmouseover', 'prdavailsort', 'bdlavailsort', 'vdlytitmavailsort', 'vdlytitmmouseover' );
		foreach( $allMultipleSelectA as $oneSelect ) {

			if ( !isset( $preferencesA['catalog.node'][$oneSelect]) ) {
				$pref->updatePref( $oneSelect, '' );
			}
		}

				$allDisplay = array( 'itmnbdisplay', 'crslnbdisplay', 'ctynbdisplay', 'vdrnbdisplay', 'catcrslnbdisplay', 'catctynbdisplay', 'catitmnbdisplay', 'catvdrnbdisplay', 'bdlnbdisplay', 'prdnbdisplay', 'vdlytcrslnbdisplay', 'vdlytctynbdisplay', 'vdlytitmnbdisplay' );
		foreach( $allDisplay as $onediaplay ) {
			if ( isset( $preferencesA['catalog.node'][$onediaplay] ) ) {
				$usersAddon = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.user' );
				$usersAddon->clearSession( 'site' );
				break;
			}		}

		$extensionHelperC = WCache::get();
		$extensionHelperC->resetCache( 'View' );

		return true;

	}

}