<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_CoreTermtype_listing extends WListings_default{
function create() {

	if ($this->value == 1) $this->content = WText::t('1206732400OWZK');

	elseif ($this->value == 2) $this->content = WText::t('1341596519RVAQ');

	elseif ($this->value == 3) $this->content = WText::t('1311845275JGPO');

	else $this->content = WText::t('1341596519RVAR');

	

	return true;

}}