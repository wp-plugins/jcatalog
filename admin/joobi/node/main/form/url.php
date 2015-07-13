<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












WView::includeElement( 'form.text' );




class WForm_Coreurl extends WForm_text {

	protected $inputType = 'url';		protected $inputClass = 'inputbox';








	function create() {

				if ( empty( $this->element->width ) ) $this->element->width = 60;

		if ( empty($this->value) && !empty( $this->element->urldefault ) ) $this->value = $this->element->urldefault;

		return parent::create();

	}








	function show() {

		if ( empty($this->value) ) return true;

		if ( empty($this->element->urlclickable) ) {
			return parent::show();
		}
				$HTML = '<a href="' . $this->value . '"';
		if ( !empty($this->element->urltarget) ) {
			$HTML .= ' target="' . $this->element->urltarget . '"';
		}		$HTML .= '>';
		$HTML .= $this->value;
		$HTML .= '</a>';

		return true;

	}
}