<?php 

* @link joobi.co
* @license GNU GPLv3 */



WLoadFile( 'files.controller.files_saveserver' );
class Files_attach_saveserver_controller extends Files_saveserver_controller {
function saveserver() {		
	$this->controller = 'files-attach';
	$this->index = 'popup';
	return parent::saveserver();

}}