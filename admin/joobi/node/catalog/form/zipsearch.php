<?php 

* @link joobi.co
* @license GNU GPLv3 */



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