<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Catagories_picklist extends WPicklist {
	function create() {


		$prodtypid = WGlobals::get( 'prodtypid', 0 );



		$productCategoryM = WModel::get( 'item.category' );



		$productCategoryM->makeLJ( 'item.categorytrans', 'catid' );

		$productCategoryM->whereLanguage(1);

		$productCategoryM->select( 'name', 1 );

		$productCategoryM->select( array( 'catid', 'parent', 'namekey' ) );





		if ( !empty($prodtypid) ) {

			$productCategoryM->openBracket();

			$productCategoryM->whereE( 'prodtypid', $prodtypid );

			$productCategoryM->operator( 'OR' );

			$productCategoryM->where( 'prodtypid', '=', '0' );

			$productCategoryM->closeBracket();

		}


		$productCategoryM->where( 'namekey', '!=', 'root' );

		$productCategoryM->whereE( 'publish', 1 );





		$productCategoryM->orderBy( 'ordering', 'ASC' );

		$productCategoryM->orderBy( 'name', 'ASC', 1 );



		$productCategoryM->checkAccess();

		$productCategoryM->setLimit( 1000 );

		$allCategoriesA = $productCategoryM->load( 'ol' );



		
		if ( count($allCategoriesA) == 1000 ) return false;



		$parent = array();

		$parent['pkey'] = 'catid';

		$parent['parent'] = 'parent';

		$parent['name'] = 'name';

		$childOrderParent = array();

		$list = WOrderingTools::getOrderedList( $parent, $allCategoriesA, 1, false, $childOrderParent );



		if ( empty($list) ) return false;



		$this->addElement( 0, '- ' . WText::t('1311592756JOUI') . ' -' );

		foreach( $list as $itemList ) {

			$this->addElement( $itemList->catid, $itemList->name );

		}


		return true;



	}}