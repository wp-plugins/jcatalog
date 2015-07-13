<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Design_Design_picklist_listing_listedit_values_view extends Output_Listings_class {

function prepareView() {



		$parent = WGlobals::get( 'picklistParent', '', 'global' );

		if ( empty($parent) ) {

			$this->removeElements( array( 'design_picklist_listing_listedit_parent', 'design_picklist_listing_listedit_parent_value' ) );

		}


		$isparent = WGlobals::get( 'picklistIsParent', '', 'global' );

		if ( empty($isparent) ) {

			$this->removeElements( array( 'design_picklist_listing_listedit_values_inputbox' ) );

		}


		return true;



	}
}