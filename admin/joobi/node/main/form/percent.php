<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












WView::includeElement( 'form.numeric' );




class WForm_Corepercent extends WForm_numeric {

	protected $inputType = 'number';		protected $inputClass = 'inputbox';

	protected $addPostText = '%'; 	
	protected $extras = ' min="0" max="100"';	
	function create() {

				if ( empty( $this->element->width ) ) $this->element->width = 4;
		return parent::create();
	}

	function show() {

		$this->content = '<span style="float:left;">' . $this->value . '</span>' . $this->addPostText;

		return true;
	}

}