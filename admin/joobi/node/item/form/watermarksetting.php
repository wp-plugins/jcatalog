<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.yesno' );
class Item_CoreWatermarksetting_form extends WForm_yesno {
	function create() {



		parent::create();



		$this->content .= '<br /><a style="color:green;" target="_blank" href="'. WPage::routeURL( 'controller=apps&task=preferences' ) .'">'. WText::t('1338404831MNYL') .'</a>';



		return true;



	}}