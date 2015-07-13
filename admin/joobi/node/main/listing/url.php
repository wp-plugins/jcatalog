<?php 

* @link joobi.co
* @license GNU GPLv3 */

















class WListing_Coreurl extends WForms_default {









	function create() {

		if ( empty($this->value) ) return true;

		if ( empty($this->element->urllstclickable) ) {
			return parent::create();
		}
				$HTML = '<a href="' . $this->value . '"';
		if ( !empty($this->element->urllsttarget) ) {
			$HTML .= ' target="' . $this->element->urllsttarget . '"';
		}		$HTML .= '>';
		$HTML .= ( !empty($this->element->urllsttext) ? $this->element->urllsttext : $this->value );
		$HTML .= '</a>';

		$this->content = $HTML;

		return true;

	}
}