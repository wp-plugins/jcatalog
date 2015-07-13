<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.select' );
class WForm_Coreselectbutton extends WForm_select {





	function create() {
		$status = parent::create();

		$outputLinkC = WClass::get( 'output.link' );
		$link = $outputLinkC->convertLink( $this->element->lien );

		$link = WPage::linkPopUp( $link );
		$text = '<div style="padding-top:6px;">' . WText::t('1357059105KDVU') . '</div>';
		$popwidth = ( !empty($this->element->popwidth) ? $this->element->popwidth : '90%' );			$popheigth = ( !empty($this->element->popheigth) ? $this->element->popheigth : '90%' );			$text = WPage::createPopUpLink( $link, $text, $popwidth, $popheigth );

		$this->content = '<div style="float:left;">' . $this->content. '</div>';

		$objButtonO = WPage::newBluePrint( 'button' );
		$objButtonO->text = $text;
		$objButtonO->type = 'standard';
		if ( !empty($this->element->classes) ) $objButtonO->wrapperDiv = $this->element->classes;
		$this->content = WPage::renderBluePrint( 'button', $objButtonO );

		return $status;
	}

}

