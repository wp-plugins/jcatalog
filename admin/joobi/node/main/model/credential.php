<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Credential_model extends WModel {
function validate() {



	if ( !empty( $this->crdidtype ) ) $this->type = $this->crdidtype;



	return true;

	

}}