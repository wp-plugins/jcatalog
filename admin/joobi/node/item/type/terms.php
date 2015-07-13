<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Terms_type extends WTypes {

	public $terms = array(

		1 => 'License',

		2 => 'Return Policy',

		3 => 'Privacy Policy',

		4 => 'Terms and Conditions',

	);






	protected function translatedType() {

		$typeA = array();
		$typeA[1] = WText::t('1206732400OWZK');
		$typeA[2] = WText::t('1341596519RVAQ');
		$typeA[3] = WText::t('1311845275JGPO');
		$typeA[4] = WText::t('1206732411EGRF');

		return $typeA;

	}
}