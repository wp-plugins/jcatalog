<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

$basketsA = $this->getContent( 'basketsA' );
$vendorHeader = $this->getContent( 'vendorHeader' );
$totalPriceTitle = $this->getContent( 'totalPriceTitle' );


$HTMLA = array();
if ( !empty($basketsA) ) {

	foreach( $basketsA as $id => $oneVendor ) {

		$count = count( $oneVendor->productsA ) - 1;
		$allCartHTML = '';
		$mainBody = '';
	  	foreach( $oneVendor->productsA as $key => $oneProduct ) {
	  		$allCartHTML .= $oneProduct->image;
	  		$allCartHTML .= '<div class="itemName">' . $oneProduct->linkedName . '</div>';
	  		$allCartHTML .= '<div class="itemQty">' . $oneProduct->quantity . '</div>';
	  		$allCartHTML .= '<div class="itemPrice">' . $oneProduct->price . '</div>';
	  		if ( $key < $count ) $allCartHTML .= '<hr>';
	  	}

		$mainBody = '<div class="container-fluid"><div class="row"><div class="col-sm-8 basketItem">';
		$mainBody .= $allCartHTML;
		$mainBody .= '</div>';
		$mainBody .= '<div class="col-sm-4"><div class="lead TotalPrice"><strong>' . $totalPriceTitle . ': ' . $oneVendor->totalPrice . '</strong></div></div></div></div>';

		$panel = new stdClass;
		$panel->id = 'multicart_basket_' . $id;
		$panel->header = '<strong>' . $vendorHeader . ' <span class="lead">' . $oneVendor->name . '</span></strong>';
		$panel->headerRightA[] = $oneVendor->deleteButton;
		$panel->headerRightA[] = $oneVendor->checkOutButton;
		$panel->body = $mainBody;
		$HTMLA[] = WPage::renderBluePrint( 'panel', $panel );

	}
}
echo implode( ' ', $HTMLA );