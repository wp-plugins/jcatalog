<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_listing_item_view extends Output_Listings_class {

private $_ItemTypeListing = null;











	protected function prepareView() {



		if ( WRoles::isNotAdmin( 'storemanager' ) ) {



						$editArea = WPref::load( 'PCATALOG_NODE_EDITITEMLOCATION' );
			if ( 'both' == $editArea ) {
				$editAreaURL = WGlobals::get( 'space' );
				if ( !empty($editAreaURL) ) $editArea = $editAreaURL;
				else $editArea = 'site';				}



			if ( $editArea == 'site' || $editArea == 'popup' ) {	
				
				WGlobals::setSession( 'page', 'space', $editArea );



				$simplifiedView = PCATALOG_NODE_ITEMLISTTYPE;

				
				if ( !empty( $simplifiedView ) ) {

					if ( $this->namekey != 'item_my_show_list' ) WPages::redirect( 'controller=item' );

					WPages::redirect( 'controller=item' );

				}


			} elseif ( $editArea == 'vendors' ) {

				if ( ! IS_ADMIN && 'wordpress' ==  JOOBI_FRAMEWORK_TYPE ) {
										WPage::redirect( JOOBI_SITE . 'wp-admin/admin.php?page=jvendor&controller=vendors-area' );
				}

				WGlobals::setSession( 'page', 'space', $editArea );


			} else {

				
				$simplifiedView = PCATALOG_NODE_ITEMLISTTYPE;

				if ( !empty( $simplifiedView ) ) {

					WPages::redirect( 'controller=item' );

				}
			}


			
			$importExport = WPref::load( 'PVENDORS_NODE_ALLOWIMPORTEXPORT' );

			if ( empty($importExport) ) {

				$this->_getItemTypeListing();



				$this->removeMenus( array( $this->_ItemTypeListing . '_listing_item_import', $this->_ItemTypeListing . '_listing_item_export', $this->_ItemTypeListing . '_listing_item_divider_export' ) );

			}




			
			$featuredvendors = WPref::load( 'PVENDORS_NODE_FEATUREDVENDORS' );

			if ( empty($featuredvendors) ) {

				$this->_getItemTypeListing();

				$this->removeElements( array( $this->_ItemTypeListing . '_listing_item_'.$this->_ItemTypeListing.'_featured' ) );

			}


		}




		$vendorsExist = WExtension::exist( 'vendors.node' );

		if ( empty($vendorsExist) ) {
			$this->_getItemTypeListing();

			$this->removeMenus( array( $this->_ItemTypeListing . '_listing_item_assign', $this->_ItemTypeListing . '_listing_item_assign_divider' ) );

		}

		return true;



	}







	private function _getItemTypeListing() {



		$className = get_class( $this );

		$classNameA = explode( '_', $className );

		$this->_ItemTypeListing = strtolower( $classNameA[0] );

	}

}