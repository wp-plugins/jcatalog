<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Viewlisting_model extends WModel {









	public function secureTranslation($sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;

				$roleHelper = WRole::get();
		if ( WRole::hasRole( 'admin' ) ) return true;

		return false;

	}



	function validate() {



		
		$mainEditC = WClass::get( 'main.edit' );

		if ( !$mainEditC->checkEditAccess() ) return false;



		$this->core = 0;





		
		
		$librayViewListingM = WModel::get( 'library.viewlistings' );

		$librayViewListingM->whereE( 'lid', $this->lid );

		$currentParmas = $librayViewListingM->load( 'lr', 'params' );



		$existingParams = new stdClass;

		$existingParams->params = $currentParmas;

		WTools::getParams( $existingParams );



		if ( !empty($existingParams) ) {

			
			foreach( $existingParams as $oneKye => $oneP ) {

				if ( !isset( $this->p[$oneKye] ) ) $this->p[$oneKye] = $oneP;

			}
		}




		


















		return true;



	}




	function extra() {



		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );



		return true;



	}}