<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_CoreProductbundletype_form extends WForms_default {
function create() {



	if ( !empty($this->data->bdlgeneral) ) return false;

	

	$text = '<span style="color:red;font-weight:bold;">' . WText::t('1418159973LMLW') . '</span>';


	

	$this->content = $text;



return true;



}


function show() {

return $this->create();

}}