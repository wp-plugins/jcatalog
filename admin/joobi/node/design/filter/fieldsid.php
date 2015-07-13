<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Fieldsid_filter {

function create() {

	$mainSID = WGlobals::get( 'sid' );

	if ( empty($mainSID) ) return false;

	$sidA = array();
	$sidA[] = $mainSID;

	
	$type = WModel::get( $mainSID, 'type' );
		if ( $type > 1 && $type < 30 ) {
		$newNAmekey = WModel::get( $mainSID, 'mainmodel' );
		$sidForTrans = WModel::get( $newNAmekey, 'sid' );
	} else {
		$sidForTrans = $mainSID;
	}

	$namekey = WModel::get( $sidForTrans, 'namekey' );
	$sidTrans = WModel::get( $namekey . 'trans', 'sid', null, false );

	if ( !empty($sidTrans) ) $sidA[] = $sidTrans;


	return $sidA;

}
}