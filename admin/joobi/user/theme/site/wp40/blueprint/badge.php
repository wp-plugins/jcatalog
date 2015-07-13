<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class WRender_Badge_classObject {

	















	public $type = 'default';

	


	public $itemsA = array();

	


	public $params = null;

	public $tagID = null;

	public $class = '';	
	public $nodeName = '';	
	public $hasImage = false; 	

}





class WRender_Badge_class extends Theme_Render_class {

	private static $countID = 0;
	private static $rowNb = 0;
	private static $columnNb = 0;

	public $nodeName = null;
	public $hasImage = null;







	public function render($data) {

		$this->tagID = $data->tagID;

		$this->nodeName = $data->nodeName;
		$this->hasImage = $data->hasImage;

		if ( empty( $data->params->display) ) {
			$data->params->display = 'vertical';
			$data->type = 'vertical';
		}
		$html = '';
		switch( $data->type ) {
			case 'carrousel':
				if ( empty($data->params->layout) || $data->params->layout=='default' ) $data->params->layout = 'badgebig';
				$html = $this->_displayCarrousel( $data->itemsA, $data->params, 'carrousel' );
								$html = '<div class="carrouselPanel">' . $html . '</div>';
				break;
			case 'slider':
				if ( empty($data->params->layout) || $data->params->layout=='default' ) $data->params->layout = 'badgemini';
				$html = $this->_displayCarrousel( $data->itemsA, $data->params, 'slider' );
				break;
			case 'accordion-vertical':					if ( empty($data->params->layout) || $data->params->layout=='default' ) $data->params->layout = 'badgebig';
				$html = $this->_displayAccordionVertical( $data->itemsA, $data->params );
				break;
			case 'accordion-horizontal':					if ( empty($data->params->layout) || $data->params->layout=='default' ) $data->params->layout = 'badgebig';
				$html = $this->_displayAccordionHorizontal( $data->itemsA, $data->params );
				break;

			case 'vertical':
			case 'horizontal':
			default:


				if ( empty($data->params->layout) || $data->params->layout=='default' ) $data->params->layout = 'badge';
				if ( empty($data->params->display) ) $data->params->display = 'vertical';

				switch( $data->params->display ) {
					case 'vertical':
					case 'horizontal':
					default:
						$data->class = 'separatorStandard';
						break;
				}
				if ( !empty( $data->params->organizeTree ) ) {
					$html = $this->_renderSubCategoryBadge( $data->itemsA, $data->params, $data->class );
				} else {
					$html = $this->_renderStandardBadge( $data->itemsA, $data->params, $data->class );
				}
				break;

		}
		return $html;

	}








	private function _renderStandardBadge($productA,$tagParams,$className='') {

		if ( !empty($tagParams->classSuffix) ) $className .= ' ' . $tagParams->classSuffix;

		$html = '<div class="container-fluid"><div class="row">';


		$totalItems = count($productA);
		$count = 1;

		foreach( $productA as $key => $product ) {

			$product->nb = $count;

			if ( empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );	
			$html .= Output_Theme_class::callTheme( $product, $tagParams );

			if ( !empty($tagParams->layoutNbColumn) ) {
				if ( $count % $tagParams->layoutNbColumn == 0 && $totalItems != $count ) {
					$html .= '<div class="clearfix"></div>';
				}			}
			$count++;
		}
		$html .= '</div></div>';
		return $html;

	}









	private function _displayCarrousel($productsA,$tagParams,$typeDisplay='carrousel') {
		static $alreadyLoaded = array();
		static $keyIndex=1;


						if ( !defined( 'T3_TEMPLATE' ) ) WPage::addJSFile( 'js/extrascript.js' );

		if ( !empty($tagParams->layoutNbColumn) || !empty($tagParams->layoutNbRow) ) {
						if ( empty($tagParams->layoutNbColumn) || $tagParams->layoutNbColumn < 1 ) $tagParams->layoutNbColumn = 1;
			if ( empty($tagParams->layoutNbRow) || $tagParams->layoutNbRow < 1 ) $tagParams->layoutNbRow = 1;
			$toalItems = $tagParams->layoutNbColumn * $tagParams->layoutNbRow;

						$slidesofItemsA = array();
			$count = 0;
			$index = 0;
			foreach( $productsA as $oneProduct ) {
				$count++;
				$slidesofItemsA[$index][] = $oneProduct;
				if ( $count >= $toalItems ) {
					$index++;
					$count = 0;
				}			}
						$HTMLSlidesA = array();
			foreach( $slidesofItemsA as $oneSlides ) {
				$HTMLSlidesA[] = $this->_renderStandardBadge( $oneSlides, $tagParams );
			}		}

		if ( !empty( $tagParams->idLabel ) ) {
			$key = $tagParams->idLabel;
			$keyIndex++;
		} else {
			$key = $this->nodeName . '-' . $keyIndex;
			$keyIndex++;
		}
		$alreadyLoaded[$key] = true;			$typeDisplayAgain = ( $typeDisplay == 'carrousel' ) ? 'Carrousel' : 'Slider' ;

		$key .= $typeDisplayAgain;


		$carrouselSpeed = PCATALOG_NODE_CARROUSELSPEED;

		$html = '';
		$active = ' active';
		$indicatorsHTML = '';
		$indice = 0;

		if ( !empty($HTMLSlidesA) ) {
			$productsA = $HTMLSlidesA;
			$showSlidesB = true;
		} else {
			$showSlidesB = false;
		}
		$count = 0;
		foreach( $productsA as $product ) {

			$html .= '<div class="item' . $active . '">';	
			if ( $showSlidesB ) {
				$html .= $product;
			} else {
				$count++;
				$product->nb = $count;

				if ( $this->hasImage && empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );
				$html .= Output_Theme_class::callTheme( $product, $tagParams );

			}			$html .= '</div>';

						$indicatorsHTML .= '<li data-target="#' . $key . '" data-slide-to="' . (string)$indice . '"';
			if ( !empty($active) ) $indicatorsHTML .= ' class="active"';
			$indicatorsHTML .= '></li>';

			$indice++;
			$active = '';

		}
				if ( empty($tagParams->showTitle) ) {

			$controlHTML = '<a class="left carousel-control" href="#' . $key . '" data-slide="prev">
<span class="fa fa-chevron-left"></span>
</a>
<a class="right carousel-control" href="#' . $key . '" data-slide="next">
<span class="fa fa-chevron-right"></span>
</a>';
		} else {
			$catalogCarrouselControlColor = $this->value( 'catalog.carrouselcontrolcolor' );
			$controlHTML = '<div class="controls pull-right hidden-xs">
<a class="fa fa-chevron-left btn btn-' . $catalogCarrouselControlColor . '" data-slide="prev" href="#' . $key . '"></a>
<a class="right fa fa-chevron-right btn btn-' . $catalogCarrouselControlColor . '" data-slide="next" href="#' . $key . '"></a>
</div>';
		}
		$indicatorsHTML = '<ol class="carousel-indicators">' . $indicatorsHTML . '</ol>';

		$finalHTML = '<div class="carousel slide" data-ride="carousel" id="' . $key . '">';
		$finalHTML .= '<div class="carousel-inner">';
		$finalHTML .= $html;
		$finalHTML .= '</div>';
		if ( empty($tagParams->showTitle) && !empty( $tagParams->carrouselArrow ) ) $finalHTML .= $controlHTML;
		$finalHTML .= '</div>';


		$data = WPage::newBluePrint( 'panel' );
		$data->id = $key . 'Panel';
		if ( !empty($tagParams->faicon) ) $data->faicon = $tagParams->faicon;
		if ( !empty($tagParams->color) ) $data->color = $tagParams->color;
		if ( !empty($tagParams->showTitle) ) $data->header = $tagParams->title;
		if ( !empty($tagParams->showTitle) ) $data->headerRightA[] = $controlHTML;

		$data->body = $finalHTML;

		return WPage::renderBluePrint( 'panel', $data );

	}









	private function _displayAccordionVertical($productsA,$tagParams) {

		if ( !empty($productsA) ) {

			if ( empty($tagParams->id) ) {
				if ( !empty($tagParams->idLabel) ) $tagParams->id = $tagParams->idLabel;
				else $tagParams->id = 'acordon' . time();
			}

						WLoadFile( 'blueprint.frame', JOOBI_DS_THEME_JOOBI );
			WLoadFile( 'blueprint.frame.sliders', JOOBI_DS_THEME_JOOBI );

			$tagParams->animate = true;
			$tagParams->delay = 2500;

			$frame = new WPane_sliders( $tagParams );
			$frame->startPane( $tagParams );

			$count = 0;
			foreach( $productsA as $product ) {

				if ( is_array($product) ) $product = array_shift( $product );

				$count++;
				$product->nb = $count;
				$frame->startPage( $tagParams );

				if ( $this->hasImage && empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );
				$html = Output_Theme_class::callTheme( $product, $tagParams );

				$frame->content = $html;

				$paramO = new stdClass;
				$paramO->text = $product->name;
				if ( empty($paramO->parent) ) $paramO->parent = $tagParams->id;

				$frame->endPage( $paramO );

			}
			$html = $frame->endPane( $tagParams );

		} else {
			$html = '';
		}		if ( empty($tagParams->showTitle) ) {
			return $html;
		} else {
			$data = WPage::newBluePrint( 'panel' );
			$data->id = 'accordionVertical';
			if ( !empty($tagParams->faicon) ) $data->faicon = $tagParams->faicon;
			if ( !empty($tagParams->color) ) $data->color = $tagParams->color;
			if ( !empty($tagParams->showTitle) ) $data->header = $tagParams->title;

			$data->body = $html;

			return WPage::renderBluePrint( 'panel', $data );
		}
	}








	private function _displayAccordionHorizontal($productsA,$tagParams) {
		static $loadedJS=null;

		
		if ( !$loadedJS ) {
			$browser = WPage::browser();
			if ( $browser->name == 'msie' ) {
				WPage::addCSSScript( 'div#itemAccordeonWrapper div.itemAccordeonTitleWrapper{text-indent:15px;left:17px;width:265px;height:36px!important;top:-8px!important;}');
			}
			WPage::addJSLibrary( 'jquery' );

			WPage::addCSSFile( 'css/accordion-horizontal.css' );

			WPage::addJSFile( 'js/accordion-horizontal.js' );
			$loadedJS = true;
		}
		$key = $this->nodeName;
		if ( isset($alreadyLoaded[$key]) ) {
			$key = $this->nodeName.'-'.$keyIndex;
			$keyIndex++;
		}
		$height = 230;
		$width = 600;
		$subHeight = $height-67;
		$subWidth = $width-83;
		$numberPanes = count($productsA);
		$alreadyLoaded[$key] = true;	
		$JScode  = 'var $jq=jQuery.noConflict();';
		$JScode .= 'var itemAccordeonmodule_counter = "'.$numberPanes.'";';
		$JScode .= 'var itemAccordeonurl = "'. JOOBI_URL_THEME_JOOBI .'images/accordion/";';
		$JScode .= 'var itemAccordeonspeed = "900";';
		$JScode .= 'var itemAccordeontransition = "3500";';
		$JScode .= 'var itemAccordeoncycle = "yes";';
		$JScode .= 'var itemAccordeondef_slide = "1";';

		$JScode .= '$jq(function(){
var itemWidth = jQuery(\'#itemAccordeonWrapperWidth\').width();
var itemSlideWidth = itemWidth - ( ( itemAccordeondef_slide - 1) * 40);
var itemSusWidth = itemWidth - 141;
var num= itemAccordeondef_slide;
if (num == "1"){
itemAccordeonopen(1);
} else {
if (document.getElementById("itemAccordeon"+num)) {
eval("itemAccordeonopen("+num+");");
}
}
$jq("div.accordeonMain").addClass("accordeonMain-js");
$jq("div#itemAccordeonWrapper").addClass("itemAccordeonWrapper-js");
$jq("div#itemAccordeonWrapper").css("width", itemWidth+\'px\');
$jq("div.accordeonMain").css("width", itemSlideWidth+\'px\');
$jq("div.itemAccordeonContent").css("width", itemSusWidth+\'px\');
window.setTimeout("itemAccordeonrotate_slides()",itemAccordeontransition);
});';

		WPage::addJSFile( 'main/js/jquery_easing.js', 'inc' );
		WPage::addJSScript( $JScode, 'default', false );

		$height = $height . 'px';
		$width = $width . 'px';

		$html = '<div style="display:none">';
		foreach( $productsA as $product ) $html .= '<img alt="icon" src="' . JOOBI_URL_THEME_JOOBI .'images/accordion/slide.png">';
		$html .= '</div>';

		$extraCSS = ( empty($tagParams->showTitle) ? 'margin-bottom:20px;' : '' );
		$html .= '<div id="itemAccordeonWrapperWidth" style="width:100%;"></div><div id="itemAccordeonWrapper" onclick="itemAccordeondisable()" onblur="itemAccordeonenable()" style="border-top:none; border-left:none; border-bottom:none; border-right:none; padding:0px; margin:0px; height:'.$height.'; width:'.$width.';' . $extraCSS . '">';

		$slideWidth = $width - ( ( $numberPanes - 1) * 40);

		$i=0;
		foreach( $productsA as $product ) {

			if ( is_array($product) ) $product = array_shift( $product );
			$i++;
			$product->nb = $i;

			$html .= '<div id="itemAccordeon'.$i.'" onclick="itemAccordeonopen('.$i.')" class="accordeonMain" style="padding:0px; margin:0px; height:'. $height .'px;">';
			$html .= '<div id="accordeonLinkWrap'.$i.'" style="width:40px; height:'.$height.';">';
			$html .= '<div style="margin:0px; height:'.$subHeight.'px;" class="itemAccordeonBody">';
			$html .= '<div style="margin:0px" class="itemAccordeonTitleWrapper">';
			$html .= str_replace( ' ', '&nbsp;', $product->name );
			$html .= '</div></div>';
			$html .= '</div>';
			$html .= '<div class="itemAccordeonContent" style="margin:0px; width:'.$subWidth.'px;">';

			if ( $this->hasImage && empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );
			$html .= Output_Theme_class::callTheme( $product, $tagParams );
			$html .= '</div></div>';

		}
		$html .= '</div>';


		if ( empty($tagParams->showTitle) ) {
			return $html;
		} else {
			$data = WPage::newBluePrint( 'panel' );
			$data->id = 'accordionHorizontal';
			if ( !empty($tagParams->faicon) ) $data->faicon = $tagParams->faicon;
			if ( !empty($tagParams->color) ) $data->color = $tagParams->color;
			if ( !empty($tagParams->showTitle) ) $data->header = $tagParams->title;

			$data->body = $html;

			return WPage::renderBluePrint( 'panel', $data );
		}
	}









	private function _renderSubCategoryBadge($productA,$tagParams,$className) {

		if ( !isset($tagParams->subCatPopOver) ) $tagParams->subCatPopOver = 0;
		switch( $tagParams->subCatPopOver ) {
			case 5:						return $this->_renderSubCategoryCollapse( $productA, $tagParams, $className );
				break;
			case 7:
				$useDIV = false;
				break;
			case 0:
			case 1:
			default:
				$useDIV = true;					break;
		}
				$mainParent = key($productA);
		$initialLevel = $productA[$mainParent][0]->depth;

		$firstLevelA = $productA[$mainParent];
		unset( $productA[$mainParent] );

				$reversedA = array_reverse( $productA, true );

		$childHMTLA = array();
		$tagParamsChild = clone $tagParams;
		$tagParamsChild->containerClass = 'categoryChild';
		$tagParamsChild->borderShow = false;
		$tagParamsChild->borderColor = 'none';
		$nb = 0;
		foreach( $reversedA as $manySubProduct ) {

			$htmlSubCategory = ( $useDIV ? '<div>' : '<ul class="subCat">' );		
						foreach( $manySubProduct as $oneProduct ) {

								$oneProduct->level = $oneProduct->depth - $initialLevel;
				$nb++;
				$oneProduct->nb = $nb;

				if ( empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $oneProduct, $tagParamsChild, $this->tagID, $oneProduct->depth - $initialLevel + 1 );

				if ( !$useDIV ) $htmlSubCategory .= '<li>';

				$htmlSubCategory .= Output_Theme_class::callTheme( $oneProduct, $tagParamsChild );

								if ( isset($childHMTLA[$oneProduct->catid]) ) {
					$htmlSubCategory .= $childHMTLA[$oneProduct->catid];
				}
				if ( !$useDIV ) $htmlSubCategory .= '</li>';

			}
			$htmlSubCategory .= ( $useDIV ? '</div>' : '</ul>' );
			$childHMTLA[$oneProduct->parent] = $htmlSubCategory;			}
		if ( !empty($tagParams->classSuffix) ) $className .= $tagParams->classSuffix;
		$extraClass = ( !empty($tagParams->display) &&  'menu' == $tagParams->display ) ? ' menu' : '';

		$html = '<div class="container-fluid"><div class="row">';
		$totalItems = count($initialLevel);
		$count = 1;
		$styleApplied = ( !empty($tagParams->containerStyle) ? $tagParams->containerStyle : '' );			$styleApplied = '';

		unset( $tagParams->containerStyle );
		foreach( $firstLevelA as $key => $product ) {

			if ( empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );	
						if ( isset($childHMTLA[$product->catid]) ) {
				$htmlChild = $childHMTLA[$product->catid];
			} else {
				$htmlChild = '';
			}
			$styleAppliedClass = ( !empty($htmlChild) ) ? $styleApplied.' class="parentMenu"' : $styleApplied;

						if ( !empty($htmlChild) ) {

				if ( !empty( $tagParams->subCatPopOver ) && $tagParams->subCatPopOver == 1 ) {

					$product->htmlChild = $htmlChild;
					$product->htmlID = 'item_' . $product->namekey;
					$subCatId = $product->htmlID . '_sub';
					$htmlChild = '';

										$js = "jQuery(function() {
var moveLeft = 20;
var moveDown = 10;
jQuery('div#" . $product->htmlID . "').hover(function(e) {
jQuery('div#" . $subCatId . "').show();
}, function() {
 jQuery('div#" . $subCatId . "').hide();
});
jQuery('div#" . $product->htmlID . "').mousemove(function(e) {
jQuery('div#" . $subCatId . "').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
});
});
";

					WPage::addJSLibrary( 'jquery' );
					WPage::addJSScript( $js );

				} else {
					$product->htmlID = '';					}
			} else {
				$product->htmlID = '';				}
			if ( !empty( $tagParams->subCatPopOver ) ) {
				if ( $tagParams->subCatPopOver == 1 ) {
					$product->subCategoryStyle = 'popOver';
				} elseif ( $tagParams->subCatPopOver == 7 ) {
					$product->subCategoryStyle = 'ul-li';
				}			}
			if ( !isset($product->subCategoryStyle) ) $product->subCategoryStyle = '';
			if ( empty($product->htmlChild) && !empty($htmlChild) ) $product->htmlChild = $htmlChild;

			$parentCat = Output_Theme_class::callTheme( $product, $tagParams );
			$html .= $parentCat;

			
			$count++;

		}
		$html .= '</div><div class="clearfix"></div>';			$html .= '</div>';

		return $html;

	}







	private function _renderSubCategoryCollapse($productA,$tagParams,$className) {

		$tagParams->subCatPopOver = 7;
		$useDIV = false;	
		$tagParams->layout = 'badgecolappse';

				$mainParent = key($productA);
		$initialLevel = $productA[$mainParent][0]->depth;

		$firstLevelA = $productA[$mainParent];
		unset( $productA[$mainParent] );

				$reversedA = array_reverse( $productA, true );

		$childHMTLA = array();
		$tagParamsChild = clone $tagParams;
		$tagParamsChild->containerClass = 'categoryChild';
		$tagParamsChild->borderShow = false;
		$tagParamsChild->borderColor = 'none';
		$nb = 0;
		foreach( $reversedA as $manySubProduct ) {

			$htmlSubCategory = ( $useDIV ? '<div class="accordion-content">' : '<ul class="list-unstyled accordion-content">' );		
						foreach( $manySubProduct as $oneProduct ) {

								$oneProduct->level = $oneProduct->depth - $initialLevel;
				$nb++;
				$oneProduct->nb = $nb;

				if ( empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $oneProduct, $tagParamsChild, $this->tagID, $oneProduct->depth - $initialLevel + 1 );

				if ( !$useDIV ) $htmlSubCategory .= '<li>';
				else $htmlSubCategory .= '<div class="accordion-content-sub">';

				$htmlSubCategory .= Output_Theme_class::callTheme( $oneProduct, $tagParamsChild );

								if ( isset($childHMTLA[$oneProduct->catid]) ) {
					$htmlSubCategory .= $childHMTLA[$oneProduct->catid] . '<span>+</span>';
				}
				if ( !$useDIV ) $htmlSubCategory .= '</li>';
				else $htmlSubCategory .= '</div>';



			}
			$htmlSubCategory .= ( $useDIV ? '</div>' : '</ul>' );
			$childHMTLA[$oneProduct->parent] = $htmlSubCategory;			}

		if ( !empty($tagParams->classSuffix) ) $className .= $tagParams->classSuffix;
		$extraClass = ( !empty($tagParams->display) &&  'menu' == $tagParams->display ) ? ' menu' : '';

		$html = '<div class="clearfix"><ul class="list-unstyled category-mini-accordion">';
		$totalItems = count($initialLevel);
		$count = 1;
		$styleApplied = ( !empty($tagParams->containerStyle) ? $tagParams->containerStyle : '' );			$styleApplied = '';

		unset( $tagParams->containerStyle );
		foreach( $firstLevelA as $key => $product ) {

			if ( empty($tagParams->showNoImage) ) Output_Theme_class::setImageSize( $product, $tagParams, $this->tagID );	
						if ( isset($childHMTLA[$product->catid]) ) {
				$htmlChild = $childHMTLA[$product->catid];
			} else {
				$htmlChild = '';
			}
			$styleAppliedClass = ( !empty($htmlChild) ) ? $styleApplied.' class="parentMenu"' : $styleApplied;

						if ( !empty($htmlChild) ) {

				if ( !empty( $tagParams->subCatPopOver ) && $tagParams->subCatPopOver == 1 ) {

					$product->htmlChild = $htmlChild;
					$product->htmlID = 'item_' . $product->namekey;
					$subCatId = $product->htmlID . '_sub';
					$htmlChild = '';

										$js = "jQuery(function() {
var moveLeft = 20;
var moveDown = 10;
jQuery('div#" . $product->htmlID . "').hover(function(e) {
jQuery('div#" . $subCatId . "').show();
}, function() {
 jQuery('div#" . $subCatId . "').hide();
});
jQuery('div#" . $product->htmlID . "').mousemove(function(e) {
jQuery('div#" . $subCatId . "').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
});
});
";

					WPage::addJSLibrary( 'jquery' );
					WPage::addJSScript( $js );

				} else {
					$product->htmlID = '';					}
			} else {
				$product->htmlID = '';				}
			if ( !empty( $tagParams->subCatPopOver ) ) {
				if ( $tagParams->subCatPopOver == 1 ) {
					$product->subCategoryStyle = 'popOver';
				} elseif ( $tagParams->subCatPopOver == 7 ) {
					$product->subCategoryStyle = 'ul-li';
				}			}
			if ( !isset($product->subCategoryStyle) ) $product->subCategoryStyle = '';
			if ( empty($product->htmlChild) && !empty($htmlChild) ) $product->htmlChild = $htmlChild;

			$parentCat = Output_Theme_class::callTheme( $product, $tagParams );

						$html .= '<li>';

			$html .= $parentCat;

			
			$html .= '</li>';

			
			$count++;

		}
		$html .= '</ul>';			$html .= '</div>';

		return $html;


	}
}