<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_Users_node_horizontalmenu_fe_view extends Output_Mlinks_class {

	function prepareView(){



		if( ! WUser::isRegistered()){

			$this->changeElements( 'main_user_horizontalmenu_fe_logout', 'name', WText::t('1206732411EGQX'));
			$this->changeElements( 'main_user_horizontalmenu_fe_logout', 'action', 'users&task=login' );

		}


		return true;



	}
}