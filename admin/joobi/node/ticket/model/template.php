<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Ticket_Template_model extends WModel {

function validate(){



	if ( empty($this->tktypeid) ) {

		$this->tktypeid = 110;			
	}
	return true;


}}