<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.text' );
class WForm_Coremoneycurrency extends WForm_text {

	function create() {

				if ( empty( $this->element->width ) ) $this->element->width = 10;

		$defaultCurrency = $this->getValue( 'curid', $this->modelID );
				if ( empty($defaultCurrency) || $defaultCurrency < 1 ) $defaultCurrency = 0;

		if ( !empty($defaultCurrency) ) $this->value = WTools::format( $this->value, 'priceDecimal', $defaultCurrency );

		if ( !defined('CURRENCY_USED') ) {
			$currencyFormatC = WClass::get('currency.format', null,'class',false);
			if ( !empty($currencyFormatC) ) $currencyFormatC->set();
		}
				if ( !$this->_setup() ) return false;
		$dropdownPL = WView::picklist( $this->_did );

		if ( empty($dropdownPL->_didLists[0]) ) {
			$message = WMessage::get();
			$message->codeE('The picklist with ID :'.$this->_did.' is not available.  Check the form element with ID :'.$this->element->fid.' to solve the problem.  It can be either picklist is not publish or the Level does not match.');
			return false;
		}		$dropdownPL->params = $this->element ;

		$dropdownPL->name= 'trucs['. $this->modelID .'][curid]' ;

				$outype = $dropdownPL->_didLists[0]->outype;

						
				$listingSecurity = WGlobals::get( 'securityForm', array(), 'global' );
		$listingSecurity[$this->modelID][] = 'curid';
		WGlobals::set( 'securityForm', $listingSecurity, 'global' );

						$multipleCurrency = ( WPref::load( 'PCURRENCY_NODE_MULTICUREDIT' ) ? true : false );


		if ( $multipleCurrency ) {
			$dropdownPL->defaults = $defaultCurrency;

			$dropdownPL->params->classes = ( isset( $this->element->classes ) ) ? $this->element->classes : 'simpleselect';

			$picklistHTML = $dropdownPL->display();
			if ( empty( $picklistHTML ) ) return false;

		} else {

			$formObject = WView::form( $this->formName );

			$formObject->hidden( 'trucs['.$this->modelID.'][curid]', $defaultCurrency );

			$curencySymbol = WPref::load( 'PCURRENCY_NODE_CODESYMBOL' );
			$hasSymbol = ( in_array( $curencySymbol, array( 'symbol', 'money', 'moneyCode' ) ) ? true : false );
			$hasCode = ( in_array( $curencySymbol, array( 'code', 'moneyNoSymbol', 'moneyCode' ) ) ? true : false );

			if ( $hasSymbol ) {
				$this->addPreText = WTools::format( 1, 'currencySymbol', $defaultCurrency );
			}			if ( $hasCode ) {
				$this->addPostText = WTools::format( 1, 'currencyCode', $defaultCurrency );
			}
		}
		WPref::load('PCATALOG_NODE_TAXGIVECHOICE');
		if ( PCATALOG_NODE_USETAX && PCATALOG_NODE_TAXGIVECHOICE != 1 ) {
			WText::load( 'main.node' );
			$including = WText::t('1315191208QKMR');
			$excluding = WText::t('1315191208QKMS');
			$this->addPostText .= ' ' . ( ( PCATALOG_NODE_TAXEDITEDPRICE == 1 ) ? $including : $excluding );
		}

		if ( $multipleCurrency ) {
			$this->addPreText = '';
			$this->addPostText = '';
			$status = parent::create();
			$this->content .= $picklistHTML;
		} else {
						$status = parent::create();
		}
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

			$priceObj = new stdClass;
			$priceObj->pid = $this->getValue( 'pid' );
			$priceObj->priceType = $priceType;
			$priceObj->price = $this->value;
			$priceObj->curidFrom = $curid;
			$priceObj->curidTo = $curid;
			$priceObj->vendid = $this->getValue( 'vendid' );
			$priceObj->link = $this->getValue( 'link' );
			$priceObj->modelID = $this->modelID;
						if ( empty( $prodPricesC ) ) $prodPricesC = WClass::get( 'product.prices', null, 'class', false );
			$this->content = $prodPricesC->showPriceHTML( $priceObj );

		} else {

			$amount = WTools::format( $this->value, 'currency' );

			$this->content = $this->addStyling( $amount );

		}
		return true;
	}




	private function _setup() {

				if ( $this->element->did > 0 ) {
			$this->_did = $this->element->did;
		} else {
			$this->_did = 'currency_form_publish';
			return true;
		}		return true;

	}

}