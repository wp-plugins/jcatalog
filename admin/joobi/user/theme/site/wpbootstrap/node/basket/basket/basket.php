<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Basket_Basket_module extends WModule {

	public $displaytype = 0;











function create() {


	
	$controller = WGlobals::get('controller');

	if ( empty($this->showcartcheckout) && strtolower($controller) == 'basket' ) return '';




	
	WText::load( 'basket.node' );




	
	$catalog = WPref::load( 'PPRODUCT_NODE_CATALOGUE' );

	if ( $catalog ) return true;



	$uid = WUser::get('uid');



	if ( PPRODUCT_NODE_LOGPRICE && $uid == 0 ) {

		$this->content = WText::t('1409955128XHX');

		return true;

	}

			WPage::addCSSFile( 'node/basket/css/style.css' );



	$gratos = false;

	$basketC = WClass::get( 'basket.previous' );

	$basket = $basketC->getBasket();



	
	if ( isset($basket->skip) ) unset( $basket->skip );



		WPage::addCSSFile( 'node/basket/css/style.css' );
	
	switch ( $this->displaytype ) {
		case 0:
			$HTML = $this->displayOne( $basket ); 			break;
		case 1 :
			$HTML = $this->displayTwo( $basket ); 			break;
		case 2 :
			$HTML = $this->displayMiniBasket( $basket ); 			break;
		default :
			$HTML = $this->displayOne( $basket ); 			break;
	}

		$this->content .= $HTML;





	return true;


}








public function displayMiniBasket($basket) {

	if ( empty($basket->Products) ) {
		return '';
    }
	$HTML = '';

	$returnIdURI = WView::getURI();
	$returnid = base64_encode( $returnIdURI) ; 	$link = $this->_checkoutLink( $returnid );


		$HTML = '<a href="'. $link .'" style="text-decoration:none;">';
	$HTML .= '<div class="cartMini">';

	if ( !empty($this->showitems) ) {
				if ( !empty($basket->Products) ) $itemNb = count( $basket->Products );
		if ( !empty($itemNb) ) {
			$htmlItems = '<div class="cartItemNb"><span class="cartItemNbNumber">'. $itemNb .'</span>' . ' ';
			$htmlItems .= '<span class="cartItemNbText">';
			$htmlItems .= ( ( $itemNb > 1 ) ? WText::t('1233642085PNTA') : WText::t('1206732372QTKR') ) ;
			$htmlItems .= ' </span></div>';
			$HTML .= $htmlItems;
		}
	}
	if ( !empty($this->showtotal) ) {

		$usedCurrency = WUser::get( 'curid' );
		$priceHTML = ( !empty($basket->totalprice) ? WTools::format( $basket->totalprice, 'money', $usedCurrency ) : '' );
		$formatedTotalPrice = '<span class="cartModTotal">' . $priceHTML . '</span>';
				$total = '<div class="cartTotalWrap"><span class="cartModTotalText">'. WText::t('1206961912MJPF') .'</span> ';			$total .= '<span class="cartModTotalPrice">' . $formatedTotalPrice .'</span></div>';
		$HTML .= $total;

	}

	if ( !empty($this->showaddcart) ) {

		$returnIdURI = WView::getURI();
		$returnid = base64_encode( $returnIdURI) ; 
		$link = $this->_checkoutLink( $returnid );



		$HTML .= '<div class="cartModCheckout">';
		$objButtonO = WPage::newBluePrint( 'prefcatalog' );
		$objButtonO->type = 'buttonAddToCartInCatalogPage';
		$objButtonO->text = WText::t('1257933926DISL');
		$objButtonO->link = $link;
		$HTML .= WPage::renderBluePrint( 'prefcatalog', $objButtonO );
		$HTML .= '<div class="clr"></div></div>';

	}
	$HTML .= '</div>';
	$HTML .= '</a>';

	return $HTML;

}






public function displayTwo($basket) {

	WPage::addCSSFile( 'css/dropdown-hover.css' );
	WPage::addCSSFile( 'css/perfect-scrollbar.css' );

	WPage::addJSFile( 'js/perfect-scrollbar.js' );
	WPage::addJSFile( 'js/global.js' );


	$HTML = '';

    $button = '<div class="btn-update">';
	$button .= '<button type="submit" name="task" value="updatecart" class="btn cartModUpdateBtn btn-small btn-info">' . WText::t('1227580898LIDX') . '</button>';
    $button .= '</div>';

    $HTML .= '<div class="dropdown dropdown-mini">';
    $HTML .= '<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-shopping-cart"></i> Cart<b class="caret"></b></a>';

    	$total = '<div class="fieldL"></div>';

	$objButtonO = WPage::newBluePrint( 'button' );
	$objButtonO->text = $button;
	$objButtonO->type = 'standard';
    $objButtonO->extraClasses = 'btn-small btn-info';
	$objButtonO->wrapperDiv = 'fieldR';

	$updateBtn = WPage::renderBluePrint( 'button', $objButtonO );

	$total .= '<div class="clr"></div>';
	$total .= $this->_displayTotal( $basket );

                if ( empty($basket->Products) ) {

            $HTML .= '<div class="dropdown-menu"><div class="cart-empty">' . WText::t('1429219767TAKO') . '</div></div>';

        } else {

            $controller = new stdClass;
            $controller->controller = 'basket';
            $controller->wid = $this->wid;
            $controller->sid = WModel::get( 'basket', 'sid');
            $controller->firstForm = true;

            $this->layout = WView::getHTML( 'basket_module_listing', $controller );

            $formObj = WView::form( $this->layout->firstFormName );
            $formObj->hiddenRemove( 'task' );
            
            $this->layout->addContent( $updateBtn );


                        $HTML .= '<div class="dropdown-menu">';

            $HTML .= '<div class="dropdown-items overflow wrapper"><div class="items-scroll">' . $this->layout->make() . '</div></div>';

                        $HTML .= '<div class="clr"></div>';

                        $HTML .= '<div class="cartmini-total-foot">';
            $HTML .= '<div class="total-wrap clearfix">' . $total . '</div>';

            if ( !empty($this->showaddcart) ) {

                    $returnIdURI = WView::getURI();
                    $returnid = base64_encode($returnIdURI); 
                    $link = $this->_checkoutLink( $returnid );

                    $HTML .= '<div class="cartModCheckout">';

                    
                    $objButtonO = WPage::newBluePrint( 'prefcatalog' );
                    $objButtonO->type = 'buttonAddToCartInCatalogPage';
                    $objButtonO->extraClasses = 'btn-success btn-small btn-add-cart-mini';
                    $objButtonO->text = WText::t('1206961936HCWQ');
		    $objButtonO->icon = 'fa-shopping-cart';
                    $objButtonO->link = $link;
                    $HTML .= WPage::renderBluePrint( 'prefcatalog', $objButtonO );

                    $HTML .= '<div class="clr"></div></div>';

            }
                        $HTML .= '</div>';
            $HTML .= '</div>';
            $HTML .= '</div>';

        }
	return $HTML;

}






public function displayOne($basket) {

	if ( empty($basket->Products) ) {
		return '<div class="cart-empty">' . WText::t('1429219767TAKO') . '</div>';
    }

	$HTML = '';

		$itemtxt = isset( $this->itemtxt ) ? $this->itemtxt : '';

		if ( !empty($this->showitems) ) {
		WGlobals::set( 'BasketShowItems', true, 'global' );
	}

	$total = $this->_displayTotal( $basket );

	$controller = new stdClass;
	$controller->controller = 'basket';
	$controller->wid = $this->wid;
	$controller->sid = WModel::get( 'basket', 'sid' );
	$controller->firstForm = true;

	$this->layout = WView::getHTML( 'basket_module_listing', $controller );

	if ( empty($this->layout) ) return $HTML;

	$formObj = WView::form( $this->layout->firstFormName );
	$formObj->hiddenRemove( 'task' );


	$returnIdURI = WView::getURI();
	$returnid = base64_encode( $returnIdURI ); 	$link = $this->_checkoutLink( $returnid );

	$this->layout->addContent( $total );

	$HTML .= '<div class="clr"></div>';
	$HTML .= '<div class="cartModMain">'. $this->layout->make() .'</div>';
	$HTML .= '<div class="clr"></div>';



	if ( !empty($this->showaddcart) ) {

				$HTML .= '<div class="cartModCheckout clearfix">';

				$HTML .= '<button type="submit" name="task" value="updatecart" class="btn cartModUpdateBtn">' . WText::t('1227580898LIDX') . '</button>';

		$objButtonO = WPage::newBluePrint( 'prefcatalog' );
		$objButtonO->type = 'buttonAddToCartInCatalogPage';
		$objButtonO->text = WText::t('1257933926DISL');
		$objButtonO->icon = 'fa-shopping-cart';
		$objButtonO->link = $link;
		$HTML .= WPage::renderBluePrint( 'prefcatalog', $objButtonO );

		$HTML .= '</div>';

		$HTML .= '<div class="clr"></div>';
	}
	return $HTML;
}






private function _displayTotal($basket) {


	$total = '';
	$showSubtotal = false;
	$usedCurrency = WUser::get( 'curid' );

		WPref::load( 'PCATALOG_NODE_USETAX' );
	if ( PCATALOG_NODE_USETAX && PCATALOG_NODE_SHOWTAX ) {

				if ( !empty($basket->totaltax) ) {
			$showSubtotal = true;

			$totalTax = '<div class="cartModTotalWrap"><span class="cartModTotalText">'. WText::t('1206961911NYAQ') .' :</span>';
			if ( PCATALOG_NODE_SHOWPRICETAX == -1 ) $totalTax .=  ' + ';

			$totalTax2Pay = $basket->totaltax;


			$totalTax .= WTools::format( $totalTax2Pay, 'money', $usedCurrency ) .'</div>';

		}
	}
	if ( $showSubtotal ) {

		$total .= '<div class="cartModTotalWrap"><span class="cartModTotalText">'. WText::t('1251253375NEZJ') .' :</span>';
		$total .= WTools::format( $basket->subtotal, 'money', $usedCurrency ) .'</div>';

		
				if ( PCATALOG_NODE_USETAX && !empty($basket->shippingRate) && $basket->hasShipping ) {
			if ( $basket->shippingRate > 0 ) $showSubtotal = true;
			$shippingRateValue = $basket->shippingRate;

			
			$total .= '<div class="cartModTotalWrap"><span class="cartModTotalText">'. WText::t('1213180320PQFZ') .' :</span>';
			$total .= ' + ' . WTools::format( $shippingRateValue, 'money', $usedCurrency ) .'</div>';

		}
				$total .= $totalTax;


	}
	if ( !empty( $basket->totaldiscount ) && $basket->totaldiscount > 0 ) {
		$total .= '<div class="cartModTotalWrap"><span class="cartModTotalText">'. WText::t('1206961911NYAO') .' :</span>';
		$total .= WTools::format( -1 * $basket->totaldiscount, 'money', $usedCurrency ) .'</div>';
	}

	if ( isset($basket->totalprice) ) $formatedTotalPrice = '<span class="cartModTotal">' . WTools::format( $basket->totalprice, 'money', $usedCurrency ) . '</span>';
	else $formatedTotalPrice = '';

		$total .= '<div class="cartModTotalWrap"><span class="cartModTotalText">'. WText::t('1206961912MJPF') .' :</span>';
	$total .= $formatedTotalPrice .'</div>';
	
	return $total;

}




	private function _checkoutLink($returnid) {

		$itemId = WPage::getSpecificItemId( 'basket' );

		$link = WPage::link( 'controller=basket&task=check&returnid=' . $returnid, '', $itemId );
		return $link;
	}

}