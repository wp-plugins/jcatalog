<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Email_toggle_controller extends WController {
function toggle(){




	$extensionHelperC=WCache::get();

	$extensionHelperC->resetCache( 'Model_mailing_node' );	
		

	$status=parent::toggle();

		

	return $status;

	

}}