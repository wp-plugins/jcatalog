<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.text' );
class WForm_Coremoney extends WForm_text {

	function create() {

				if ( empty( $this->element->width ) ) $this->element->width = 10;

		$curid = $this->getValue( 'curid', $this->modelID );

								if ( empty($curid) || $curid < 1 ) $curid = WPref::load( 'PCURRENCY_NODE_PREMIUM' );

		$this->value = WTools::format( $this->value, 'priceDecimal', $curid );


		$curencySymbol = WPref::load( 'PCURRENCY_NODE_CODESYMBOL' );
		$hasSymbol = ( in_array( $curencySymbol, array( 'symbol', 'money', 'moneyCode' ) ) ? true : false );
		$hasCode = ( in_array( $curencySymbol, array( 'code', 'moneyNoSymbol', 'moneyCode' ) ) ? true : false );
		if ( $hasSymbol ) {
			$this->addPreText = WTools::format( 1, 'currencySymbol', $curid );
		}		if ( $hasCode ) {
			$this->addPostText = WTools::format( 1, 'currencyCode', $curid );
		}

		$status = parent::create();

		return $status;

	}




	function show() {

		$formObject = WView::form( $this->formName );
		$formObject->hidden( $this->map, $this->value );

				$priceType = $this->getValue( 'type' );

		if ( !empty($priceType) && $priceType != 10 ) {
			static $prodPricesC = null;

			if ( !empty( $this->curid ) ) $curid = $this->curid;
			else $curid = $this->getValue( 'curid' );
			if ( !isset($curidUsed) ) $curidUsed = WUser::get('curid');

			$priceObj = new stdClass;
			$priceObj->pid = $this->getValue( 'pid' );
			$priceObj->priceType = $priceType;
			$priceObj->price = $this->value;
			$priceObj->curidFrom = $curid;
			$priceObj->curidTo = $curidUsed;
			$priceObj->vendid = $this->getValue( 'vendid' );
			$priceObj->link = $this->getValue( 'link' );
			$priceObj->modelID = $this->modelID;
						if ( empty( $prodPricesC ) ) $prodPricesC = WClass::get( 'product.prices', null, 'class', false );

			$this->content = $prodPricesC->showPriceHTML( $priceObj );

		} else {

			$curencySymbol = WPref::load( 'PCURRENCY_NODE_CODESYMBOL' );
			$withSymbol = ( $curencySymbol == 'symbol' ? 'money' : 'moneyNoSymbol' );
			$amount = WTools::format( $this->value, $withSymbol );

			$this->content = $this->addStyling( $amount );

		}
		return true;
	}
}