<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Promotionposition_picklist extends WPicklist {


	function create() {


		
		if ( $this->onlyOneValue() ) {



			switch ( $this->defaultValue ) {

				case 'catalog_carrousel':

					$this->addElement( 'catalog_carrousel',  'Catalog Carrousel' );

					break;

				case 'catalog_item':

					$this->addElement( 'catalog_item',  'Catalog Items' );

					break;

				case 'category_carrousel':
					$this->addElement( 'category_item',  'Category Carrousel' );
					break;
				case 'category_item':

					$this->addElement( 'category_item',  'Category Items' );

					break;

				case 'search_item':

					$this->addElement( 'search_item',  'Search Results' );

					break;

				case 'search_ajax_item':
					$this->addElement( 'search_ajax_item',  'Ajax Search Results' );
					break;
				case 'vendors_carrousel':
					$this->addElement( 'vendors_carrousel', 'Vendors Carrousel' );
					break;
				case 'vendors_item':
					$this->addElement( 'vendors_item',  'Vendors Items' );
					break;
				default:
										$miscellaneousA = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.miscellaneous' );
					$existingWidgetsA = $miscellaneousA->getAllWidgetsIDforFeatured();
					if ( !empty( $existingWidgetsA ) ) {
						foreach( $existingWidgetsA as $oneWidget ) {
							if ( $this->defaultValue == $oneWidget->slug . $oneWidget->id ) {
								$this->addElement( $oneWidget->slug . $oneWidget->id,  $oneWidget->name );
								break;
							}						}					}					break;
			}


		} else {



			$this->addElement( 0,  ' - ' . WText::t('1404269826PSKU') . ' - ' );



			$this->addElement( 'catalog_carrousel',  'Catalog Carrousel' );

			$this->addElement( 'catalog_item',  'Catalog Items' );
			$this->addElement( 'category_carrousel',  'Category Carrousel' );
			$this->addElement( 'category_item',  'Category Items' );

			$this->addElement( 'search_item',  'Search Results' );
			$this->addElement( 'search_ajax_item',  'Ajax Search Results' );

			if ( WExtension::exist( 'vendors.node' ) ) {
				$this->addElement( 'vendors_carrousel',  'Vendors Carrousel' );
				$this->addElement( 'vendors_item',  'Vendors Items' );
			}

												$miscellaneousA = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.miscellaneous' );
			$existingWidgetsA = $miscellaneousA->getAllWidgetsIDforFeatured();
			if ( !empty( $existingWidgetsA ) ) {
				foreach( $existingWidgetsA as $oneWidget ) {
					$this->addElement( $oneWidget->slug . $oneWidget->id,  $oneWidget->name );
				}			}

		}


		return true;



	}
}