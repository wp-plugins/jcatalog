<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.textarea' );
class Events_Actioncode_form extends WForm_textarea {








	

	function create(){



		$wid=$this->getValue( 'wid' );

		$folder=$this->getValue( 'folder' );

		

		$extensionFolder=WExtension::get( $wid, 'folder' );

		$location=JOOBI_DS_USER . 'custom' . DS . $extensionFolder . DS . 'action' . DS . $folder . DS . $folder . '.php';

		$fileC=WGet::file();
		if( $fileC->exist($location)) $this->value=$fileC->read( $location );



		return parent::create();



	}}