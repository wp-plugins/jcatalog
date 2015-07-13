<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Item_Item_tag {	 	


 	public $smartUpdate = false;

 	public $nodeName = 'catalog';






	function process($givenTagsA) {
		static $count=1;
		$replacedTagsA = array();
		$productLoadC = WClass::get( 'item.load' );
		$outputThemeC = WClass::get( 'output.theme' );
		$outputThemeC->nodeName = $this->nodeName;
		$outputThemeC->header = $productLoadC->setHeader();
		$id = 'itm_';
		foreach( $givenTagsA as $tag => $myTagO ) {

						$productA = $productLoadC->get( $myTagO );

						if ( !empty($myTagO->countOnly) ) {
				$replacedTagsA[$tag] = $myTagO->totalCount;
				continue;
			}
			if ( empty( $productA ) ) {
				$replacedTagsA[$tag] = '';
				continue;
			}
			
									$productLoadC->extraProcess( $productA, $myTagO );

															if ( empty($myTagO->widgetSlug) ) $myTagO->widgetSlug = $id . $count++;
			$replacedTagsA[$tag] = $outputThemeC->createLayout( $productA, $myTagO );


		}
		return $replacedTagsA;

	}

}