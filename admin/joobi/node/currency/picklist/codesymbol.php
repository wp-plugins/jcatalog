<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Currency_Codesymbol_picklist extends WPicklist {

	function create() {


		$price = 4.75;
		$SYMBOL = WTools::format( $price, 'money' );
		$CODE = WTools::format( $price, 'moneyNoSymbol' );
		$SYMBOL_CODE = WTools::format( $price, 'moneyCode' );


		$this->addElement( 'money', str_replace(array('$SYMBOL'), array($SYMBOL),WText::t('1402624934RWOS')) );	
		$this->addElement( 'moneyNoSymbol', str_replace(array('$CODE'), array($CODE),WText::t('1402624934RWOT')) );

		$this->addElement( 'moneyCode', str_replace(array('$SYMBOL_CODE'), array($SYMBOL_CODE),WText::t('1402624934RWOU')) );


		return true;



	}
}