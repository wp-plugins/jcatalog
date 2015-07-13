<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_CoreTxtlinkdesign_listing extends WListings_default{
function create() {

$this->content = WText::t('1355852601LJIH') . ' ( '.$this->value.' )';

return true;

}}