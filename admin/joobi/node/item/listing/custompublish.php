<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.publish' );
class Item_CoreCustompublish_listing extends WListing_publish {

	function create() {
		if ( WRoles::isAdmin( 'storemanager' ) ) {

			return parent::create();

		} else {



			$punlishNow = WPref::load( 'PVENDORS_NODE_PRODNOBLOCK' );

			if ( $punlishNow ) return parent::create();



			$block = $this->getValue( 'blocked' );



			if ( $block ) $this->content = '<span style="color:red;font-weight:bold;">'  . WText::t('1340850148JAHH') . '<span>';

			else {

				return parent::create();

			}
		}


		return true;


	}
}