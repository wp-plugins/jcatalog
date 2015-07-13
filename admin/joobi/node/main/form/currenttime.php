<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






WView::includeElement( 'form.datetime' );
class Main_Corecurrenttime_form extends WForm_datetime {

	function show() {
		$this->value = time() - WUser::timezone();
		return parent::show();
	}
}