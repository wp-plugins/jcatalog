<?php 

* @link joobi.co
* @license GNU GPLv3 */

















WView::includeElement( 'form.text' );
class WForm_Coreminutes extends WForm_text {





	function create() {
				if ( empty( $this->element->width ) ) $this->element->width = 6;

		$this->value = $this->value / 60;

		$this->addPostText = WText::t('1206732357ILFM');

		return parent::create();

	}




	function show() {
		$this->value = $this->value / 60;
		$status = parent::show();
		$this->content .= ' ' . WText::t('1206732357ILFM');
		return $status;

	}
}
