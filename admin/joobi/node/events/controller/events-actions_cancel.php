<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_actions_cancel_controller extends WController {


function cancel(){

	
	$modelID=WModel::getID( 'events.actions' );

	$trucs=WGlobals::get( 'trucs' );	

	$ctrid=$trucs['x']['ctrid'];



	$link='controller=events-actions&task=listing';



	
	if( !empty($ctrid)) $link .='&ctrid='. $ctrid;



	WPages::redirect( $link );

	return true;

}}