<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_Users_node_horizontalmenu_fe_view extends Output_Mlinks_class {

	function prepareView(){



		if( ! WUser::isRegistered()){

			$this->changeElements( 'main_user_horizontalmenu_fe_logout', 'name', WText::t('1206732411EGQX'));
			$this->changeElements( 'main_user_horizontalmenu_fe_logout', 'action', 'users&task=login' );

		}


		return true;



	}
}