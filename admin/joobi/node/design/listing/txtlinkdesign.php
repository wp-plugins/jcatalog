<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Design_CoreTxtlinkdesign_listing extends WListings_default{
function create() {

$this->content = WText::t('1355852601LJIH') . ' ( '.$this->value.' )';

return true;

}}