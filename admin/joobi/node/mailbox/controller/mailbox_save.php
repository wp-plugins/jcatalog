<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_save_controller extends WController {
	





	function save() {



		
		parent::save();



		
		$inbid=$this->_model->inbid;



		
		$this->adminN('You can now proceed on assigning of plugin to the mailbox');

		WPages::redirect('controller=mailbox-plugin&inbid='.$inbid);



   	return true;



	}}