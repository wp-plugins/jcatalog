<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_Credential_model extends WModel {
function validate() {



	if ( !empty( $this->crdidtype ) ) $this->type = $this->crdidtype;



	return true;

	

}}