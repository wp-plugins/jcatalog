<?php 

* @link joobi.co
* @license GNU GPLv3 */







WView::includeElement( 'form.datetime' );
class Main_Corecurrenttime_form extends WForm_datetime {

	function show() {
		$this->value = time() - WUser::timezone();
		return parent::show();
	}
}