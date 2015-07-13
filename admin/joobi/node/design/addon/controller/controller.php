<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Design_Controller_addon extends Design_System_class {

			
		var $fileCodeType='controller';	var $fileCodeClassExtends = 'WController';





	function load($eid=null) {
		$content='';

		if ( !isset($eid) ) $eid=WGlobals::getEID();

		if (!empty($eid)){			$object = new stdClass;
						$object = $this->_getSQL($eid);

			$tabExt=explode( '.', $object->app );
			if ( count($tabExt)<2 ) {
				$tabExt=explode( '-', $object->app );
			}
			$this->fileLocation = $tabExt[0] . '.' . str_replace( '.', '_', ( $object->app . '_' . $object->task) );
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
 				$this->userW( $mess );
 			}
		}

				$this->setupVariables();
		return $this->_buildStruct();
	}














	public function getExtends($eid) {

		if ( empty($eid) ) {
			$this->setupVariables();
			return $this->defaultextendsclass;
		}
		$object = new stdClass;
				$object = $this->_getSQL( $eid );

		$tabExt=explode('.',$object->app);
		if ( count($tabExt)<2 ) {
			$tabExt=explode('-',$object->app);
		}
		$this->fileLocation = $tabExt[0] . '.' . str_replace( '.', '_', ( $object->app . '_' . $object->task) );
		$this->filePathSetVar();
		if ( ! $this->hl->exist( $this->fileP) ) {
			$extendsclass = '';
		}elseif ( $this->fileP !='' && $this->hl->read($this->fileP) ) {
			$content = $this->hl->read( $this->fileP );
			$extendsclass = $this->_getExtendsClass( $content );
		} else {
			$extendsclass = '';
 		}
		if ( empty($extendsclass) ) $extendsclass = $this->defaultextendsclass;
		return $extendsclass;

	}

	






	function getImport($extendsclass){
				if ($extendsclass==$this->defaultextendsclass){
			return '';
		} else {
						$tabExt=explode('_',$extendsclass);
			$import = strtolower($tabExt[0]).'.controller';
			for($i=0; $i < (count($tabExt) - 1) ; $i++){
				if ($i==0)
					$import .= '.'.strtolower($tabExt[$i]);
				else
					$import .= '_'.strtolower($tabExt[$i]);
			}
						return "WLoadFile( '".$import."' );";
		}
	}






	function save($code,$object) {
				if ($code=='')
			return '';

				$code=$this->_clearLineSpaces($code);

				$this->setupVariables();

		if (isset($object->x[$this->fileCodeType]))
			$this->extendsclass=$object->x[$this->fileCodeType];

				$tabExt=explode('.',$object->app);
		if ( count($tabExt)<2 ) {
			$tabExt=explode('-',$object->app);
		}

		$this->fileLocation=$tabExt[0].'.'.str_replace( '.', '_', ( $object->app . '_' . $object->task) );

				$this->name='Task : '.$object->task;
		$this->description='No description for a controller';

				$this->code=$code;

				$this->filePathSetVar();

				$this->_savefile();
	}






	function delete($eid) {

		$object = new stdClass;
				$object = $this->_getSQL($eid);

				$tabExt=explode('.',$object->app);
				if ( count($tabExt)<2 ) {
			$tabExt=explode('-',$object->app);
		}
		$this->fileLocation=$tabExt[0].'.'.str_replace( '.', '_', ( $object->app . '_' . $object->task) );

				$this->folder = $this->fileCodeType; 
		return $this->_deletefile();

	}







	function _getSQL($eid){

		static $objectTemp=array();

		if ( !isset($objectTemp[$eid]) ) {

						$modelM = WModel::get( 'library.controller' );
			$modelM->whereE( 'ctrid', $eid );
			$objectTemp[$eid] = $modelM->load( 'o', array('app','task') );

		}
		return $objectTemp[$eid];

	}


}