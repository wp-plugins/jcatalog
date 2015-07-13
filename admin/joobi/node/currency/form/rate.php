<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Currency_Corerate_form extends WForms_default {
	




	function create() {

		if ( !defined('CURRENCY_USED') ) {
			$currencyFormatC = WClass::get('currency.format',null,'class',false);
			$currencyFormatC->set();
		}		$fprice = WClass::get('currency.format',null,'class',false);
		$this->content = '<input class="form control" id="' . $this->idLabel . '" name="' . $this->map . '" size="7" value="' . $fprice->regionalize($this->value) . '" type="text"';
		if ($this->eid == CURRENCY_USED ){
			$this->content .= 'class="disabled" DISABLED>';
			$this->content .= WText::t('1206961945HIVU');
		} else {
			$this->content .= 'class="inputbox">';
			$this->content .=  $fprice->display(1).WText::t('1206961945HIVV');
		}

		return true;
	}

}