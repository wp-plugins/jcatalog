<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'files.controller.files_saveserver' );
class Files_attach_saveserver_controller extends Files_saveserver_controller {
function saveserver() {		
	$this->controller = 'files-attach';
	$this->index = 'popup';
	return parent::saveserver();

}}