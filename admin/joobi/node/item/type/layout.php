<?php 

* @link joobi.co
* @license GNU GPLv3 */





class Item_Layout_type extends WTypes {

	public $layout = array(
		'' => 'Default',
		'badge' => 'Grid View',			'badgebig' => 'List View',			'badgemini' => 'Mini View',			'table' => 'Table View'		 );






	protected function translatedType() {

		$typeA = array();
		$typeA[''] = WText::t('1206732425HINT');
		$typeA['badge'] = WText::t('1397153428MYNF');
		$typeA['badgebig'] = WText::t('1397153428MYNG');
		$typeA['badgemini'] = WText::t('1397153428MYNH');
		$typeA['table'] = WText::t('1397153428MYNI');

		return $typeA;

	}
}