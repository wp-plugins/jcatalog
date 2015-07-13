<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_CoreAdvancesearch_module extends WModule {


	private $_customFieldInfoA = array();
	private $_vendorsFieldInfoA = array();
	private $_smartfilter = false;






	function create() {



		$this->_smartfilter = ( !empty($this->smartfilter) ? $this->smartfilter : false );

		$autoHide = ( isset($this->autohide) ? $this->autohide : 'onlyhome' );

				if ( $autoHide && 'everywhere' != $autoHide ) {

			$controller = WGlobals::get( 'controller' );
			if ( 'catalog' != $controller && 'catalog-results' != $controller ) return false;

						if ( 'onlyhome' == $autoHide ) {
				$task = WGlobals::get( 'task' );
				if ( 'catalog' == $controller && 'home' != $task ) return false;
			}
			if ( 'category' == $autoHide ) {
				$task = WGlobals::get( 'task' );
				if ( 'catalog' == $controller && ( 'home' != $task && 'category' != $task ) ) return false;
			}
		}



				$useDimension = WPref::load( 'PPRODUCT_NODE_USEDIMENSION' );
		$shipping = WExtension::get( 'shipping.node' );
		if ( !empty($useDimension) && !empty($shipping) ) {
						$getDimUnit = WGlobals::getSession( 'dimensionUnit', 'unit' );

			if ( empty($getDimUnit) ) {
				$getDimUnit = WPref::load( 'PPRODUCT_NODE_DIMENSIONUNIT' );
				WGlobals::setSession( 'dimensionUnit', 'unit', $getDimUnit );
			}
		}

						$allFieldsA = array();
		foreach( $this as $oneKey => $oneParam ) {
			$expA = explode( '_', $oneKey );
			if ( count($expA) < 2 ) continue;

			$typeField = array_shift($expA);
			$nameField = implode( '_', $expA );
			if ( 'search' == $typeField ) {
				if ( !isset($allFieldsA[$nameField]) ) $allFieldsA[$nameField] = new stdClass;
				$allFieldsA[$nameField]->search = $oneParam;
			}			if ( 'source' == $typeField ) {
				if ( !isset($allFieldsA[$nameField]) ) $allFieldsA[$nameField] = new stdClass;
				$allFieldsA[$nameField]->source = $oneParam;
			}
			if ( 'ordering' == $typeField ) {
				if ( !isset($allFieldsA[$nameField]) ) $allFieldsA[$nameField] = new stdClass;
				$allFieldsA[$nameField]->ordering = $oneParam;
			}		}


		if ( empty($allFieldsA) ) return '';

		$newFieldsA = array();
				foreach( $allFieldsA as $nameField => $oneField ) {
			if ( empty($oneField->search) ) continue;
			if ( empty($oneField->ordering) ) $oneField->ordering = 9999;

			$newOrdering = $oneField->ordering * 1000;
			if ( !isset($newFieldsA[$newOrdering]) ) {
				$newFieldsA[$newOrdering] = $nameField;
			} else {
				$this->_checkExists( $newFieldsA, $newOrdering );
				$newFieldsA[$newOrdering] = $nameField;
			}
		}
		ksort( $newFieldsA );

				$elementToLoadA = $this->_loadFieldsInformation( $newFieldsA, $allFieldsA, 'custom' );
		$this->_loadCustomFieldsInformation( $elementToLoadA, false );

		if ( WExtension::exist( 'vendors.node' ) ) {
						$elementToLoadA = $this->_loadFieldsInformation( $newFieldsA, $allFieldsA, 'vendors' );
			$this->_loadCustomFieldsInformation( $elementToLoadA, true );
		}

		$HTML = '';
		WLoadFile( 'output.doc.document' );
				foreach( $newFieldsA as $oneField ) {
			$oneFilter = $this->_createFilterElement( $oneField, $allFieldsA[$oneField] );

			if ( empty($oneFilter->typeName) ) continue;
			$columnInstance = Output_Doc_Document::loadListingElement( $oneFilter );
			if ( empty($columnInstance) ) continue;
			$task = WGlobals::get( 'task' );
			if ( 'category' != $task ) $task = '';

			$memory = 'advCatalog';
			$status = $columnInstance->advanceSearchLinks( $memory, 'advCtlg_val_', 'catalog', $task );
			if ( empty($status) ) continue;

			if ( !empty($oneFilter->combined) ) continue;
			$content = $columnInstance->content;
			if ( empty($content) ) continue;


			$HTML .= '<div class="clearfix">';
			$HTML .= '<fieldset class="advSearchFilter">';
			if ( empty($this->seeall) ) {
				$HTML .= '<h5>' . $oneFilter->name . '</h5>';
			} else {
				$linkText = WPage::createPopUpLink( WPages::linkPopUp('controller=catalog-filter'), WText::t('1412810070CKJS'), '80%', '80%' );
				$HTML .= '<div class="clearfix"><div style="float:left;"><h5>' . $oneFilter->name . '</h5></div><div style="float:right;padding-top:10px;">' . $linkText . '</div></div>';
			}
			$HTML .= $content;
			$HTML .= '</fieldset>';
			$HTML .= '</div>';

		}
		$this->content = '<div class="advSearchFrame">';
		$this->content .= $HTML;
		$this->content .= '</div>';


	}









	private function _loadCustomFieldsInformation($elementToLoadA,$vendors=false) {

		if ( empty($elementToLoadA) ) return false;

		if ( $vendors ) {
			$dbtid = WModel::get( 'vendors', 'dbtid' );
			$PorpertyType = '_vendorsFieldInfoA';
			$variable = & $this->$PorpertyType;

			foreach( $elementToLoadA as $vkey => $oneVal ) {
				switch( $oneVal ) {
					case 'vendors_name':
						$oneField = new stdClass;
						$oneField->column = 'name';
						$oneField->name = WText::t('1418425899SRHO');
						$oneField->listing = 'output.text';
						$oneField->namekey = 'vendors_name';
						$oneField->params = '';
						$variable[$oneField->namekey] = $oneField;
						unset( $elementToLoadA[$vkey] );
						break;
					case 'vendors_badge':
						$oneField = new stdClass;
						$oneField->column = 'badge';
						$oneField->name = WText::t('1418425899SRHP');
						$oneField->listing = 'output.selectone';
						$oneField->namekey = 'vendors_badge';
						$oneField->params = 'selectdid=' . WView::picklist( 'vendors_badge', '', null, 'did' ) . '
selectype=3
selectstyle=21';
						$variable[$oneField->namekey] = $oneField;
						unset( $elementToLoadA[$vkey] );
						break;
					default:
						break;
				}
			}
			if ( empty($elementToLoadA) ) return false;

		} else {
			$dbtid = WModel::get( 'item', 'dbtid' );
			$PorpertyType = '_customFieldInfoA';
		}
		$designViewfieldsM = WModel::get( 'design.modelfields' );
		$designViewfieldsM->makeLJ( 'library.model', 'sid', 'sid', 0, 1 );
		$designViewfieldsM->makeLJ( 'library.table', 'dbtid', 'dbtid', 1, 2 );
		$designViewfieldsM->whereE( 'advsearchable', 1, 0 );
		$designViewfieldsM->whereE( 'publish', 1, 0 );
		$designViewfieldsM->whereIn( 'column', $elementToLoadA, 0 );
		$designViewfieldsM->whereE( 'dbtid', $dbtid, 2 );
		$designViewfieldsM->makeLJ( 'design.modelfieldstrans', 'fdid', 'fdid', 0, 3 );
		$designViewfieldsM->whereLanguage( 3 );
		$designViewfieldsM->makeLJ( 'design.fields', 'fieldid', 'fieldid', 0, 4 );

		if ( $this->_smartfilter && !$vendors ) {
			$allCurrentTypesA = array();
						$type = WGlobals::get( 'type' );
			if ( empty($type) ) {
				$prodtypid = WGlobals::get( 'prodtypid' );
				if ( !empty($prodtypid) ) $allCurrentTypesA[] = $prodtypid;
			} else {
								$productTypeM = WModel::get( 'item.type' );
				$productTypeM->whereE( 'type', $type );
				$productTypeM->whereE( 'publish', 1 );
				$productTypeM->whereE( 'searchable', 1 );
				$productTypeM->checkAccess();
				$allCurrentTypesA = $productTypeM->load( 'lra', 'prodtypid' );
			}
			if ( !empty( $allCurrentTypesA ) ) {
				$designViewfieldsM->makeLJ( 'design.modelfieldstype', 'fdid', 'fdid', 0, 5 );
				$designViewfieldsM->whereIn( 'typeid', $allCurrentTypesA, 5 );
				$designViewfieldsM->groupBy( 'fdid' );
			}
		}

		$designViewfieldsM->select( array( 'column', 'namekey', 'params' ), 0 );
		$designViewfieldsM->select( 'name', 3 );
		$designViewfieldsM->select( 'listing', 4 );

		$customFieldInfoA = $designViewfieldsM->load( 'ol' );

		if ( empty($customFieldInfoA) ) return false;

		foreach( $customFieldInfoA as $oneField ) {
			$variable = & $this->$PorpertyType;
			$variable[$oneField->column] = $oneField;
		}
	}








	private function _loadFieldsInformation($newFieldsA,$allFieldsA,$typeSearched='custom') {

		$customElementsA = array();
		foreach( $newFieldsA as $oneField ) {
			$element = $allFieldsA[$oneField];
			if ( !empty($element->source) && $typeSearched == $element->source ) {
				$customElementsA[] = $oneField;
			}		}
		return $customElementsA;

	}







	private function _createFilterElement($oneField,$element) {
		static $id = 0;
		if ( empty($element->source) ) $element->source = 'standard';
		$id++;
		$newElementO = new stdClass;
		$newElementO->lid = 'catalog_advancesearch_module_' . $id;
		switch( $element->source ) {
			case 'custom':
				if ( !empty($this->_customFieldInfoA[$oneField]) ) {
					$newElementO->name = $this->_customFieldInfoA[$oneField]->name;
					$newElementO->type = $this->_customFieldInfoA[$oneField]->listing;
					$typeExplodedA = explode( '.', $newElementO->type );
					$newElementO->typeNode = $typeExplodedA[0];
					$newElementO->typeName = $typeExplodedA[1];
					$newElementO->modelID = WModel::get( 'item', 'sid' );
					$newElementO->column = $oneField;						$newElementO->map = 'itmsrch[' . $oneField . ']';						$newElementO->params = $this->_customFieldInfoA[$oneField]->params;
					if ( !empty($newElementO->params) ) WTools::getParams( $newElementO );
				}			case 'vendors':

				if ( !empty($this->_vendorsFieldInfoA[$oneField]) ) {

					$defautlVendorFieldsA = array( 'vendors_name', 'vendors_badge' );
					if ( in_array( $oneField, $defautlVendorFieldsA ) ) {
						if ( $oneField == 'vendors_name' ) {
							$newElementO->modelID = WModel::get( 'vendortrans', 'sid' );
						} else {
							$newElementO->modelID = WModel::get( 'vendor', 'sid' );
						}						$newElementO->column = substr( $oneField, 8 );						} else {
						$newElementO->modelID = WModel::get( 'vendor', 'sid' );
						$newElementO->column = $oneField;						}
					$newElementO->name = $this->_vendorsFieldInfoA[$oneField]->name;
					$newElementO->type = $this->_vendorsFieldInfoA[$oneField]->listing;
					$typeExplodedA = explode( '.', $newElementO->type );
					$newElementO->typeNode = $typeExplodedA[0];
					$newElementO->typeName = $typeExplodedA[1];
					$newElementO->map = 'itmsrch[' . $oneField . ']';						$newElementO->params = $this->_vendorsFieldInfoA[$oneField]->params;
					if ( !empty($newElementO->params) ) WTools::getParams( $newElementO );
				}
				break;
			case 'attribute':
				$explodeOPIDA = explode( '_', $oneField );
				$productOptionM = WModel::get( 'product.option' );
				$optionO = $productOptionM->loadMemory( $explodeOPIDA[1] );

				$newElementO->name = ( !empty($optionO->name) ? $optionO->name : $optionO->namekey );
				$newElementO->type = 'product.option';
				$newElementO->typeNode = 'product';
				$newElementO->typeName = 'option';
				$newElementO->modelID = WModel::get( 'product.optionvalues', 'sid' );
				$newElementO->column = $oneField;					$newElementO->map = 'optionsrch[' . $oneField . ']';	
				break;
			case 'standard':
			default:
				switch( $oneField ) {
					case 'name':
						$newElementO->name = WText::t('1206732392OZVB');
						$newElementO->typeName = 'text';
						$newElementO->typeNode = 'output';
						$newElementO->type = 'ouput.text';
						$newElementO->modelID = WModel::get( 'itemtrans', 'sid' );
						$newElementO->column = 'name';
						break;
					case 'introduction':
						$newElementO->name = WText::t('1206732392OZVB');
						$newElementO->typeName = 'text';
						$newElementO->typeNode = 'output';
						$newElementO->type = 'ouput.text';
						$newElementO->modelID = WModel::get( 'itemtrans', 'sid' );
						$newElementO->column = 'introduction';
						$newElementO->combined = 'name';
												break;
					case 'description':
						$newElementO->name = WText::t('1206732392OZVB');
						$newElementO->typeName = 'text';
						$newElementO->typeNode = 'output';
						$newElementO->type = 'ouput.text';
						$newElementO->modelID = WModel::get( 'itemtrans', 'sid' );
						$newElementO->column = 'description';
						$newElementO->combined = 'name';
												break;
					case 'price':
						$newElementO->name = WText::t('1206961911NYAN');
						$newElementO->typeName = 'moneycurrency';
						$newElementO->typeNode = 'main';
						$newElementO->type = 'main.moneycurrency';
						$newElementO->modelID = WModel::get( 'item', 'sid' );
						$newElementO->column = 'price';
						break;




					case 'unit':
						$newElementO->name = WText::t('1404917848OWCY');
						$newElementO->typeName = 'unit';
						$newElementO->typeNode = 'shipping';
						$newElementO->type = 'shipping.unit';
						$newElementO->modelID = 0;
						$newElementO->column = $oneField;
						$newElementO->did = 'shipping_dimension_unit';
						$newElementO->map = 'unit';
						$newElementO->task = 'home';
						break;

					case 'length':
						$newElementO->name = WText::t('1404917846GHCU');
						$newElementO->typeName = 'dimension';
						$newElementO->typeNode = 'shipping';
						$newElementO->type = 'shipping.dimension';
						$newElementO->modelID = WModel::get( 'item', 'sid' );
						$newElementO->column = $oneField;
						break;

					case 'width':
						$newElementO->name = WText::t('1206961870KLAD');
						$newElementO->typeName = 'dimension';
						$newElementO->typeNode = 'shipping';
						$newElementO->type = 'shipping.dimension';
						$newElementO->modelID = WModel::get( 'item', 'sid' );
						$newElementO->column = $oneField;
						break;
					case 'height':
						$newElementO->name = WText::t('1206961870KLAF');
						$newElementO->typeName = 'dimension';
						$newElementO->typeNode = 'shipping';
						$newElementO->type = 'shipping.dimension';
						$newElementO->modelID = WModel::get( 'item', 'sid' );
						$newElementO->column = $oneField;
						break;

					default:
						return false;
						break;
				}				break;
		}
		return $newElementO;

	}







	private function _checkExists($newFieldsA,&$newOrdering) {
		$newOrdering++;
		if ( isset($newFieldsA[$newOrdering]) ) $this->_checkExists( $newFieldsA, $newOrdering );
		return $newOrdering;
	}
}