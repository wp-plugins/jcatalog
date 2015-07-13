<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

































WView::includeElement( 'form.text' );

class WForm_Corecolorpicker extends WForm_text {





	function create() {



		if ( empty($this->element->classes) ) $this->element->classes = '';

		$this->element->classes .= ' pickerColor colorpicker-component colorpicker-element';

		$this->element->width = '20px';

		WPage::addJSLibrary( 'jquery' );

		WPage::addJSFile( 'js/bootstrap-colorpicker.js' );

		WPage::addCSSFile( 'css/bootstrap-colorpicker.css' );



		$js = "jQuery(function(){

jQuery('.pickerColor').colorpicker();

});";

		WPage::addJSScript( $js );

		$buttonColor = ( !empty($this->value) ? $this->value : '#1745FC' );

		$this->addPostText = '<i style="background-color: ' . $buttonColor . ';"><span>&nbsp;&nbsp;</span></i>';






		return parent::create();



	}




}




