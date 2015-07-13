<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_email_friend_view extends Output_Forms_class {

function prepareView() {





	
	
	$eid = WGlobals::getEID();

	
	$modelName = WGlobals::get( 'model' );

	
	$pageLink = WGlobals::get( 'pagelink' );



	
	$allowedModelA = array( 'item' );

	if ( !in_array( $modelName, $allowedModelA ) ) return false;





	






	$name = WModel::getElementData( $modelName, $eid, 'name' );







	$NAME = WUser::get( 'name' );
	if ( !empty($name) ) {
		$ITEMNAME = $name;
		$subject = str_replace(array('$NAME','$ITEMNAME'), array($NAME,$ITEMNAME),WText::t('1369751035FRTG'));
	} else {
		$subject = str_replace(array('$NAME'), array($NAME),WText::t('1405649272JBFN'));
		$ITEMNAME = '';
	}


	WGlobals::set( 'subject', $subject );



	$LINK = base64_decode( $pageLink );


	$body = str_replace( array( '<br/>', '<br>', '<br />' ), "\n", str_replace(array('$ITEMNAME','$LINK'), array($ITEMNAME,$LINK),WText::t('1369751035FRTH')) );

	WGlobals::set( 'body', $body );



	return true;



}
}