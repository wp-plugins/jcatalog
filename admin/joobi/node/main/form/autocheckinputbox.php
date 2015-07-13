<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'form.text' );
class WForm_Coreautocheckinputbox extends WForm_text {

	protected $inputClass = 'inputbox';
	protected $inputType = 'text';	




	function create() {

		$this->element->required=1;
		$this->element->custom = true;
		if (empty($this->element->autocheckmodel)){
			$this->element->autocheckmodel = $this->element->sid;
			$this->element->custom = false;
		}		if (empty($this->element->autocheckmap)){
			$this->element->autocheckmap = $this->element->map;
		}		if (empty($this->element->autochecktitle)){
			$this->element->autochecktitle = $this->element->name;
		}
				$TEXT = $this->element->autochecktitle;
		WText::load( 'main.node' );
		$this->element->autocheck = array();
		$this->element->autocheck[1] = 1;
		WText::load( 'main.node' );
		if (isset($this->element->autochecknotexist)){
			$this->element->autocheck[1] = str_replace(array('$TEXT'), array($TEXT),WText::t('1308292311QGYK'));
		}else {
			$this->element->autocheck[1] = str_replace(array('$TEXT'), array($TEXT),WText::t('1299084287SIMJ'));
		}

		if ( $this->element->typeName == 'autocheckinputbox' ) {
			$autochecknotexist = ( isset($this->element->autochecknotexist) ) ? 1:0;

			$extra = new stdClass;
			$extra->sid = $this->element->autocheckmodel;
			$extra->map = $this->element->autocheckmap;
			$extra->notexist = $autochecknotexist;
			$extra->custom = $this->element->custom;
			$extra->namekey = $this->idLabel;

			$paramsArray=array();
			$paramsArray['ajxUrl'] = 'controller=output&task=autocheck';
			$paramsArray['autocheck'] = true;
			$joobiRun = WPage::actionJavaScript('autocheck',$this->formName, $paramsArray, $extra );
			$this->extras = ' onBlur="return '.$joobiRun.'"';
		}
		return parent::create();

	}
}