<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.select' );
class Catalog_CoreSearchlocation_form extends WForm_select {

	function create() {



		parent::create();

		$picklist = '<div class="searchLocationPicklist">' . $this->content . '</div>';



		$name = 'location';

		$searchItem = WForm::getPrev( 'x['.$name.']' );

		if ( empty($searchItem) ) {

			$trucs = WGlobals::get( 'trucs' );

			if (!empty($trucs['x'][$name]) ) $searchItem = $trucs['x'][$name];

		}


		if ( empty($searchItem) ) {

			$searchItem = WText::t('1375896154QSFL');

			$extraJS = ' onfocus="if (this.value==\''.$searchItem.'\') this.value=\'\';" onblur="if (this.value==\'\') this.value=\''.$searchItem.'\';"';

		} else {

			$extraJS = '';

		}


		$this->content = '<div class="searchLocationBox"><input id="wz_search_location"' . $extraJS. ' class="form-control inputbox" type="text" value="'.$searchItem.'" name="trucs[x][location]"></div>';

		$this->content .= '' . $picklist;



		return true;



	}
}