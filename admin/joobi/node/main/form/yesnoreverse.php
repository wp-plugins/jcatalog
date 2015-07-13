<?php 

* @link joobi.co
* @license GNU GPLv3 */
















WView::includeElement( 'form.yesno' );
class WForm_yesnoreverse extends WForm_yesno {

		protected $defaultValues = array(  0, 1 );
	protected $defaultImages = array( 'cancel', 'yes' );
	protected $defaultLabel = array();




	function create() {

		$this->defaultImages = array( 'cancel', 'yes' );

		$yes = WText::t('1206732372QTKI');
		$no = WText::t('1206732372QTKJ');

		$this->defaultLabel = array( $no, $yes );
		return parent::create();

	}





	function show() {
		$this->defaultImages = array( 'cancel', 'yes' );
		$yes = WText::t('1206732372QTKI');
		$no = WText::t('1206732372QTKJ');
		$this->defaultLabel = array( $no, $yes );
		return parent::show();
	}


}
