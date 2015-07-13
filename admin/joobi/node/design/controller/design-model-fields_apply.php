<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_model_fields_apply_controller extends WController {
function apply() {



	$status = parent::apply();



	$extensionHelperC = WCache::get();

	$extensionHelperC->resetCache( 'Views' );


	$eid = WGlobals::getEID();

	WPages::redirect( 'controller=design-model-fields&task=edit&eid=' . $eid );


	return $status;



}}