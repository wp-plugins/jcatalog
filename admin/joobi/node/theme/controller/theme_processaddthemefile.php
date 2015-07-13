<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_processaddthemefile_controller extends WController {
function processaddthemefile(){



	$tmid=WGlobals::get('eid');

	$type=WGlobals::get('type');

	$trucs=WGlobals::get('trucs');



	$filename=$trucs['x']['filename'];

	$filetype=$trucs['x']['filetype'];



	
	if($filetype==1){

		$themeFiletype='view';

		$fileEextension='php';

		$content="<?php defined('JOOBI_SECURE') or die('J....'); ?>";

	}elseif($filetype==2){

		$themeFiletype='css';

		$fileEextension='css';

		$content='.img_div{ background_color:000;}';

	}else{

		$themeFiletype='js';

		$fileEextension='js';

		$content='';

	}


	$fileClass=WGet::file();		
	$themeC=WClass::get('theme.helper');

	$type=$themeC->getCol($tmid,'type');

	$folder=$themeC->getCol($tmid,'folder');

	$destfolder=$themeC->destfolder($type);



	
	if($filename=='index'){

		$message=WMessage::get();

		$message->userE('1307012876GLGV');

		$this->setView( 'theme_add_file');

		return true;

	}



	
	if($fileClass->exist(JOOBI_DS_THEME.$destfolder.DS.$folder.DS.$themeFiletype.DS.$filename.'.'.$fileEextension)){

		$message=WMessage::get();

		$message->userE('1307005978SBLO');

		$this->setView( 'theme_add_file');

		return true;

	}


	
	$fileClass->write(JOOBI_DS_THEME.$destfolder.DS.$folder.DS.$themeFiletype.DS.$filename.'.'.$fileEextension, $content, 'overwrite');



	return true;

}}