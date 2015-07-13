<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_logs_delete_controller extends WController {



function delete(){





	$FILE=WGlobals::get('file');  
	$fileClass=WGet::file();     


	if(is_string($FILE) && !empty($FILE)){

		if($fileClass->delete(JOOBI_DS_USER.'logs'.DS.$FILE)){

			$mess=WMessage::get();

			$mess->userS('1260434893HJHR',array('$FILE'=>$FILE));

		}

	}
	

	WPages::redirect('controller=apps-logs&task=listing');           
	return true;



}

}