<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.text' );
class WForm_Coredays extends WForm_text {





	function create() {
				if ( empty( $this->element->width ) ) $this->element->width = 3;

		$this->value = $this->value / 86400;

		$this->addPostText = WText::t('1206732357ILFK');

		return parent::create();

	}




	function show() {
		$this->value = $this->value / 86400;
		$status = parent::show();
		$this->content .= ' ' . WText::t('1206732357ILFK');
		return $status;
	}
}

