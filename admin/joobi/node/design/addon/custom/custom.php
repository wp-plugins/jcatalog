<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Design_Custom_addon extends Design_System_class {

			
		var $fileCodeType='view';	var $fileCodeClassExtends = 'WView';

	private $libraryDefault = array( 'Output_Forms_class', 'Output_Listings_class', 'Output_Mlinks_class' );












	function load($eid=null) {
		$content='';

		if ( !isset($eid) ) $eid=WGlobals::getEID();

		if (!empty($eid)){			$object = new stdClass;
						$object = $this->_getSQL($eid);

				 $this->fileLocation = WExtension::get( $object->wid, 'folder') .'.'. strtolower( str_replace( array( '.', ' '), '_', $object->namekey ) );
			$this->filePathSetVar();
						if (!$this->hl->exist($this->fileP)){
				$this->setupVariables();
				return $this->_buildStruct();
			}elseif ($this->fileP!='' && $this->hl->read($this->fileP)){
				$content=$this->hl->read($this->fileP);
				return $this->_getStruct($content);
			}
 			else{
 				$mess = $this->loadMssW;
 				$this->message->userW($mess);
 			}
		}

				$this->setupVariables();
		return $this->_buildStruct();
	}














	public function getExtends($eid){
		if (empty($eid)){
			$this->setupVariables();
			return $this->defaultextendsclass;
		}

		$object = new stdClass;
				$object = $this->_getSQL($eid);


				 $this->fileLocation = WExtension::get( $object->wid, 'folder') .'.'. strtolower( str_replace( array( '.', ' '), '_', $object->namekey ) );

		$this->filePathSetVar();

		if ( ! $this->hl->exist($this->fileP) ) {
			$extendsclass = '';
		}elseif ($this->fileP!='' && $this->hl->read($this->fileP)){
			$content=$this->hl->read($this->fileP);
			$extendsclass = $this->_getExtendsClass($content);
		} else {
			$extendsclass = '';
 		}
		if (empty($extendsclass)) $extendsclass = $this->defaultextendsclass;

		return $extendsclass;

	}






	function getImport($extendsclass) {
				if ( $extendsclass == $this->defaultextendsclass || in_array( $extendsclass, $this->libraryDefault ) ) {
			return '';
		} else {
			$tabExt=explode('_',$extendsclass);
			$node = array_shift( $tabExt );
			array_pop( $tabExt );

						return "WLoadFile( '" .strtolower($node). ".view.".strtolower(implode('_', $tabExt ))."' , JOOBI_DS_NODE );";
		}
	}







	function save($code,$object) {
				if ($code=='') return '';

				$code = $this->_clearLineSpaces($code);

				$this->setupVariables();

		if (isset($object->x[$this->fileCodeType])) $this->extendsclass = $object->x[$this->fileCodeType];


		if ( empty($object->namekey) ) $object->namekey = WView::get( $object->yid, 'namekey' );
		if ( empty($object->wid) ) $object->wid = WView::get( $object->yid, 'wid' );

				$this->fileLocation = WExtension::get( $object->wid, 'folder') .'.'. strtolower( str_replace( array( '.', ' '), '_', $object->namekey ) );

				$this->name = 'View : '. $object->namekey;
		$this->description = '';

				$this->code = $code;

				$this->filePathSetVar();

				$this->_savefile();
	}






	function delete($eid) {

		$object = new stdClass;
				$object = $this->_getSQL($eid);

				$this->fileLocation = WExtension::get( $object->wid, 'folder') .'.'. strtolower( str_replace( array( '.', ' '), '_', $object->namekey ) );

				$this->folder = $this->fileCodeType; 
		return $this->_deletefile();
	}







	function _getSQL($eid) {
		return Design_View_addon::viewSQL( $eid );

	}






	function viewSQL($eid) {
		static $objectTemp=array();

		if ( !isset($objectTemp[$eid]) ) {

						$modelM=WModel::get( 'library.view' );
			$modelM->whereE('yid',$eid);
			$objectTemp[$eid] = $modelM->load( 'o', array('namekey', 'wid', 'type') );

		}
		if ( $objectTemp[$eid]->type < 50 ) {
			$this->fileCodeClassExtends = 'Output_Listings_class';
		} elseif ( $objectTemp[$eid]->type > 50 && $objectTemp[$eid]->type < 200 ) {
			$this->fileCodeClassExtends = 'Output_Forms_class';
		} else {
			$this->fileCodeClassExtends = 'Output_Customized_class';
		}
		return $objectTemp[$eid];

	}

}