<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Events_Filterctridaction_filter {








function create()

{

	$ctrid=WGlobals::get( 'ctrid' );



	static $libActTriggerM=null;

	if( !isset($libActTriggerM)) $libActTriggerM=WModel::get( 'library.controlleraction' );	
	$libActTriggerM->whereE( 'ctrid', $ctrid );

	$resultaA=$libActTriggerM->load( 'lra', 'actid' );



	$libActTriggerM->where( 'ctrid', '!=', $ctrid );

	$resultbA=$libActTriggerM->load( 'lra', 'actid' );



	$resultA=array_merge( $resultaA, $resultbA );



	return $resultA;

}}