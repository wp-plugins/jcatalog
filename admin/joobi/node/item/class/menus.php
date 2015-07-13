<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Menus_class extends WClasses {







	public function removeNotUsedMenus($app) {

				$itemDesignationT = WType::get( 'item.designation' );
		$allTypesA = $itemDesignationT->getList( false );

				$typeOfMenuToRemoveA = array( '_new_item_menu_', '_listing_item_' );
		
		$roleC = WRole::get();

		$itemtypeM = WModel::get( 'item.type' );
		$itemtypeM->orderBy( 'publish', 'DESC' );
		$itemtypeM->orderBy( 'type', 'ASC' );
		$itemtypeM->orderBy( 'rolid', 'DESC' );
		$allTypesAOriginA = $itemtypeM->load( 'ol', array( 'type', 'publish', 'rolid_edit' ) );
		$newTypeRolesA = array();
		foreach( $allTypesAOriginA as $oneOrig ) {

						if ( empty($oneOrig->publish) ) continue;

			if ( empty($newTypeRolesA[$oneOrig->type]) ) {
								$newTypeRolesA[$oneOrig->type] = $oneOrig->rolid_edit;
			} else {
				if ( $roleC->compareRole( $oneOrig->rolid_edit, $newTypeRolesA[$oneOrig->type] ) ) {
					$newTypeRolesA[$oneOrig->type] = $oneOrig->rolid_edit;
				}			}		}
		$allMenus2RemoveA = array();
		$countType = 0;
		$roleHelper = WRole::get();
		foreach( $allTypesA as $typeID => $oneType ) {
			$exist = WExtension::exist( $oneType . '.node' );
			if ( !$exist ) {
								foreach( $typeOfMenuToRemoveA as $oneMenu ) {
					$allMenus2RemoveA[] = $app . $oneMenu . $oneType;
				}			} else {

								if ( isset($newTypeRolesA[$typeID]) ) {
					$roleid = $newTypeRolesA[$typeID];
					if ( !$roleHelper->hasRole( $roleid ) ) {
						foreach( $typeOfMenuToRemoveA as $oneMenu ) {
							$allMenus2RemoveA[] = $app . $oneMenu . $oneType;
						}					} else {
						$countType++;
					}				} else {
															foreach( $typeOfMenuToRemoveA as $oneMenu ) {
						$allMenus2RemoveA[] = $app . $oneMenu . $oneType;
					}				}

			}
		}
				
						if ( in_array( 'vendors_new_item_menu_auction', $allMenus2RemoveA ) ) $allMenus2RemoveA[] = 'vendors_horizontalmenu_fe_auction_bids';


		return $allMenus2RemoveA;

	}

}