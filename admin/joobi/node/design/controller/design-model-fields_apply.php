<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Design_model_fields_apply_controller extends WController {
function apply() {



	$status = parent::apply();



	$extensionHelperC = WCache::get();

	$extensionHelperC->resetCache( 'Views' );


	$eid = WGlobals::getEID();

	WPages::redirect( 'controller=design-model-fields&task=edit&eid=' . $eid );


	return $status;



}}