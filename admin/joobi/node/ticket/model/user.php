<?php 

* @link joobi.co
* @license GNU GPLv3 */







WLoadFile( 'users.model.node');
class Ticket_User_model extends Users_Node_model {




function addValidate(){


	$this->username = trim( $this->username );

	
	$this->rolid = WRole::getRole( 'visitor' );



	
	$this->setProcessConfirmation(false);



	return parent::addValidate();


}





}