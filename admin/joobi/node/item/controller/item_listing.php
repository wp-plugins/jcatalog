<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_listing_controller extends WController {

	function listing() {


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
					$this->setView( 'item_my_show_list' );
				}
			} elseif ( $editArea == 'vendors' || $editArea == 'phonevendors' || JOOBI_APP_DEVICE_TYPE == 'tb' || JOOBI_APP_DEVICE_TYPE == 'ph' ) {

				if ( ! IS_ADMIN && 'wordpress' ==  JOOBI_FRAMEWORK_TYPE ) {
										WPage::redirect( JOOBI_SITE . 'wp-admin/admin.php?page=jvendor&controller=item' );
				}
				WGlobals::setSession( 'page', 'space', $editArea );

			} else {
								$simplifiedView = WPref::load( 'PCATALOG_NODE_ITEMLISTTYPE' );
				if ( !empty( $simplifiedView ) ) {
					$this->setView( 'item_my_show_list' );
				}			}
		}

		return parent::listing();


	}
}