<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_actions_save_controller extends WController {


function save(){


	
	$modelID=WModel::getID( 'events.actions' );

	$trucs=WGlobals::get( 'trucs' );

	$actid=$trucs[$modelID][ 'actid' ];

	$ctrid=( isset($trucs['x']['ctrid']) && !empty($trucs['x']['ctrid'])) ? $trucs['x']['ctrid'] : 0;



	
	parent::save();



	$link='controller=events-actions&task=listing';



	
	if( empty($actid)){


		
		$actid=( isset($this->_model->actid)) ? $this->_model->actid : 0;



		if( empty($actid))

		{

			$namekey=( isset($this->_model->namekey)) ? $this->_model->namekey : '';



			$libActionM=WModel::get( 'events.actions' );

			$libActionM->whereE( 'namekey', $namekey );

			$actid=$libActionM->load( 'lr', 'actid' );

		}


		
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