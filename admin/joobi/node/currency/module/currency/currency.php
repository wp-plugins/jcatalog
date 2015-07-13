<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class Currency_CoreCurrency_module extends WModule {

	function create() {


		if ( !isset($this->displayby) ) $this->displayby = 0;
		if ( !isset($this->listtype) ) $this->listtype = 0;
		if ( !isset($this->format) ) $this->format = 3;


		
		$showModule = WGlobals::get( 'currency-show', true, 'global' );

		$this->defaultCurrencyID = WUser::get( 'curid' );



		if ( WPref::load( 'PCURRENCY_NODE_MULTICUR' ) && $showModule ) {


			
			WGlobals::set( 'currency-displayby', $this->displayby, 'global'  );

			WGlobals::set( 'currency-format', $this->format, 'global'  );



									if ( empty( $this->defaultCurrencyID ) &&  !defined('CURRENCY_USED') ) {
				$currencyFormatC = WClass::get( 'currency.format', null, 'class', false );
				$currencyFormatC->set();
				$this->defaultCurrencyID = CURRENCY_USED;
			}


			switch( $this->listtype ) {
				case 2:						$formHTML = $this->_createForm( 'curr6ency_123_abc', 'basket', 'changecurrency', 'currency_currency', 5, $this->defaultCurrencyID );
					$this->content = '<div class="currencyVertical">' . $formHTML . '</div>';
					break;
				case 5:						$formHTML = $this->_createForm( 'curr6ency_123_abc', 'basket', 'changecurrency', 'currency_currency', $this->listtype, $this->defaultCurrencyID );
					$this->content = '<div class="currencyHonrizontal">' . $formHTML . '</div>';
					break;
				default: 					$formHTML = $this->_createForm( 'curr6ency_123_abc', 'basket', 'changecurrency', 'currency_currency', $this->listtype, $this->defaultCurrencyID );
					$this->content = '<div class="currencyDefault">' . $formHTML . '</div>';
					break;
			}

		} else {
			$this->content = WText::t('1319800425BXDU');
		}
				WPage::addCSSFile( 'node/currency/css/style.css' );


		if ( $this->listtype == 11 ) {

			$currencyCode = WModel::getElementData( 'currency', $this->defaultCurrencyID, 'code' );
			$currencySymbol = WModel::getElementData( 'currency', $this->defaultCurrencyID, 'symbol' );

			$HTML = '<div class="currency-hover">' . WGet::$rLine;
			$HTML .= '<div class="btnHead">' . WGet::$rLine;
			$HTML .= '<span class="symbol">' . $currencySymbol . '</span> <span class="code">' . $currencyCode . '</span>' . WGet::$rLine;
			$HTML .= '</div>' . WGet::$rLine;				$HTML .= $this->content . WGet::$rLine;
			$HTML .= '</div>' . WGet::$rLine;

			$this->content = $HTML;
		}


		return true;


	}











	private function _createForm($formName,$controller=null,$task=null,$picklistName=null,$picklistType=0,$pickDefValue=null) {

				$currencyF = WView::form( $formName );
		if ( !empty($controller) ) $currencyF->hidden( 'controller', $controller );
		if ( !empty($task) ) $currencyF->hidden( 'task', $task );

			$option = WApplication::name( 'com' );
		$currencyF->hidden( JOOBI_URLAPP_PAGE, $option );

		$currencyF->hidden( 'returnid', base64_encode( WGlobals::currentURL( false ) ) );

		if ( !empty($picklistName) ) {

			$paramA = array();
			$paramA['controller'] = 'basket';
						$joobiRun = 'return ' . WView::addJSAction( $task, $formName, $paramA );
			$params = new stdClass;


			$params->default = $pickDefValue;				$params->outputType = $picklistType;				$params->nbColumn = 1;	
			$currencyPickList = WView::picklist( $picklistName, $joobiRun, $params );

			$currencyF->addContent( $currencyPickList->display() );

		}
		return $currencyF->make();

	}
}