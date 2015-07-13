<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Output_Output_params_form_output_select_view extends Output_Forms_class {
function prepareView(){

	WGlobals::set( 'Main_Output_params_form_selectype', $this->getValue('selectype'), 'global' );



	return true;



}}