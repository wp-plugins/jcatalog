<?php 

* @link joobi.co
* @license GNU GPLv3 */


class Item_CoreProductrelated_form extends WForms_default {

function create() {


	if ( !empty($this->data->prdgeneral) ) return false;



	$text = '<span style="color:red;font-weight:bold;">' . WText::t('1418159973LMLX') . '</span>';



	$this->content = $text;



	return true;



}



function show() {

	return $this->create();

}
}