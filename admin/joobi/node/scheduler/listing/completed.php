<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_CoreCompleted_listing extends WListings_default{










	function create(){

		static $addLegend=array();







		$aValue=array( 0, 1, 2 );

		$aLabel=array( WText::t('1206732345BHSJ'), WText::t('1235462003CNHC'),WText::t('1235462003CNHD'));

		$aImg=array( 'cancel', 'yes','pending');



		$runningprcs=$this->getValue('pcsid');

		$value=( !empty($runningprcs)) ? 2 : 1;











		$this->content=WView::getLegend( $aImg[$value], $aLabel[$value], 'standard' );

		return true;



	}}