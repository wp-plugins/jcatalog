<?php 

* @link joobi.co
* @license GNU GPLv3 */
















WView::includeElement( 'form.yesno' );
class WForm_private extends WForm_yesno {

		protected $defaultValues = array(  1, 0 );
	protected $defaultImages = array( 'lock', 'unlock' );
	protected $defaultLabel = array();




	function create() {
		$yes = WText::t('1206732412DACF');
		$no = WText::t('1240888718QMAD');
		$this->defaultLabel = array( $yes, $no );
		return parent::create();

	}





	function show() {
		$yes = WText::t('1206732412DACF');
		$no = WText::t('1240888718QMAD');
		$this->defaultLabel = array( $yes, $no );
		return parent::show();
	}


}
