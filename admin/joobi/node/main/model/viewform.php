<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Viewform_model extends WModel {









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

			$message->userE('1375977746FUII');

			WPages::redirect( 'controller=main-view' );

		}




		
		$designLayoutTypeT = WType::get( 'design.layoutype', false );

		if ( !empty($designLayoutTypeT) ) {

			$acceptedTypeA = $designLayoutTypeT->allNames();

			if ( empty($this->parentdft) && !empty($this->type) && in_array( $this->type, $acceptedTypeA ) ) {

				$this->parentdft = 9;

			}
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



		
		
		$librayViewListingM = WModel::get( 'library.viewforms' );

		$librayViewListingM->whereE( 'fid', $this->fid );

		$currentParmas = $librayViewListingM->load( 'lr', 'params' );



		$existingParams = new stdClass;

		$existingParams->params = $currentParmas;

		WTools::getParams( $existingParams );



		if ( !empty($existingParams) ) {

			
			foreach( $existingParams as $oneKye => $oneP ) {

				if ( !isset( $this->p[$oneKye] ) ) $this->p[$oneKye] = $oneP;

			}
		}


		
		if ( !empty($this->parent) ) {

			$modelParentM = WModel::get( $this->getModelID() );

			$modelParentM->whereE( 'fid', $this->parent );

			$AREA = $modelParentM->load ( $this->parent, 'area' );



			
			if ( empty($this->area) || $this->area != $AREA ) {

				$this->area = $AREA;






			}


		}




		if ( !empty($this->yid) ) {

						$type = WView::get( $this->yid, 'type' );
			if ( $type == 151 ) {
				$this->readonly = 1;
				$this->required = 0;
			}
		}



		
		if ( !empty($this->type) && '-no-type-select-' == $this->type ) {

			$this->type = 'main.widgetbox';

		}


		return true;



	}












	function extra() {



		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );



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