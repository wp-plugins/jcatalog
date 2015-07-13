<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreEnddate_form extends WForms_default {
function show()

{

	if ($this->value > 0) $this->content = WApplication::date( WTools::dateFormat( 'date' ), $this->value );

	else $this->content = '<span style="color:red;">'. WText::t('1237967968ABUO') .'</span>';

	return true;

}}