<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Email_CoreTag_form extends WForms_default {

	private static $_pregMatch=null;









function create(){



	
	if( empty($this->value)){

		return true;

	}

	$this->content=str_replace( array( "\n" ), '<br/>', $this->value );
	return true;

















}










function show(){

	$this->create();

	return true;

}}