<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_category_delete_controller extends WController {




function delete() {

	$modelID = WModel::getID( 'item.category' );

	$map = 'catid_'. $modelID;

	$catids = WGlobals::get( $map );


	if ( WRoles::isNotAdmin( 'storemanager' ) ) {

		$catids = is_array( $catids ) ? $catids[0] : $catids;



		if ( empty( $catids ) ) {

			$message = WMessage::get();

			$message->exitNow( 'Unauthorized access 123' );

		}


		
		$productHelperC = WClass::get( 'item.restriction', null, 'class', false);

 		if ( $productHelperC ) $result = $productHelperC->filterRestriction( 'query', 'item.category', 'catid', $catids );

		else $result = false;



		if ( !$result ) {

			$message = WMessage::get();

			$message->exitNow( 'Unauthorized access 124' );

		}
	}



	$deleteCat = false;

	if ( !empty($catids) )

	{

		if ( is_array($catids) ) $catid = $catids[0];

		else $catid = $catids;



		
		$categoryM = WModel::get( 'item.category' );

		$categoryM->makeLJ( 'item.categorytrans', 'catid', 'catid', 0, 1 );

		$categoryM->select( 'namekey', 0 );

		$categoryM->select( 'name', 1 );

		$categoryM->whereE( 'catid', $catid );

		$result = $categoryM->load( 'o' );



		if ( !empty($result) &&  ( ( $result->namekey != 'all_products' ) && ( $result->namekey != 'other_vendors' ) ) ) $deleteCat = true; 
		else {

			
			$message = WMessage::get();

			$CATNAME = !empty($result->name) ? $result->name : '';

			$message->userN('1251709409AKQK',array('$CATNAME'=>$CATNAME));

		}


	}

	else

	{

		
		$message = WMessage::get();

		$message->adminE( 'Category EID cant be found. Contact Admin, trace -> controller item-category_delete' );

	}


	
	if ( !empty( $catids ) && is_array($catids) ) {

		$prodcatprodM = WModel::get( 'item.categoryitem' );



		foreach( $catids as $catid ) {

			
			
			$prodcatprodM->whereE( 'catid', $catid );

			$pids = $prodcatprodM->load( 'lra', 'pid' );



			
			$this->_updCatCount( $pids, $catid );

		}
	}


	if ( $deleteCat ) parent::deleteall();



	return true;


}









function _updCatCount($pids,$catid) {

	if ( empty($pids) ) return true;



	static $prodcatprodM=null;



	$productHelperC = WClass::get( 'item.helper' );



	
	foreach( $pids as $pid ) {



		
		$obj = new stdClass;

		$obj->tablename = 'item.categoryitem';

		$obj->column = 'catid';

		$obj->groupBy = 'pid';

		$obj->filterCol1 = 'pid';

		$obj->filterVal1 = $pid;

		$obj->filterNotCol1 = 'catid';

		$obj->filterNotVal1 = $catid;

		$numOfCat = $productHelperC->noOfItem( $obj );



		
		if ( empty($numOfCat) ) $numOfCat = 0;

		if ( is_numeric($numOfCat) )

		{

			if ( !isset($productM) ) $productM = WModel::get( 'product' );

			$productM->setVal( 'numcat', $numOfCat );

			$productM->whereE( 'pid', $pid );

			$productM->update();

		}


		
		if ( empty($prodcatprodM) ) $prodcatprodM = WModel::get( 'item.categoryitem' );
		$prodcatprodM->setAudit();

		$prodcatprodM->whereE( 'catid', $catid );

		$prodcatprodM->whereE( 'pid', $pid );

		$prodcatprodM->delete();

	}


	return true;


}
}