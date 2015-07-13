<?php 

* @link joobi.co
* @license GNU GPLv3 */





 class Item_Itemcat_tag {
 	


 	public $smartUpdate = false;

 	var $nodeName = 'catalog';

 	




	function process($givenTagsA) {

		$replacedTagsA = array();
		$productLoadC = WClass::get( 'item.loadcategory' );
		$outputThemeC = WClass::get( 'output.theme' );
		$outputThemeC->nodeName = $this->nodeName;
		$outputThemeC->header = $productLoadC->setHeader();

		foreach( $givenTagsA as $tag => $myTagO ) {
						if ( !empty($myTagO->auto) && empty($myTagO->parent) ) {
				$catid = WGlobals::get( 'catid' );
				if ( empty($catid) ) {
					$controller = WGlobals::get( 'controller');
					$task = WGlobals::get( 'task');
					if ( $controller=='catalog' && $task=='category' ) {
						$catid = WGlobals::get( 'eid' );
					}				}				if ( !empty( $catid ) ) $myTagO->parent = $catid;
			}

						$productA = $productLoadC->get( $myTagO );

			if ( empty( $productA ) ) {
				$replacedTagsA[$tag] = '';
				continue;
			}
									$productLoadC->extraProcess( $productA, $myTagO );

												

			$outputThemeC->layoutPrefix = 'cat';

			$replacedTagsA[$tag] = $outputThemeC->createLayout( $productA, $myTagO );

		}
		return $replacedTagsA;

	}
}