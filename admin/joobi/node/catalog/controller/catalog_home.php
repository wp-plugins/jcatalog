<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Catalog_home_controller extends WController {

	function home() {



		$eid = WGlobals::getEID();

		if ( !empty( $eid ) ) WPages::redirect( 'controller=catalog&task=show&eid='. $eid, true );



		WGlobals::setSession( 'pageLocation', 'lastPageItem', APIPage::cmsGetItemId() );

		WGlobals::setSession( 'pageLocation', 'lastPage', 'controller=catalog' );





		if ( WRoles::isAdmin() ) WPages::redirect( 'controller=catalog&task=listing' );



		$uid = WUser::get( 'uid' );

		if ( empty($uid) ) return true;



		return true;



	}
}