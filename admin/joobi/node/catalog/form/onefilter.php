<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Onefilter_form extends WForms_default {


	function create() {



		$allFieldsA = array();



		WLoadFile( 'output.doc.document', JOOBI_DS_NODE );



		$elementO = new stdClass;

		$elementO->source = ( !empty( $this->element->item->initial ) ? $this->element->item->initial : 'standard' );



		$oneFilter = $this->element;



		$map = $this->element->newMap;






		$oneListingO = $this->_createFilterElement( $map, $elementO );	


		$columnInstance = Output_Doc_Document::loadListingElement( $oneListingO );

		if ( empty($columnInstance) ) return false;

		$task = WGlobals::get( 'task' );

		if ( 'category' != $task ) $task = '';



		$memory = 'advCatalog';

		$status = $columnInstance->advanceSearchLinks( $memory, 'advCtlg_val_', 'catalog', $task );

		if ( empty($status) ) return false;



		if ( !empty($oneFilter->combined) ) return false;

		$this->content = $columnInstance->content;



		if ( empty($this->content) ) return false;



		return true;



	}


















	private function _createFilterElement($oneField,$element) {

		static $id = 0;

		if ( empty($element->source) ) $element->source = 'standard';



		$id++;

		$newElementO = new stdClass;

		$newElementO->lid = 'catalog_advancesearch_module_' . $id;



		switch ( $element->source ) {

			case 'custom':
				$infoA = Catalog_Catalog_filter_form_view::$customFieldInfoA;

				if ( !empty($infoA[$oneField]) ) {

					$newElementO->name = $infoA[$oneField]->name;

					$newElementO->type = $infoA[$oneField]->listing;

					$typeExplodedA = explode( '.', $newElementO->type );

					$newElementO->typeNode = $typeExplodedA[0];

					$newElementO->typeName = $typeExplodedA[1];

					$newElementO->modelID = WModel::get( 'item', 'sid' );

					$newElementO->column = $oneField;	
					$newElementO->map = 'itmsrch[' . $oneField . ']';	
					$newElementO->params = $infoA[$oneField]->params;

					if ( !empty($newElementO->params) ) WTools::getParams( $newElementO );

				}
			case 'vendors':
				$infoA = Catalog_Catalog_filter_form_view::$vendorsFieldInfoA;

				if ( !empty($infoA[$oneField]) ) {

					$newElementO->name = $infoA[$oneField]->name;

					$newElementO->type = $infoA[$oneField]->listing;

					$typeExplodedA = explode( '.', $newElementO->type );

					$newElementO->typeNode = $typeExplodedA[0];

					$newElementO->typeName = $typeExplodedA[1];

					$newElementO->modelID = WModel::get( 'vendor', 'sid' );

					$newElementO->column = $oneField;	
					$newElementO->map = 'itmsrch[' . $oneField . ']';	
					$newElementO->params = $infoA[$oneField]->params;

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

				switch ( $oneField ) {

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

				}
				break;

		}





		return $newElementO;



	}

}