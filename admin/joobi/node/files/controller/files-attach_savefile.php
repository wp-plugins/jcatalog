<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'files.controller.files_savefile' );
class Files_attach_savefile_controller extends Files_savefile_controller {
function savefile() {



	$this->controller = 'files-attach';
	$this->index = 'popup';
	return parent::savefile();



}}