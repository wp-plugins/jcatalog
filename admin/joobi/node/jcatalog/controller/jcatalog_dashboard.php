<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Jcatalog_dashboard_controller extends WController {

	function dashboard() {



		if ( 'mobile' == JOOBI_FRAMEWORK_TYPE ) {



			if ( ! WUser::isRegistered() ) {

				
				$usersCredentialC = WUser::credential();

				$usersCredentialC->goLogin();

			}




			if ( ! WRole::hasRole( 'storemanager' ) ) {

				$this->userW('1425349403QAPQ');

				
				WPages::redirect( 'controller=vendors&task=register' );

			}


			if ( ! WRoles::isAdmin( 'vendor' ) ) return false;



			return parent::dashboard();



		} else {



			if ( ! WRoles::isAdmin( 'storemanager' ) ) WPages::redirect( 'controller=catalog&task=listing' );





		}

		return parent::dashboard();


	}
}