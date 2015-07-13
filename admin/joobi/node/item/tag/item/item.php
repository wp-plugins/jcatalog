<?php 

* @link joobi.co
* @license GNU GPLv3 */





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