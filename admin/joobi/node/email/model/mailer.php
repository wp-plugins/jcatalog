<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Email_Mailer_model extends WModel {

	function validate(){



		
		if( $this->type < 100){

			$this->designation=1;

		}elseif( $this->type > 100){

			$this->designation=2;

		}


		return true;



	}
}