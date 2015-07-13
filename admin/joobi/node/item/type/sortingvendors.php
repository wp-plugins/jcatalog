<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Item_Sortingvendors_type extends WTypes {

	public $sortingvendors = array(

		'rated' => 'Highest Rated',
		'alphabetical' => 'Alphabetical',
		'reversealphabetic' => 'Reverse Alphabetic',
		'hits' => 'Most Popular',
		'reviews' => 'Most Reviewed',
		'newest' => 'Latest',
		'oldest' => 'Oldest',
		'random' => 'Random',
		'ordering' => 'IDs Ordering'
	);





	protected function translatedType() {

		$typeA = array();
		$typeA['recentlyupdated'] = WText::t('1307606756SRYQ');
		$typeA['newest'] = WText::t('1304918557EIYL');
		$typeA['oldest'] = WText::t('1307606755CNOQ');
		$typeA['rated'] = WText::t('1257243215EFTI');
		$typeA['hits'] = WText::t('1242282415NZTN');
		$typeA['reviews'] = WText::t('1257243215EFTU');
		$typeA['alphabetic'] = WText::t('1219769904NDIK');
		$typeA['reversealphabetic'] = WText::t('1307606756SRYP');
		$typeA['random'] = WText::t('1241592274CBNQ');
		$typeA['ordering'] = WText::t('1397153427HBIQ');

		return $typeA;

	}
}