<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Advsearch_class extends WClasses {


	private $_parentFieldsStandard = 0;
	private $_parentFieldsCustom = 0;
	private $_parentFieldsAttributes = 0;
	private $_parentFieldsVendors = 0;
	private $_parentFieldsVendorsCustom = 0;


	private $_defautlValuesA = array();


	public function getAllModulDefault() {

		return $this->_defautlValuesA;

	}







	public function setProp($prop,$value) {
		$this->$prop = $value;
	}




	public function getAllAdvSearch($addName=false) {

		if ( $addName ) {
						$fieldname = 'name';
			$NAME = WText::t('1206732392OZVB');
						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );
		}
				$fieldname = 'price';
		$NAME = WText::t('1206961911NYAN');
				$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );

		$fieldname = 'stock';
		$NAME = WText::t('1206961996STAE');
				$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );

		$useDimension = WPref::load( 'PPRODUCT_NODE_USEDIMENSION' );
		$shipping = WExtension::get( 'shipping.node' );
		if ( !empty($useDimension) && !empty($shipping) ) {

			$fieldname = 'unit';
			$NAME = WText::t('1404917846GHCT');
						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );


			$fieldname = 'length';
			$NAME = WText::t('1404917846GHCU');
						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );

			$fieldname = 'width';
			$NAME = WText::t('1206961870KLAD');
						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );

			$fieldname = 'height';
			$NAME = WText::t('1206961870KLAF');
						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsStandard, 'standard' );

		}

				$this->_addCustomFields();

				$this->_addAttributesFields();


				if ( WExtension::exist( 'vendors.node' ) ) {
						$fieldname = 'vendors_badge';
			$NAME = WText::t('1228709711HLFW');

						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsVendors, 'vendors' );

			$fieldname = 'vendors_name';
			$NAME = WText::t('1298507271ARKT');

						$this->_addElement( $fieldname, $NAME, $this->_parentFieldsVendors, 'vendors' );

						$this->_addCustomFields( true );

		}
		return $this->elements;


	}






	private function _addAttributesFields() {


						$designViewfieldsM = WModel::get( 'product.option' );
		$designViewfieldsM->makeLJ( 'product.optiontrans', 'opid' );
		$designViewfieldsM->whereLanguage();
		$designViewfieldsM->whereE( 'publish', 1 );
		$designViewfieldsM->select( 'opid', 0, 'column' );
		$designViewfieldsM->select( 'name', 1 );
		$designViewfieldsM->orderBy( 'ordering', 'ASC' );
		$allFieldsA = $designViewfieldsM->load( 'ol' );

		if ( !empty( $allFieldsA ) ) {
			foreach( $allFieldsA as $oneField ) {
				$this->_addElement( 'attrib_' . $oneField->column, $oneField->name, $this->_parentFieldsAttributes, 'attribute' );
			}		}

	}





	private function _addCustomFields($vendors=false) {

		if ( $vendors ) {
			$dbtid = WModel::get( 'vendors', 'dbtid' );
			$type = 'vendors';
			$parent = $this->_parentFieldsVendorsCustom;
		} else {
			$dbtid = WModel::get( 'item', 'dbtid' );
			$type = 'custom';
			$parent = $this->_parentFieldsCustom;
		}

						$designViewfieldsM = WModel::get( 'design.modelfields' );
		$designViewfieldsM->makeLJ( 'library.model', 'sid', 'sid', 0, 1 );
		$designViewfieldsM->makeLJ( 'library.table', 'dbtid', 'dbtid', 1, 2 );
		$designViewfieldsM->whereE( 'advsearchable', 1, 0 );
		$designViewfieldsM->whereE( 'publish', 1, 0 );
		$designViewfieldsM->whereE( 'dbtid', $dbtid, 2 );
		$designViewfieldsM->makeLJ( 'design.modelfieldstrans', 'fdid', 'fdid', 0, 3 );
		$designViewfieldsM->whereLanguage( 3 );
		$designViewfieldsM->select( 'column', 0 );
		$designViewfieldsM->select( 'name', 3 );
		$allFieldsA = $designViewfieldsM->load( 'ol' );


		if ( !empty( $allFieldsA ) ) {
			foreach( $allFieldsA as $oneField ) {
				$this->_addElement( $oneField->column, $oneField->name, $parent, $type );
			}		}

	}








	private function _addElement($fieldname,$NAME,$parent=0,$source='standard') {
		static $count = 0;
		static $initialValue = 0;

		$count++;
		$elementO = new stdClass;
		$elementO->name = $NAME;
		$elementO->description = str_replace(array('$NAME'), array($NAME),WText::t('1382068739BXVL'));
		$elementO->fid = 10000000 + $count;
		$map = 'search_' . $fieldname;
		$elementO->map = 'p[' . $map . ']';
		$elementO->namekey = 'catalog_advancesearch_module_' . $map;
		$elementO->type = 'output.yesno';
		$elementO->rolid = 1;
		$elementO->sid = WModel::get( 'main.widget', 'sid' );
		$elementO->parent = $parent;
		$elementO->area = '';
		$elementO->frame = 0;
		$elementO->ref_yid = 0;
		$elementO->readonly = 0;
		$elementO->hidden = 0;
		$elementO->required = 0;
		$elementO->private = 0;
		$elementO->params = 0;
		$elementO->level = 0;
		$elementO->initial = '';
		$elementO->checktype = 0;
		$elementO->fdid = 0;
		$elementO->typeNode = 'output';
		$elementO->typeName = 'yesno';

		$this->elements[] = $elementO;

		$count++;
		$elementO = new stdClass;
		$elementO->name = str_replace(array('$NAME'), array($NAME),WText::t('1382068739BXVM'));
		$elementO->description = WText::t('1382068739BXVN');
		$elementO->fid = 10000000 + $count;
		$map = 'ordering_' . $fieldname;
		$elementO->map = 'p[' . $map . ']';
		$elementO->namekey = 'catalog_advancesearch_module_' . $map;
		$elementO->type = 'output.text';
		$elementO->rolid = 1;
		$elementO->sid = WModel::get( 'main.widget', 'sid' );
		$elementO->parent = $parent;
		$elementO->area = '';
		$elementO->frame = 0;
		$elementO->ref_yid = 0;
		$elementO->readonly = 0;
		$elementO->hidden = 0;
		$elementO->required = 0;
		$elementO->private = 0;
		$elementO->params = 'width=3';
		$elementO->level = 0;
		$elementO->initial = '';
		$elementO->checktype = 0;
		$elementO->fdid = 0;
		$elementO->typeNode = 'output';
		$elementO->typeName = 'text';

				$initialValue++;
		if ( empty($this->_defautlValuesA[$map]) ) {
			$this->_defautlValuesA[$map] = $initialValue;
		}
		$this->elements[] = $elementO;


		$initial = $source;

		$count++;
		$elementO = new stdClass;
		$elementO->name = $NAME;
		$elementO->description = '';
		$elementO->fid = 10000000 + $count;
		$map = 'source_' . $fieldname;
		$elementO->map = 'p[' . $map . ']';
		$elementO->namekey = 'catalog_advancesearch_module_' . $map;
		$elementO->type = 'output.text';
		$elementO->rolid = 1;
		$elementO->sid = WModel::get( 'main.widget', 'sid' );
		$elementO->parent = $parent;
		$elementO->area = '';
		$elementO->frame = 0;
		$elementO->ref_yid = 0;
		$elementO->readonly = 0;
		$elementO->hidden = 1;
		$elementO->required = 0;
		$elementO->private = 0;
		$elementO->params = '';
		$elementO->level = 0;
		$elementO->initial = $initial;
		$elementO->checktype = 0;
		$elementO->fdid = 0;
		$elementO->typeNode = 'output';
		$elementO->typeName = 'text';

				$initialValue++;
		if ( empty($this->_defautlValuesA[$map]) ) $this->_defautlValuesA[$map] = $source;

		$this->elements[] = $elementO;


	}

}