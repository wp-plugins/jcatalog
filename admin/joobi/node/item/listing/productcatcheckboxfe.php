<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.checkbox' );
class Item_CoreProductcatcheckboxfe_listing extends WListing_checkbox {


function create() {



	if ( WRoles::isAdmin( 'storemanager' ) ) {


		$this->element->type = 'output.checkbox';

		return parent::create();



	} else {

		


		$username = WUser::get( 'username' );

		$uid = WUser::get( 'uid' );



		$namekey = $this->getValue( 'namekey' );

		$userKey = $username .'_'. $uid;



		if ( $userKey == $namekey ) return false;

		else return parent::create();



	}


}}