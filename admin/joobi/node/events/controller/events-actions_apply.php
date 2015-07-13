<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_actions_apply_controller extends WController {



function apply(){

	
	$modelID=WModel::getID( 'events.actions' );

	$trucs=WGlobals::get( 'trucs' );

	$chkactid=$trucs[$modelID][ 'actid' ];

	$ctrid=$trucs['x']['ctrid'];



	
	parent::apply();



	
	$actid=( isset($this->_model->actid)) ? $this->_model->actid : 0;



	if( empty($actid))

	{

		$namekey=( isset($this->_model->namekey)) ? $this->_model->namekey : '';



		$libActionM=WModel::get( 'events.actions' );

		$libActionM->whereE( 'namekey', $namekey );

		$actid=$libActionM->load( 'lr', 'actid' );

	}


	$link='controller=events-actions&task=edit&eid='. $actid;



	
	if( !empty($ctrid) && ( empty($chkactid) || ( $chkactid==0 )) )

	{

		
		$libActTriggerM=WModel::get( 'library.controlleraction' );	
		$libActTriggerM->ctrid=$ctrid;

		$libActTriggerM->actid=$actid;

		$libActTriggerM->publish=1;

		$libActTriggerM->save();

	}


	
	if( !empty($ctrid)) $link .='&ctrid='. $ctrid;



	WPages::redirect( $link );

	return true;

}}