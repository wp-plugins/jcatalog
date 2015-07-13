<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
 defined('JOOBI_SECURE') or die('J....');











class Ticket_Publish_type extends WTypes {


	public $publish = array(



		 '-20'=>'Deleted',

		 '-10'=>'Archived',

		 '-5'=>'Unpublish',

		 '0'=>'All status',

		 '20'=>'Pending',

		 '50'=>'Assigned',

		 '81'=>'Wait reply',	
		 '100'=>'In progress',	
		 '105'=>'Unpaid',

		 '110'=>'Publish',	
		 '125'=>'Solved'


	  );







	protected function translatedType() {

		$typeA = array(
		-20 => WText::t('1220215333SORN')
		,-10 => WText::t('1209746189NUCP')
		,-5 => WText::t('1242282416HAQR')
		,0 => WText::t('1391816989CHEJ')
		,20 => WText::t('1391816989CHEK')
		,50 => WText::t('1391816989CHEL')
		,81 => WText::t('1391816989CHEM')
		,100 => WText::t('1373466832FDPH')
		,105 => WText::t('1251298684SHUF')
		,110 => WText::t('1207306697RNMA')
		,125 => WText::t('1251298684SHUG')

		);

		return $typeA;

	}
}