<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




 class Users_Email_class extends WClasses {








 	function validateEmail($email,$fullCheck=true){

 		if( !filter_var( $email, FILTER_VALIDATE_EMAIL )){

	 			 		if( !preg_match('/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@([a-z0-9\-]+\.)+[a-z0-9]{2,7}$/i', $email)) return false;
 		}

 		 		if($fullCheck){
			 	 		 						list( $user, $domain )=explode( '@', $email );

																		if( function_exists('checkdnsrr') && !checkdnsrr( $domain.'.', 'MX' )){
				return false;
			}
									
 		}
 		return true;

 	}
}