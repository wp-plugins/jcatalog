<?php 

* @link joobi.co
* @license GNU GPLv3 */
















WView::includeElement( 'main.listing.simple' );
class WListing_Corepercent extends WListing_simple {






	public function createHeader() {

				if ( empty( $this->element->align ) ) $this->element->align = 'center';

		return false;
	}

	public function create() {

		$status = parent::create();

		$this->content .= '%';

		return $status;

	}

}