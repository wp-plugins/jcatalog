<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_category_edit_view extends Output_Forms_class {
protected function prepareView() {



		
		$auctionExtensionExist = WExtension::exist( 'auction.node' );

		if ( !$auctionExtensionExist ) {

			$this->removeElements( array('category_edit_catcrslshowbid', 'category_edit_itmshowbid' ) );

		} else {

			
			$prodtypid = $this->getValue( 'prodtypid' );

			$itemTypeC = WClass::get('item.type');

			$type = $itemTypeC->loadData( $prodtypid, 'type' );

			if ( !(empty($type) || $type == 11 ) ) {

				$this->removeElements( array('category_edit_catcrslshowbid', 'category_edit_itmshowbid' ) );

			}


		}




		if ( WPref::load( 'PITEM_NODE_CATMULTIPLETYPE' ) ) {

			$this->removeElements( 'item_category_edit_item_category_prodtypid' );

		} else {

			$this->removeElements( 'item_category_edit_item_category_prodtypid_multiple' );

		}




		
		WGlobals::set( 'maxFileUpload-item_category_image_upload', PITEM_NODE_CATMAXSIZE, 'global' );	


		$multiLanguage = WPref::load( 'PLIBRARY_NODE_MULTILANG' );

		if ( !$multiLanguage ) $this->removeMenus( array('item_category_translate' ) );



		if ( WRoles::isAdmin( 'storemanager' ) ) return true;







		if ( ! WPref::load( 'PCATALOG_NODE_CATCTYVENDOR' ) ) {

			
			$this->removeElements( array( 'catalog_category_edit_layout' ) );

		}


		if ( ! WPref::load( 'PITEM_NODE_MULTIPLEPARENT' ) ) {

			
			$this->removeElements( array( 'item_category_edit_item_category_multiple_parent' ) );

		}


		if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $this->removeElements( array( 'item_category_edit_categorycountitemsub', 'item_category_edit_ctyshownbitmsub' ) );



		return true;



	}}