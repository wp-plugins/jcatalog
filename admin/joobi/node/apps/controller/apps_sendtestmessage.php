<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_sendtestmessage_controller extends WController {














	function sendtestmessage(){

		$emailExist=WExtension::exist( 'email.node' );
		if( !$emailExist ) return true;


		$emailI=WMail::get();

		$user=WUser::get();

		if( !$emailI->sendNow( $user, 'main_test_email' )){

			
			
			$this->_checkError();

		}

		return true;


	}










	private function _checkError(){


		$mailPref=WPref::get('email.node');

		if( $mailPref->getPref('mailer')=='smtp'){

			
			if( !$mailPref->getPref('smtp_auth_required') && strlen($mailPref->getPref('smtp_password')) >1){

				$this->adminW('You use the SMTP method with a password but you did no require the authentication... you may try to turn the SMTP authentication ON',array(),0);

				return;

			}



			
			if($mailPref->getPref('senderemail') !=$mailPref->getPref('smtp_username')){

				$this->adminW('You use the SMTP method but your bounce address is different than your SMTP username... in most of cases those two addresses should be the same',array(),0);

				return;

			}



		}else{


			
			$BOUNCE=$mailPref->getPref( 'senderemail' );

			if( !empty($BOUNCE)){

				$usersEmail=WClass::get('users.email');
				if( $usersEmail->validateEmail($BOUNCE)){
					@list( $account, $bounceDomain )=@explode( '@', $BOUNCE );
					$DOMAIN=str_replace( 'www.','', parse_url( JOOBI_SITE, PHP_URL_HOST));

					if($bounceDomain !=$DOMAIN){
						$this->adminW( 'Your bounce e-mail "'.$BOUNCE.'" does not belong to your website domain "' . $DOMAIN . '"... in most of cases the bounce address must belong to your own domain' );
						return;
					}
				}else{
					$this->adminW( 'The bounce email address specified is not a valid email address: ' . $BOUNCE );
				}

								if( !empty($BOUNCE)){
					$this->adminW( 'You can try to do not specify any bounce e-mail (the actual value is "' . $BOUNCE . '") so that the system will generate an automatic one' );
					return;

				}
			}
		}

	}
}