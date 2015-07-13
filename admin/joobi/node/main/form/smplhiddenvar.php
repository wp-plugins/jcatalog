<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WForm_Coresmplhiddenvar extends WForms_default {





	function create() {


		$temp=$this->element->name;
				$pattern='/[a-zA-Z0-9]+(?=\])/';
		preg_match($pattern,$this->element->map, $matches);
		if ($matches)	$map = $matches[0];
		if (empty($map))	$map=$this->element->map;

		if ($temp[0]=='$' && $temp[1]=='$'){
			$variable = substr($temp, 2);
			$this->value=WGlobals::get($variable);
		}else $this->value= $this->element->name;

		$formObject = WView::form( $this->formName );
		$formObject->hidden( strtolower($this->element->map), $this->value );
		return true;
	}
	function show() {
		return $this->create();
	}

}