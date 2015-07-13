<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Viewmenu_model extends WModel {










	public function secureTranslation($sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;

				$roleHelper = WRole::get();
		if ( WRole::hasRole( 'admin' ) ) return true;

		return false;

	}



	function addValidate() {



		
		if ( empty($this->yid) ) {

			$message = WMessage::get();

			$message->userE('1375977746FUIJ');

			WPages::redirect( 'controller=main-view');

		}




		
		if ( empty($this->namekey) ) {

			$this->_defineNamekey();

		}


		return true;

	}








	function validate() {



		
		$mainEditC = WClass::get( 'main.edit' );

		if ( !$mainEditC->checkEditAccess() ) return false;



		
		$this->core = 0;



		return true;



	}




	function extra() {



		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );



		return true;



	}












	private function _defineNamekey() {



		if ( empty($this->yid) ) return false;



		static $i=1;



		$viewM = WModel::get( 'library.view' );

		$viewM->whereE( 'yid', $this->yid );

		$viewNamekey = $viewM->load( 'lr', 'namekey' );



		if ( strlen($viewNamekey) > 60 ) {

			$message = WMessage::get();

			$message->userE('1339210951DJSU');

			return false;

		}


			if (  strpos($this->action,'.')!==false || strpos($this->action,'&')!==false || strpos($this->action,'?')!==false || strpos($this->action,'=')!==false ) {

				
				$LibraryViewTransM = WModel::get( 'library.viewmenustrans' );

				$LibraryViewTransM->whereE( 'mid', $this->mid );

				$LibraryViewTransM->whereE( 'lgid', 1 );

				$menuName = strtolower( $LibraryViewTransM->load( 'lr', 'name' ) );

				$viewNamekey .= '_' . str_replace( ' ', '_', $menuName );

			} else {



				if ( strlen( $this->action ) > 40 ) {

					return false;



				} else {

					$action = WGlobals::filter( $this->action, 'alnum' );

					$viewNamekey .= '_' . $action;

				}


			}


			$LibraryViewM = WModel::get( 'library.viewmenus' );

			
			$LibraryViewM->whereE( 'namekey', $viewNamekey );

			$exitsLR = $LibraryViewM->load( 'lr' , 'mid' );



			if ( !empty($exitsLR) ) {



				$viewNamekey .= '_' . $i;

				$i++;



				
				$LibraryViewM->whereE( 'namekey', $viewNamekey );

				$exitsLR = $LibraryViewM->load( 'lr' , 'mid' );



				if ( !empty($exitsLR) ) {


					return false;



				}


			}


		$this->namekey = $viewNamekey;



		return true;



	}}