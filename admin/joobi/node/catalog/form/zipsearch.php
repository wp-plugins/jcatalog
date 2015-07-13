<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.text' );
class Catalog_Zipsearch_form extends WForm_text {

	function create() {



	


		if ( empty($this->value) ) {

			$this->value = WText::t('1398702488PGTJ');

			$this->extras = ' onblur="if (this.value==\'\') this.value=\'' . $this->value .'\';" onfocus="if (this.value==\'' . $this->value .'\') this.value=\'\';"';

		}




		return parent::create();



	}
}