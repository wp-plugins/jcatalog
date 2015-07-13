<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_Apps_show_view extends Output_Forms_class {








protected function prepareView(){



		$distribserver=WPref::load( 'PAPPS_NODE_DISTRIBSERVER' );

		if( $distribserver==11){

			
			$this->removeMenus( array( 'apps_show_custom_install', 'apps_show_custom_reinstall', 'apps_show_divider_install' ));



		}elseif( $distribserver==99){

			
			$message=WMessage::get();

			$message->userN('1338581058MKNK');

		}else{

			
			


			



		}


		return true;



	}}