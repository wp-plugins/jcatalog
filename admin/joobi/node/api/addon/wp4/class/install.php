<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');











class Api_Wp4_Install_class extends WClasses {



	private $appName=null;















	public function wpRun($array){





		$this->appName=$array[0];

		$this->action=$array[1];




		switch( $this->action){

			case 'install':

				$this->_install();

				break;

			case 'uninstall':

				$this->_uninstall();

				break;

			default:

				break;

		}


	}














	public function createRewriteRules(){






		$permalinksA=get_option( JOOBI_PREFIX . '_permalinks' );



		if( !empty($permalinksA)){

			foreach( $permalinksA as $slug){

				
				add_rewrite_rule( $slug . '/(.?.+?)(/[0-9]+)?/?$', 'index.php?pagename=' . $slug, 'top' );

			}
			flush_rewrite_rules();

		}


		
		$cacheC=WCache::get();

		$cacheC->resetCache( 'QueryData' );



		






















	}














	public function install($appName=''){



		
		if( empty($appName) || JOOBI_MAIN_APP==$appName ) return false;



				
		$yid=WView::get( $appName . '_main_fe', 'yid' );	


		if( empty($yid)) return false;



		$addon=WAddon::get( 'install.' . JOOBI_FRAMEWORK );

		$addon->yid=$yid;

		$menusA=$addon->getSubMenusList( $appName );






		if( !empty($menusA)){

			
			$lowerAppName=strtolower( $appName );

			$link='controller=' . $lowerAppName;

			$parentSlugA=array();

			$parentSlugA[]=JoobiWP::linkToOption( $link, $lowerAppName );

			WApplication::createMenu( $appName, '', $link, $lowerAppName );





			foreach( $menusA as $oneMenu){



				if( empty($oneMenu->parent)){

					$parentSlug=$parentSlugA[0];

				}else{

					$parentSlug=$parentSlugA[$oneMenu->mid];

				}



				









				$parentSlugA[$oneMenu->mid]=WApplication::createMenu( $oneMenu->name, $parentSlug, $oneMenu->action, $lowerAppName );




			}


		}


		
		WApplication_wp4::renderFunction( 'install', 'createRewriteRules' );



	}












	public function uninstall($appName=''){



		
		if( empty($appName)) return false;



				
		$yid=WView::get( $appName . '_main_fe', 'yid' );	


		if( empty($yid)) return false;



		$addon=WAddon::get( 'install.' . JOOBI_FRAMEWORK );

		$addon->yid=$yid;

		$menusA=$addon->getSubMenusList( $appName );





		if( !empty($menusA)){



			$lowerAppName=strtolower( $appName );

			$link='controller=' . $lowerAppName;



			$option=JoobiWP::linkToOption( $link, $lowerAppName );

			$option_value=get_option( $option );



			global $wpdb;

			
			$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->posts . " WHERE ID=%s ", $option_value ));

			delete_option( $option );



			$allSlugA=array();

			
			foreach( $menusA as $oneMenu){



				


				
				$option=JoobiWP::linkToOption( $oneMenu->action, $lowerAppName );

				$option_value=get_option( $option );



				if( empty($option_value)) continue;



				$postO=get_post( $option_value );



				$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->posts . " WHERE ID=%s ", $option_value ));

				delete_option( $option );



				if( !empty($postO->post_name)) $allSlugA[]=$postO->post_name;



			}




			if( !empty($allSlugA)){

				$permalinksA=get_option( JOOBI_PREFIX . '_permalinks' );



				if( !empty($permalinksA)){

					$newA=$permalinksA;

					foreach( $permalinksA as $key=> $slug){

						if( in_array( $slug, $allSlugA )) continue;

						$newA[$key]=$slug;

					}


				}else{

					return;

				}


				update_option( JOOBI_PREFIX . '_permalinks', $newA );



				
				WApplication_wp4::renderFunction( 'install', 'createRewriteRules' );



			}


		}








	}












	private function _install($appName=''){

WMessage::log( 'Install and aactivation app:' . $this->appName . 'Install app:' . $appName , 'WP_install_plugin' );



		
		if( empty($appName)) return false;



	}












	private function _uninstall(){



WMessage::log( 'Un-install app:' . $this->appName, 'WP_install_plugin');



	}














	public function installNotice($app){

		static $needPageA=array();	


		if( isset($needPageA[$app])) return;

		if( in_array( WGlobals::get( 'task' ), array( 'installpage', 'setup' )) ) return;



		
		$noFEA=Array( JOOBI_MAIN_APP, 'jlinks', 'jbounceback', 'jdefender', 'jmobile' );

		if( in_array( $app, $noFEA )) return '';



		WText::load( 'api.node' );



		$this->appName=$app;



		
		$needPageA[$app]=WPref::load(  strtoupper( $app ) . '_APPLICATION_INSTALL_PAGE' );

		if( empty( $needPageA[$app] )){

			$appPref=WPref::get( $app . '.application' );

			$appPref->updatePref( 'install_page', 1 );

			$needPageA[$app]=true;

		}


		$html='';



		$needPage=WPref::load(  strtoupper( $app ) . '_APPLICATION_INSTALL_PAGE' );

		if( $needPage < 2){



			$path=WPage::fileLocation( 'css', 'css/activation.css', 'api' );

			WPage::addStyleSheet( $path );



			$APPLICATION=WExtension::get( $app . '.application', 'name' );



			$html='<div id="message" class="updated joobi-message">';	
			$html .='<p><strong>';

			$html .=str_replace(array('$APPLICATION'), array($APPLICATION),WText::t('1416248908LXMN'));

			$html .='</strong></p>';

			$html .=WText::t('1416248908LXMO');

			$html .='<p class="submit">';

			$links1=admin_url( 'admin.php?page=' . $app . '&controller=apps&task=installpage&app=' . $app . '&addPage=1' );	
			$html .='<a href="' . $links1 .'" class="button-primary">' . str_replace(array('$APPLICATION'), array($APPLICATION),WText::t('1436531336NQEF')) . '</a>';

			$links2=admin_url( 'admin.php?page=' . $app . '&controller=apps&task=installpage&app=' . $app );	
			$html .=' <a href="' . $links2 .'" class="skip button-primary">' . WText::t('1416248908LXMQ') . '</a>';

			$html .='</p>';

			$html .='</div>';



		}


		return $html;



	}


















	public function pluginActionLinks($array){



		WText::load( 'api.node' );



		$this->appName=$array[0];

		$linksA=$array[1];



		if( empty($linksA)) $linksA=array();



		WText::load( 'api.node' );



		$newLinksA=array_merge( array(


			'<a href="' . esc_url( apply_filters( $this->appName . '_docs_url', 'http://www.joobi.co/r.php?l=wp_docs' )) . '">' .  WText::t('1416248908LXMR') . '</a>',	
			'<a href="' . esc_url( apply_filters( $this->appName . '_support_url', 'http://www.joobi.co/r.php?l=wp_support' )) . '">' . WText::t('1416248908LXMS') . '</a>',	
		), $linksA );



		return $newLinksA;



	}




}