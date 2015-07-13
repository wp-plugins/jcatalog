<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_duplicate_controller extends WController {

function duplicate(){




	$trucs=WGlobals::get('trucs');

	$folder=$trucs['x']['foldername'];



	$tmid=WGlobals::getEID();

	$themeM=WModel::get('theme');

	
	if( empty($folder)){

		$message=WMessage::get();

		$message->userE('1298350435GKOB');

		$this->setView( 'theme_clone' );

		return true;

	}


	$systemFolderC=WGet::folder();		
	$themeC=WClass::get('theme.helper');

	$type=$themeC->getCol($tmid,'type');

	$destfolder=$themeC->destfolder($type);



	if($systemFolderC->exist( JOOBI_DS_THEME.$destfolder.DS.$folder)){

		$message=WMessage::get();

		$message->userE('1298350435GKOC',array('$folder'=>$folder));

		$this->setView( 'theme_clone' );

		return true;

	}


	
	parent::copyall();



	
	$cache=WCache::get();

	$cache->resetCache( 'Theme' );







	$inListing=WGlobals::get( 'listing', 0, 'session' );

	WGlobals::set('listing', '', 'session');

	$neweid=$this->_model->tmid;

	if( empty($inListing)) WPages::redirect( 'controller=theme&task=show&eid='.$neweid.'&type='.$type );





	return true;

}}