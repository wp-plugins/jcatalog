<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_related_add_controller extends WController {






function add() {



	
	$prevpid = WGlobals::getEID();

	$pid = WGlobals::get('relpid');

	$prodtypid = WGlobals::get( 'prodtypid' );

	$titleheader = WGlobals::get( 'titleheader' );

	$rel = WGlobals::get( 'rel' );



	$productRelatedM = WModel::get('item.related');


	if ( !empty($rel) ) {

		$productRelatedM->whereE( 'pid', $prevpid );

		$productRelatedM->whereE( 'relpid', $pid );

		$productRelatedM->delete();

	} else {

		$productRelatedM->setVal( 'pid', $prevpid );

		$productRelatedM->setVal( 'relpid', $pid );

		$productRelatedM->insert();

	}


	
	$prodHelperC = WClass::get( 'item.helper',null,'class',false);



	$obj = new stdClass;

	$obj->tablename = 'item.related';

	$obj->column = 'relpid';

	$obj->groupBy = 'pid';

	$obj->filterCol1 = 'pid';

	$obj->filterVal1 = $prevpid;

	$numOfRel = $prodHelperC->noOfItem( $obj );



	
	if ( empty($numOfRel) ) $numOfRel = 0;


	if ( is_numeric($numOfRel) ) {

		$productM = WModel::get( 'item' );

		$productM->setVal( 'relnum', $numOfRel );

		$productM->whereE('pid', $prevpid);

		$productM->update();

	}


	WPages::redirect( 'controller=item-related&eid='.$prevpid .'&prodtypid='. $prodtypid .'&titleheader='.$titleheader );


	return true;


}




























}