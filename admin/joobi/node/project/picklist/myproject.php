<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



 class Project_Myproject_picklist extends WPicklist {









	function create(){



		$user = WUser::get('uid');

		$this->addElement( $user , 'My project' );



	}




 }






