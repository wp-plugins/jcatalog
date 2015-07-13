<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'main.listing.moneycurrency' );
class WListing_Coremoneyconverted extends WListing_moneycurrency {

	protected $prodtypid = 0;		protected $pricetaxtype = 0;

	protected $tax = null;
	protected $priceIncluding = null;
	protected $priceExcluding = null;

	protected $showTaxInfo = true;

	function create() {
		static $curidUsed = null;

						if ( !isset($curidUsed) ) $curidUsed = WGlobals::get( 'curid' );
				if ( empty($curidUsed) ) $curidUsed = WUser::get('curid');

				if ( empty($curidUsed) ) $curidUsed = WPref::load( 'PCURRENCY_NODE_PREMIUM' );
		$taxExtra = '';



				$status = parent::create();

				$modelName = WModel::get( $this->modelID, 'namekey' );

				$priceModel = WModel::get( $modelName . '.price', 'sid', null, false );
		if ( !empty($priceModel) ) $priceType = $this->getValue( 'type', $modelName . '.price' );
		else $priceType = 0;

				if ( $this->_setup() ) {
			$dropdownPL = WView::picklist( $this->_did );

			if ( empty($dropdownPL->_didLists[0]) ) {
				$message = WMessage::get();
				$message->codeE('The picklist with ID :'.$this->_did.' is not available.  Check the form element with ID :'.$this->element->fid.' to solve the problem.  It can be either picklist is not publish or the Level does not match.');
				return false;
			}			$dropdownPL->params = $this->element ;

			$dropdownPL->name = 'trucs['. $this->modelID .'][curid]' ;

						$outype = $dropdownPL->_didLists[0]->outype;

									
			$curidMap = 'curid_' . $this->modelID;
			$dropdownPL->defaults = ( isset( $this->data->$curidMap ) ) ? $this->data->$curidMap : 0;

			$dropdownPL->params->classes = ( isset( $this->element->classes ) ) ? $this->element->classes : 'simpleselect';

			$picklistHTML = $dropdownPL->display();
			if ( empty( $picklistHTML ) ) return false;

			$this->content .= $picklistHTML;

				} else {
			if ( !empty( $this->curid ) ) $curid = $this->curid;
			else $curid = $this->getValue( 'curid' );

						if ( empty($curid) ) $curid = WPref::load( 'PCURRENCY_NODE_PREMIUM' );

			
			if ( !empty($priceType) && $priceType != 10 ) {
				static $prodPricesC = null;
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

								if ( $curid != $curidUsed ) {
				    static $currencyC = null;
					if ( empty($currencyC) ) $currencyC = WClass::get( 'currency.convert',null,'class',false);
				    $convertedPrice = $currencyC->currencyConvert( $curid, $curidUsed, $this->value );
				} else {
					$convertedPrice = $this->value;
				}
								if ( empty( $this->element->noTax ) ) {
				    					if ( WPref::load('PCATALOG_NODE_USETAX') ) {

						$pricetaxtype = $this->pricetaxtype;
						if ( empty($pricetaxtype) ) $pricetaxtype = $this->getValue( 'pricetaxtype' );
						if ( empty($pricetaxtype) ) $pricetaxtype = PCATALOG_NODE_TAXEDITEDPRICE;												static $productTaxC=null;
						if ( !isset( $productTaxC ) ) $productTaxC = WObject::get( 'product.tax', null, false );

						if ( !empty( $productTaxC ) ) {
						$prodtypid = $this->prodtypid;
						if ( empty($prodtypid) ) $prodtypid = $this->getValue( 'prodtypid' );
						if ( empty($prodtypid) ) $prodtypid = $this->prodtypid;
						$pid = 0;
						if ( !empty($this->pid) ) $pid = $this->pid;
						if ( empty($pid) ) $pid = $this->getValue( 'pid' );

						if ( WRoles::isAdmin( 'storemanager' ) ) {								$vendid = $this->getValue( 'vendid' );
						} else {								$vendid = $productTaxC->getVendorID( $this->getValue( 'vendid' ) );
						}						$productTaxC->setVendorID( $vendid );
						$productTaxC->setPrice( $convertedPrice, $pricetaxtype, $prodtypid, $pid );
						$productTaxC->setTax( $this->tax );
						if ( isset($this->priceIncluding) ) $productTaxC->setInluding( $this->priceIncluding );
						if ( isset($this->priceExcluding) ) $productTaxC->setExluding( $this->priceExcluding );

						$convertedPrice = $productTaxC->renderPrice();
						if ( $this->showTaxInfo ) $taxExtra = '<div class="productTax">' . $productTaxC->renderTaxMessage( $curidUsed, false, 0 ) . '</div>';
						}
					}
				}

				$this->content = WTools::format( $convertedPrice, 'currency', $curidUsed ) . $taxExtra;
			}

		}
		return $status;

	}




	private function _setup() {

				if ( $this->element->did > 0 ) {
			$this->_did = $this->element->did;
		} else {
			return false;
		}		return true;

	}
}