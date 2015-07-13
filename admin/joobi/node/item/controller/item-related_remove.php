<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_related_remove_controller extends WController {



function remove() {

	$pid=WGlobals::get('pid');

	$relpid=WGlobals::get('relpid');



	static $productRelatedM=null;

	if ( !isset($productRelatedM) ) $productRelatedM = WModel::get('item.related');

	$productRelatedM->whereE('pid', $pid);

	$productRelatedM->whereE('relpid', $relpid);

	$productRelatedM->delete();



	
	$prodHelperC = WClass::get('item.helper',null,'class',false);



	$obj = new stdClass;

	$obj->tablename = 'item.related';

	$obj->column = 'relpid';

	$obj->groupBy = 'pid';

	$obj->filterCol1 = 'pid';

	$obj->filterVal1 = $pid;

	$numOfRel = $prodHelperC->noOfItem( $obj );



	
	if ( empty($numOfRel) ) $numOfRel = 0;

	if ( is_numeric($numOfRel) )

	{

		if ( !isset($productM) ) $productM = WModel::get( 'product' );

		$productM->setVal( 'relnum', $numOfRel );

		$productM->whereE('pid', $pid);

		$productM->update();

	}


	WPages::redirect('controller=item-related&eid='.$pid);

	return true;



}}