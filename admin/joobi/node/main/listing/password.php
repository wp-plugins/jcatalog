<?php 

* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');





























WView::includeElement( 'listing.text' );

class WListing_Corepassword extends WListing_text {



	public function create() {

		$this->content = '*******';

		return true;

	}


}





