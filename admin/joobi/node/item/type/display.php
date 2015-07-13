<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Item_display_type extends WTypes {

	public $display = array(
		'standard' => 'Default',
		'carrousel' => 'Carrousel',
		'accordion-horizontal' => 'Horizontal Accordion',
		'accordion-vertical' => 'Vertical Accordion'
	 );





	protected function translatedType() {

		$typeA = array();
		$typeA['standard'] = WText::t('1206732425HINT');
		$typeA['carrousel'] = WText::t('1304526971HCDU');
		$typeA['accordion-horizontal'] = WText::t('1397153427HBIM');
		$typeA['accordion-vertical'] = WText::t('1397153427HBIN');

		return $typeA;

	}
}