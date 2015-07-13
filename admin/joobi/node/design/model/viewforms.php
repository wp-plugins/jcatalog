<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Viewforms_model extends WModel {










	function addValidate() {



		
		if ( empty($this->yid) ) {

			$message = WMessage::get();

			$message->userE('1375977746FUII');

			WPages::redirect( 'previous');

		}




		
		if ( empty($this->namekey) ) {

			$this->_defineNamekey();

		}




		










		return true;



	}












	function validate() {



		if ( !empty($this->rolid) ) {

			
			
			$YIDRolid = WView::get( $this->yid, 'rolid' );

			$roleC = WRole::get();

			$acceptedR = $roleC->compareRole( $this->rolid, $YIDRolid );



			if ( !$acceptedR ) $this->rolid = $YIDRolid;



		}


		
		$type = WView::get( $this->yid, 'type' );

		if ( $type == 151 ) {

			$this->readonly = 1;

			$this->required = 0;

		}


		return true;



	}














	private function _defineNamekey() {



		if ( empty($this->yid) ) return false;



		$myPK = 'fid';

		$modelName = 'forms';





		$i = array();

		if (!isset($i[$this->yid]) ) $i[$this->yid] = 1;



		$viewM = WModel::get( 'library.view' );

		$viewM->whereE( 'yid', $this->yid );

		$viewNamekey = $viewM->load( 'lr', 'namekey' );



		if ( strlen($viewNamekey) > 60 ) {

			$viewNamekey = substr( $viewNamekey, 0, 60 );




		}


		if ( !empty($this->map) ) $this->map = trim($this->map);



		if ( empty($this->map) ) {

			
			$menuName = strtolower( $this->getChild( 'view.'.$modelName.'trans', 'name' ) );

			$viewNamekey .= '_' . str_replace( ' ', '_', $menuName );



		} elseif (  substr( $this->map, 1, 1) != '[' && !empty($this->sid) ) {

			$sidModelNamekey = WModel::get( $this->sid, 'namekey');

			if ( empty($sidModelNamekey) ) {

				return false;

			}


			
			$modelNamekey = str_replace( '.', '_', $sidModelNamekey );

			$viewNamekey .= '_' . $modelNamekey . '_' . $this->map;

		} else {



			
			$mapNmae = str_replace( array( ']', 'c[', 'x[', 'm[', 'p[', 'f[' ), '', $this->map );

			$mapNmae = str_replace( array( '[', '.' ), '_', $mapNmae );



			$viewNamekey .= '_' . $mapNmae;



		}


		
		$LibraryViewM = WModel::get( 'library.view' . $modelName );

		$LibraryViewM->whereE( 'namekey', $viewNamekey );

		$exitsLR = $LibraryViewM->load( 'lr' , $myPK );



		if ( !empty($exitsLR) ) {

			$viewNamekey .= '_' . $i[$this->yid];

			$i[$this->yid]++;



			
			$LibraryViewM->whereE( 'namekey', $viewNamekey );

			$exitsLR = $LibraryViewM->load( 'lr' , $myPK );



			if ( !empty($exitsLR) ) {


				return false;

			}


		}


		$this->namekey = $viewNamekey;



		return true;



	}}