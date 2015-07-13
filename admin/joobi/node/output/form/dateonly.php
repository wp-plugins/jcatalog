<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.datetime' );
class WForm_Coredateonly extends WForm_datetime {

	protected $inputType='datetime';	
	protected $dateFormat='dateonly';




	function create(){
		return parent::create();
	}




	function show(){
		$this->noTimeZone=true;
		return parent::show();
	}
}

