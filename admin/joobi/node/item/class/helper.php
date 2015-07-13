<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Helper_class extends WClasses {




















	public function noOfItem($object) {


		$noOfItems = false;



		
		if ( isset($object->tablename) ) $tablename = $object->tablename;

		else $tablename = '';

		if ( isset($object->column) ) $column = $object->column;

		else $column = '';

		if ( isset($object->groupBy) ) $groupBy = $object->groupBy;

		else $groupBy = '';

		if ( isset($object->filterCol1) ) $filterCol1 = $object->filterCol1;

		else $filterCol1 = '';

		if ( isset($object->filterVal1) ) $filterVal1 = $object->filterVal1;

		else $filterVal1 = '';

		if ( isset($object->filterCol2) ) $filterCol2 = $object->filterCol2;

		else $filterCol2 = '';

		if ( isset($object->filterVal2) ) $filterVal2 = $object->filterVal2;

		else $filterVal2 = '';

		if ( isset($object->filterCol3) ) $filterCol3 = $object->filterCol3;

		else $filterCol3 = '';

		if ( isset($object->filterVal3) ) $filterVal2 = $object->filterVal3;

		else $filterVal3 = '';

		if ( isset($object->filterNotCol1) ) $filterNotCol1 = $object->filterNotCol1;

		else $filterNotCol1 = '';

		if ( isset($object->filterNotVal1) ) $filterNotVal1 = $object->filterNotVal1;

		else $filterNotVal1 = '';



		if ( empty($tablename) || empty($column) ) {

			$message = WMessage::get();

			$message->adminE( 'Problem with the parameters passed. Check class product.helper : function noOfItem' );

			return $noOfItems;

		}


		if ( !empty($tablename) && !empty($column) ) {

			$modelM = WModel::get( $tablename );

			$modelM->select( $column, 0, null, 'count' );

			if ( !empty($filterCol1) ) $modelM->whereE( $filterCol1, $filterVal1 );

			if ( !empty($filterCol2) ) $modelM->whereE( $filterCol2, $filterVal2 );

			if ( !empty($filterCol3) ) $modelM->whereE( $filterCol3, $filterVal3 );

			if ( !empty($filterNotCol1) ) $modelM->where( $filterNotCol1, '!=', $filterNotVal1 );

			if ( $tablename == 'item.category' ) $modelM->where( 'namekey', '!=', 'root');

			if ( $tablename == 'item.categoryitem' ) $modelM->where( 'catid', '!=', 1 );

			if ( !empty($groupBy) ) $modelM->groupBy( $groupBy );

			$noOfItems = $modelM->load( 'lr' );

		} else {

			$message = WMessage::get();

			$message->adminN( 'Check Parameters' );

		}


		return $noOfItems;


	}








	public function countImages($pid) {
		if (empty($pid)) return false;
		$modelM = WModel::get( 'item.images' );
		$modelM->whereE( 'pid', $pid);
		$count = $modelM->total();
		return $count;
	}







	public function getDefaultImageID($pid) {

		if ( empty($pid) ) return false;
		$modelM = WModel::get( 'item.images' );
		$modelM->whereE( 'pid', $pid );
		$modelM->orderBy( 'premium', 'DESC' );
		$modelM->orderBy( 'ordering' );
		$filid = $modelM->load( 'lr', 'filid' );

		return $filid;

	}







public function updNoOfItems($pid=0,$catid=0) {

		if ( !empty($pid) ) {
				$obj = new stdClass;
		$obj->tablename = 'item.categoryitem';
		$obj->column = 'catid';
		$obj->groupBy = 'pid';
		$obj->filterCol1 = 'pid';
		$obj->filterVal1 = $pid;
		$numOfCat = $this->noOfItem( $obj );

				if ( empty($numOfCat) ) $numOfCat = 0;
		if ( is_numeric($numOfCat) )
		{
			if ( !isset($productM) ) $productM = WModel::get( 'item' );
			$productM->setVal( 'numcat', $numOfCat );
			$productM->whereE('pid', $pid);
			$productM->update();
		}	}
		if ( !empty($catid) ) {
















			$categoryC = WClass::get( 'item.category' );
			$categoryC->updateNumberItems( $catid, 1 );


	}
	return true;

}

}