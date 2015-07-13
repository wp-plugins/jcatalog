<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Designation_type extends WTypes {




















	public $designation = array (



		'1' => 'product',

		'5' => 'subscription',

		'7' => 'voucher',

		'11' => 'auction',

		'16' => 'classified',

		'17' => 'lottery',







		'100' => 'item',	
		'101' => 'article',


		'117' => 'documentation',

		'121' => 'media',

		'141' => 'download'



	);












	protected function translatedType() {


		$typeA = array();

		$typeA[0] = WText::t('1391817749EVJR') . ' - ';



		if ( WExtension::exist( 'product.node' ) ) $typeA[1] = WText::t('1206961841DNYS');

		if ( WExtension::exist( 'subscription.node' ) ) $typeA[5] = WText::t('1206732411EGSA');

		if ( WExtension::exist( 'voucher.node' ) ) $typeA[7] = WText::t('1358508569GXCY');

		if ( WExtension::exist( 'auction.node' ) ) $typeA[11] = WText::t('1298350962OSCE');

		if ( WExtension::exist( 'classified.node' ) ) $typeA[16] = WText::t('1375216513HVXX');

		if ( WExtension::exist( 'lottery.node' ) ) $typeA[17] = WText::t('1302519286LPPQ');







		if ( WExtension::exist( 'jcatalog.application' ) ) $typeA[100] = WText::t('1206961997BSZK');	




		if ( WExtension::exist( 'documentation.node' ) ) $typeA[117] = WText::t('1213200727TEHQ');
		if ( WExtension::exist( 'download.node' ) ) $typeA[141] = WText::t('1206961905BHAV');





		return $typeA;



	}}