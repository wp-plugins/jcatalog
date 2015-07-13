<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Design_picklistvalues_form_view extends Output_Forms_class {

	function prepareView() {


		$did = $this->getValue( 'did' );

		if ( empty($did ) ) return true;



		$parent = WView::picklist( $did, '', null, 'parent' );



		if ( empty($parent ) ) $this->removeElements( array( 'design_picklistvalues_form_values_parent' ) );

		else {

			WGlobals::set( 'picklistParent', $parent, 'global' );


		}


		$isparent = WView::picklist( $did, '', null, 'isparent' );

		$allowsOthers = $isparent = WView::picklist( $did, '', null, 'allowothers' );


		if ( empty( $isparent ) && empty($allowsOthers) ) $this->removeElements( array( 'design_picklistvalues_form_inputbox' ) );

		else {

			WGlobals::set( 'picklistIsParent', $isparent, 'global' );
		}

		$colorstyle = WView::picklist( $did, '', null, 'colorstyle' );

		if ( ! $colorstyle ) {
			$this->removeElements( array( 'design_picklistvalues_form_color', 'design_picklist_listing_listedit_values_color' ) );
		} else {
			switch( $colorstyle ) {
				case '6';
										$did = WView::picklist( 'item_badge_color', '', null, 'did' );
					$this->_addPicklist2Element( $did );
					break;
				case '3';					case '9';					default;
					$this->removeElements( array( 'design_picklistvalues_form_color', 'design_picklist_listing_listedit_values_color' ) );
					break;
			}		}


		return true;



	}





	private function _addPicklist2Element($did) {

		foreach( $this->elements as $element ) {
			if ( $element->namekey == 'design_picklistvalues_form_color' ) {
				$element->did = $did;
			}		}

	}
}