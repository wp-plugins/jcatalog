<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_processuploadthemefile_controller extends WController {
function processuploadthemefile(){

	$tmid=WGlobals::get('eid');

	$type=WGlobals::get('type');

	$trucsFile=WGlobals::get('trucs' , '', 'files');

	$trucs=WGlobals::get('trucs');



	
	$fileLocation=$trucsFile['tmp_name']['x']['file'];

	$fileToUpload=$trucsFile['name']['x']['file'];

	$error=$trucsFile['error']['x']['file'];

	$filetype=$trucs['x']['filetype'];



	if($error > 0){

		$message=WMessage::get();

		$message->userE('1417812852DFNC');

		$this->setView( 'theme_upload_file');

		return true;

	}

	
	if($filetype==1){

		$themeFiletype='view';

	}elseif($filetype==2){

		$themeFiletype='css';

	}else{

		$themeFiletype='js';

	}


	$fileClass=WGet::file();		
	$themeC=WClass::get('theme.helper');

	$type=$themeC->getCol($tmid,'type');

	$folder=$themeC->getCol($tmid,'folder');

	$destfolder=$themeC->destfolder($type);

	$fileDest=JOOBI_DS_THEME.$destfolder.DS.$folder.DS.$themeFiletype;

	
	$fileClass->upload($fileLocation, $fileDest.DS.$fileToUpload, false);



	return true;

}}