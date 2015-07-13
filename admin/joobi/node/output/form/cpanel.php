<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











WView::includeElement( 'form.layout' );




class WForm_Corecpanel extends WForm_layout {




	function create(){
		parent::create();
		$this->content='<div id="cpanel">'.$this->content .'</div>';
		return true;
	}




	function show(){
		return $this->create();
	}
}

