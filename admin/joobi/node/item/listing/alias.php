<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_CoreAlias_listing extends WListings_default{
function create() {

if ( empty($this->value) ) $this->value = $this->getValue('name', 'files') . '.' . $this->getValue('type');

return parent::create();

}}