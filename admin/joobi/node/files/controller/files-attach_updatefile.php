<?php 

* @link joobi.co
* @license GNU GPLv3 */



WLoadFile( 'files.controller.files_updatefile' );
class Files_attach_updatefile_controller extends Files_updatefile_controller {
	function updatefile() {



		$this->controller = 'files-attach';

		$this->index = 'popup';

		return parent::updatefile();



	}}