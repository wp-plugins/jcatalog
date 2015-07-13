<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_Reviews_class extends WClasses {










	public function reviewAllowed() {

		$showComment = WPref::load( 'PVENDOR_NODE_ONLYCUSTOMERS' );

				if ( $showComment ) {

						if ( ! WUser::isRegistered() ) return false;


			$pid = WGlobals::getEID();

			$ordersM = WModel::get( 'order.products' );
			$ordersM->makeLJ( 'order', 'oid' );
			$uid = WUser::get( 'uid' );

			$ordersM->whereE( 'uid', $uid, 1 );
			$ordersM->whereE( 'pid', $pid );
			$ordersM->whereE( 'ostatusid', 20, 1 );

			$exist = $ordersM->exist();

			if ( $exist ) return true;
			else return false;

		} else {

			return true;

		}

	}


}