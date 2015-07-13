<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Allowerdmodel_filter {


function create() {

	$eid = WGlobals::getEID();
		$designModelFieldsM = WModel::get( 'design.modelfields' );
	$designModelFieldsM->whereE( 'fdid', $eid );
	$sid = $designModelFieldsM->load( 'lr', 'sid' );
	if ( empty($sid) ) return false;


	$allSIDA = array();
	$allSIDA[] = $sid;

	$type = WModel::get( $sid, 'type' );

		if ( $type > 1 && $type < 30 ) {
				$newNAmekey = WModel::get( $sid, 'mainmodel' );
		$sidMain = WModel::get( $newNAmekey, 'sid' );
		if ( !empty($sidMain) ) $allSIDA[] = $sidMain;
	}
	$allFields = WPref::load( 'PDESIGN_NODE_FIELDALLTYPE' );
	$fieldalltable = WPref::load( 'PDESIGN_NODE_FIELDALLTABLE' );
	if ( $allFields ) {
				$libraryModelM = WModel::get( 'library.model' );
		$libraryModelM->makeLJ( 'library.model', 'dbtid', 'dbtid' );
		$libraryModelM->select( 'sid' );
		if ( $fieldalltable ) {
			$libraryModelM->whereIn( 'sid', $allSIDA, 1 );
		} else {
			$libraryModelM->whereE( 'sid', $sid, 1 );
		}		$allA = $libraryModelM->load( 'lra' );

		if ( !empty($allA) && is_array($allA) ) $allSIDA = array_merge( $allSIDA, $allA );

	}

	if ( empty($allSIDA) ) return $sid;


	return $allSIDA;


}
}