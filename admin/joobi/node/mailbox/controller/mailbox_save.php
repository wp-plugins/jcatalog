<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Mailbox_save_controller extends WController {
	





	function save() {



		
		parent::save();



		
		$inbid=$this->_model->inbid;



		
		$this->adminN('You can now proceed on assigning of plugin to the mailbox');

		WPages::redirect('controller=mailbox-plugin&inbid='.$inbid);



   	return true;



	}}