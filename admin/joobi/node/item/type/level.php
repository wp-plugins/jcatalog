<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Level_type extends WTypes {

	public $level = array(
		'1' => '1 level',
		'2' => '2 level',
		'3' => '3 level',
		'4' => '4 level'
	);





	protected function translatedType() {

		$typeA = array();
		$typeA['1'] = WText::t('1397152821HXLO');
		$typeA['2'] = WText::t('1397152821HXLP');
		$typeA['3'] = WText::t('1397152821HXLQ');
		$typeA['4'] = WText::t('1397152821HXLR');

		return $typeA;

	}
}