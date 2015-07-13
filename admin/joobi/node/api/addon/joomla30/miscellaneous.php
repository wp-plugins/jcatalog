<?php 

* @link joobi.co
* @license GNU GPLv3 */











class Api_Joomla30_Miscellaneous_addon {





	public function getAllWidgetsIDforFeatured(){

		$allItemsA=array( 'mod_item_item_module', 'mod_product_product_module', 'mod_download_download_module', 'mod_auction_auction_module' );

		$joomlaModulesM=WModel::get( 'joomla.modules' );
		$joomlaModulesM->whereIn( 'module', $allItemsA );
		$joomlaModulesM->select( 'id', 0, 'id' );
		$joomlaModulesM->select( 'title', 0, 'name' );
		$joomlaModulesM->select( 'module', 0, 'slug' );
		$resultA=$joomlaModulesM->load( 'ol' );

		
		return $resultA;

	}
}