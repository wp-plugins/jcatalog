<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.datetime' );
class Scheduler_Yourtime_form extends WForm_datetime {
function show(){

	$this->value=time();

	return parent::show();

}}