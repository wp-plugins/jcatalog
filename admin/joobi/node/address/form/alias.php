<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.text' );
class Address_Alias_form extends WForm_text {
function create() {



if ( empty($this->value) ) $this->value = WText::t('1337272977SYNA');





return parent::create();



}
}