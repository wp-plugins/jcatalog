<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Item_category_assign_assignproducts_controller extends WController {





	function assignproducts() {


	$pid = WGlobals::get('pid');

	$titleheader = WGlobals::get( 'titleheader' );

	$prodtypid = WGlobals::get( 'prodtypid' );



	$catids = WGlobals::get( 'catid' );

	if ( empty( $catids ) ) {

		$categorySID = WModel::get( 'item.category', 'sid' );

		$catids = WGlobals::get( 'catid_'. $categorySID );

	}


	if ( !empty( $catids ) && !is_array( $catids ) ) {

		$catids = array( $catids );

	}
	static $categoryproductM = null;

		$MAXNUM = WPref::load( 'PITEM_NODE_MAXPRODUCTASSIGN' );
	if ( !empty($pid) && !empty($catids) && $MAXNUM > 0 ) {

		$uid = WUser::get('uid');
		static $userRoleA = array();
 		if ( !isset( $userRoleA[ $uid ] ) ) {
 			$roleC = WRole::get();
			$userRoleA[ $uid ] = WRole::hasRole( 'storemanager' );
 		}
		if (!$userRoleA[ $uid ] ) {
						if ( !isset($categoryproductM) ) $categoryproductM = WModel::get( 'item.categoryitem' );
			$categoryproductM->select( 'catid', 0, null, 'count' );
			$categoryproductM->whereE( 'pid', $pid );
			$prodcats = $categoryproductM->load( 'lr' );

			$assignCatsNum = count( $catids );

			$exists = false;
						if ( $assignCatsNum == 1 ) {
				if ( !isset($categoryproductM) ) $categoryproductM = WModel::get( 'item.categoryitem' );
				$categoryproductM->whereE( 'catid', $catids[0] );
				$categoryproductM->whereE( 'pid', $pid );
				$exists = $categoryproductM->load( 'r', 'pid' );

			}
						if ( empty( $exists ) ) {

				if ( $prodcats >= $MAXNUM || ( $prodcats + $assignCatsNum > $MAXNUM ) ) {
					$message = WMessage::get();
					$message->userW('1309316224JSTQ',array('$MAXNUM'=>$MAXNUM));

					WPages::redirect( 'controller=item-category-assign&task=listing&pid='. $pid .'&prodtypid='. $prodtypid .'&titleheader='. $titleheader );
					return true;
				}			}
		}	}
	if ( !empty($pid) && !empty($catids) ) {

		static $categoryM = null;

		static $productM = null;


		$TOTALCATEGORY = 0;
		$TOTALREMOVED = 0;


		foreach( $catids as $catid ) {

			
			if ( !isset($categoryproductM)) $categoryproductM = WModel::get( 'item.categoryitem' );

			$categoryproductM->whereE( 'catid', $catid );

			$categoryproductM->whereE( 'pid', $pid );

			$categoryproduct = $categoryproductM->load( 'r', 'pid' );



			if ( empty($categoryproduct) ) {

				
				if ( !isset($categoryproductM) ) $categoryproductM = WModel::get( 'item.categoryitem' );



				
				$categoryproductM->whereE( 'catid', $catid );

				$categoryproductM->orderBy( 'ordering', 'DESC' );
				$order = $categoryproductM->load( 'lr', 'ordering' );



				
				$categoryproductM->setVal( 'catid', $catid );

				$categoryproductM->setVal( 'pid', $pid );

				$categoryproductM->setVal( 'ordering', ($order+1) );

				$categoryproductM->insert();

				$TOTALCATEGORY++;

			} else {

				
				if ( !isset($categoryproductM) ) $categoryproductM = WModel::get( 'item.categoryitem' );

				$categoryproductM->whereE( 'catid', $catid );

				$categoryproductM->whereE( 'pid', $pid );

				$categoryproductM->delete();

				$TOTALREMOVED++;

			}


			
			
			static $prodHelperC=null;

			if ( !isset($prodHelperC) ) $prodHelperC = WClass::get('item.helper',null,'class',false);



			
			$prodHelperC->updNoOfItems( $pid, $catid );



		}
		if ( $TOTALCATEGORY ) $this->userS('1309316224JSTR',array('$TOTALCATEGORY'=>$TOTALCATEGORY));
		if ( $TOTALREMOVED ) $this->userS('1309316224JSTS',array('$TOTALREMOVED'=>$TOTALREMOVED));


	} else {

		$message = WMessage::get();

		$message->codeE( 'Problem with the pass url values, trace -> controller item-category-assign.assignproducts' );

	}


	WPages::redirect( 'controller=item-category-assign&task=listing&pid='. $pid .'&prodtypid='. $prodtypid .'&titleheader='. $titleheader );

	return true;

}
}