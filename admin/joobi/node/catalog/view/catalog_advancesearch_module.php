<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_advancesearch_module_view extends Output_Forms_class {






	function prepareView() {



				$catalogAdvsearchC = WClass::get( 'catalog.advsearch' );

		foreach( $this->elements as $oneElem ) {


			if ( 'catalog_advancesearch_module_fields_standard' == $oneElem->namekey ) $catalogAdvsearchC->setProp( '_parentFieldsStandard', $oneElem->fid );

			if ( 'catalog_advancesearch_module_fields_custom' == $oneElem->namekey ) $catalogAdvsearchC->setProp( '_parentFieldsCustom', $oneElem->fid );

			if ( 'catalog_advancesearch_module_fields_attributes' == $oneElem->namekey ) $catalogAdvsearchC->setProp( '_parentFieldsAttributes', $oneElem->fid );
			if ( 'catalog_advancesearch_module_fields_vendors' == $oneElem->namekey ) $catalogAdvsearchC->setProp( '_parentFieldsVendors', $oneElem->fid );
			if ( 'catalog_advancesearch_module_fields_vendorscustom' == $oneElem->namekey ) $catalogAdvsearchC->setProp( '_parentFieldsVendorsCustom', $oneElem->fid );

		}


		$this->elements = array_merge( $this->elements, $catalogAdvsearchC->getAllAdvSearch( false ) );

		$defautlVAluesA = $catalogAdvsearchC->getAllModulDefault();
		if ( !empty($defautlVAluesA) ) {
			if ( !isset( $this->_data ) ) $this->_data = new stdClass;
			foreach( $defautlVAluesA as $key => $value ) {
				if ( empty($this->_data->$key) ) $this->_data->$key = $value;
			}		}		return true;




	}


}