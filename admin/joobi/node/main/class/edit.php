<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Main_Edit_class extends WClasses {





	function checkEditAccess() {

		if ( WRoles::isAdmin( 'manager' ) ) return true;

		if ( WPref::load( 'PMAIN_NODE_DIRECT_EDIT' ) ) {
			$access = WPref::load( 'PMAIN_NODE_DIRECT_ACCESS' );
			if ( $access < 1 ) return false;
			
			if ( ! WRole::hasRole( $access ) ) return false;

			return true;
		}
		return false;

	}





	function checkTranslateAccess() {

		if ( WRoles::isAdmin( 'manager' ) ) return true;

		if ( WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' ) ) {
			$access = WPref::load( 'PMAIN_NODE_DIRECT_ACCESS' );
			if ( $access < 1 ) return false;
			
			if ( ! WRole::hasRole( $access ) ) return false;

			return true;
		}
		return false;

	}
}