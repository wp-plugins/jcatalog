<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class WListing_Coremedia extends WListings_default{





	function create(){
		if( empty($this->value)) return '';

				$filesMediaC=WClass::get( 'files.media' );
		$this->content=$filesMediaC->renderHTML( $this->value, $this->element );

		return true;

	}





	public function advanceSearch(){
		return false;
	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null){
	}

}

