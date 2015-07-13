<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_assign_assigncategories_controller extends WController {


function assigncategories() {



	
	$titleheader = WGlobals::get( 'titleheader' );

	$catid = WGlobals::get('catid');

	$prodtypid = WGlobals::get( 'prodtypid' );



	$pids = WGlobals::get( 'pid' );

	if ( empty( $pids ) ) {

		$prodSID = WModel::get( 'item', 'sid' );

		$pids = WGlobals::get( 'pid_'. $prodSID );

	}


	if ( !empty( $pids ) && !is_array( $pids ) ) $pids = array( $pids );



	if (!empty($pids) && !empty($catid)) {

		
		static $categoryproductM = null;

		static $categoryM = null;

		static $productM = null;


		$TOTALADDED = 0;
		$TOTALREMOVED = 0;


		foreach( $pids as $pid ) {

			
			if ( !isset($categoryproductM)) $categoryproductM = WModel::get( 'item.categoryitem' );

			$categoryproductM->whereE( 'catid', $catid );


			$categoryproductM->whereE( 'pid', $pid );

			$categoryproduct = $categoryproductM->load('lr', 'pid');



			if ( empty($categoryproduct) ) {

				
				if ( !isset($categoryproductM) ) $categoryproductM = WModel::get( 'item.categoryitem' );



				
				$categoryproductM->select( 'ordering' );

				$categoryproductM->whereE( 'catid', $catid );

				$categoryproductM->orderBy( 'ordering', 'DESC' );

				$order = $categoryproductM->load( 'lr' );



				
				$categoryproductM->setVal( 'catid', $catid );

				$categoryproductM->setVal( 'pid', $pid );

				$categoryproductM->setVal( 'ordering', ($order+1));

				$categoryproductM->insert();

				$TOTALADDED++;

			} else {

				
				if ( !isset($categoryproductM)) $categoryproductM = WModel::get( 'item.categoryitem' );

				$categoryproductM->whereE( 'catid', $catid );

				$categoryproductM->whereE( 'pid', $pid );

				$categoryproductM->delete();

				$TOTALREMOVED++;

			}


			
			

			



		}
		$total = $TOTALADDED + $TOTALREMOVED;
		if ( $total > 0 ) {
			$categoryC = WClass::get( 'item.category' );
			$categoryC->updateNumberItems( $catid, $total );
		}
		if ( $TOTALADDED ) $this->userS('1436469888PQTH',array('$TOTALADDED'=>$TOTALADDED));
		if ( $TOTALREMOVED ) $this->userS('1436469888PQTI',array('$TOTALREMOVED'=>$TOTALREMOVED));



	}




	
	WPages::redirect( 'controller=item-assign&catid='. $catid .'&prodtypid='. $prodtypid .'&titleheader='. $titleheader );

	return true;



}}