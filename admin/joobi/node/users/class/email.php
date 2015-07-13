<?php 

* @link joobi.co
* @license GNU GPLv3 */





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