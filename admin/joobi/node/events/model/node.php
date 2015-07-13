<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_Node_model extends WModel {


	private $_app2Copy=null;

	private $_task2Copy=null;


	protected $_loadElementBeforeDelete=true;



	function validate(){



		$this->core=0;
		$this->custom=0;



		$this->namekey=$this->app . '.' . $this->task . ( $this->admin ? '.' . $this->admin : '' );



		if( isset( $this->namekey )) $this->namekey=WGlobals::filter( $this->namekey, 'namekey' );


 		$fileExist=( isset( $this->f['controller'] ) && !empty( $this->f['controller'] ) ? true : false );
		$fileContent=( $fileExist ? trim( $this->f['controller'] ) : null );

		if( !empty( $fileContent )){
			$this->path=1;
		}

		return true;



	}












	public function extra(){



		
		$extensionHelperC=WCache::get();

		$extensionHelperC->resetCache( 'Controller' );



		return true;



	}














	public function copyValidate(){


		$this->_app2Copy=$this->app;

		$this->_task2Copy=$this->task;

		$this->_pathOrignal=$this->path;
		$this->_coreOrignal=$this->core;
		$this->_ctridOrignal=$this->ctrid;



						
		if( !empty($this->path) || !empty($this->pnamekey)){	
			$this->pnamekey=$this->namekey;

		}


		static $count=0;

		$count++;

		$this->app=$this->_app2Copy . '_copy' . time() . '_' . $count;

		$this->task=$this->_task2Copy;


		
		$this->core=0;
		$this->custom=1;



		$this->namekey=$this->app . '.' . $this->task . ( $this->admin ? '.' . $this->admin : '' );



		return true;



	}





	public function copyExtra(){

		if( !empty($this->_pathOrignal)){

			if( empty($this->_coreOrignal)){
				$path=JOOBI_DS_USER . 'node' . DS;
			}else{
				$path=JOOBI_DS_NODE;
			}
			$folder=WExtension::get( $this->wid, 'folder' );
			$fileNameOrign=$this->_app2Copy . '_' . $this->_task2Copy . '.php';
			$fileNameDest=$this->app . '_' . $this->task . '.php';

			$pathOrignal=$path . $folder . DS . 'controller' . DS . $fileNameOrign;
			$pathDest=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'controller' . DS . $fileNameDest;


			$fileS=WGet::file();
			$fileS->copy( $pathOrignal, $pathDest );

			WLoadFile( 'design.system.class', JOOBI_DS_NODE );
			$extFileA=WAddon::get( 'design.controller' );
			$extendedClass=$extFileA->getExtends( $this->_ctridOrignal );

			if( !empty($extendedClass)){

				$originalClass=ucfirst( str_replace( '-', '_', $this->_app2Copy )) . '_' . ucfirst( $this->_task2Copy ) . '_controller';
				$newClass=ucfirst( str_replace( '-', '_', $this->app )) . '_' . ucfirst( $this->task ) . '_controller';

				$newDeclaration='WLoadFile( \'' . $folder . '.controller.' . $this->_app2Copy . '_' . $this->_task2Copy . '\' );';					$newDeclaration .="\n";
				$newDeclaration .='class ' . $newClass . ' extends ' . $originalClass . ' ';

				$content=$fileS->read( $pathDest );

				$posClass=strpos( $content, 'class ' );
				$firstClose=strpos( $content, '{', $posClass );
				$classDeclation=substr( $content, $posClass, $firstClose - $posClass );

				$content=str_replace( $classDeclation, $newDeclaration, $content );

				$fileS->write( $pathDest, $content, 'overwrite' );

			}
		}
		return true;

	}







	public function deleteValidate($eid=0){

		parent::deleteValidate( $eid );

		if( !empty($this->_x->core)){
			$this->userE('1434643123QBFI');
			return false;
		}
		return true;

	}





	public function deleteExtra($eid=0){

				if( !empty( $this->_x->path )){

			$folder=WExtension::get( $this->_x->wid, 'folder' );
			$fileNameDest=$this->_x->app . '_' . $this->_x->task . '.php';
			$pathDest=JOOBI_DS_USER . 'node' . DS . $folder . DS . 'controller' . DS . $fileNameDest;


			$fileS=WGet::file();
			$fileS->delete( $pathDest );

		}
		return true;

	}


}