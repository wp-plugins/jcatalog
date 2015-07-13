<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Modelfields_model extends WModel {


	private $_currentPublish = null;

	private $_currentField = null;



	private $_deletedSID = null;

	private $_deletedDBCID = null;



	protected $_loadElementBeforeDelete = true;


	private $_columnAlreadyExist = false;

		private $_requireUniqueColumn = false;


	protected $_usePrefix = true;








	function addValidate() {



		
		$this->_checkTranslated();



		
		if ( empty($this->column) ) {

			$this->column = $this->getChild( 'design.modelfieldstrans', 'name' );

		}


		$this->column = WGlobals::filter( $this->column, 'alnum' );



		
		$this->column = $this->_checkUniqueColumn( $this->column );

		$this->column = strtolower( $this->column );



		$modelName = WModel::get( $this->sid, 'namekey' );

						if ( $this->_usePrefix ) $this->column = 'field_' . $this->column;


		$this->namekey = $modelName . '_' . $this->column;





		
		$designFieldsC = WClass::get( 'design.fields' );

		$fieldParamsA = $designFieldsC->getFieldParamsDefaultValues( $this->fieldid, 'listing' );

		if ( !empty($fieldParamsA) ) {

			if ( empty($this->params) ) $this->params = '';

			else $this->params .= "\n";

			$this->params .= implode( "\n", $fieldParamsA );

		}
		$designFieldsC = WClass::get( 'design.fields' );

		$fieldParamsA = $designFieldsC->getFieldParamsDefaultValues( $this->fieldid, 'form' );

		if ( !empty($fieldParamsA) ) {

			if ( empty($this->params) ) $this->params = '';

			else $this->params .= "\n";

			$this->params .= implode( "\n", $fieldParamsA );

		}

				if ( empty( $this->rolid ) ) $this->rolid = 1;
		if ( empty( $this->rolid_edit ) ) $this->rolid = 1;


		return true;





	}








	function editValidate() {



		
		$fieldM = WModel::get( 'design.modelfields' );

		$fieldM->whereE( 'fdid', $this->fdid );

		$fieldO = $fieldM->load( 'o', array( 'publish', 'fieldid' ) );

		$this->_currentPublish = $fieldO->publish;

		$this->_currentField = $fieldO->fieldid;



		return true;



	}











	function addExtra() {



		
		$designModel = WModel::get( 'design.model' );

		$designModel->updatePlus( 'totalcustom', 1 );


		$newNAmekey = WModel::get( $this->sid, 'mainmodel' );

		$mySid = WModel::get( $newNAmekey, 'sid' );


		$designModel->whereE( 'sid', $mySid );

		$designModel->update();



		
		$designColumnsC = WClass::get( 'design.column' );

		if ( $this->_columnAlreadyExist ) {
			$dbcid = $designColumnsC->getColumnID( $this->sid, $this->column );
		} else {
			$dbcid = $designColumnsC->createColumn( $this->sid, $this->fieldid, $this->column );
		}

		


		if ( !$dbcid ) return false;

		else {

			
			$modelFieldM = WModel::get( 'design.modelfields' );

			$modelFieldM->whereE( 'fdid', $this->fdid );

			$modelFieldM->setVal( 'dbcid', $dbcid );

			$modelFieldM->update();

		}


		return true;



	}








	function editExtra() {



		
		$thereIsTypesB = $this->_updateTheFieldTypes();



		
		if ( $this->_currentField != $this->fieldid ) {

			$updateField = true;

			$designFieldsC = WClass::get( 'design.fields' );

			$fieldO = $designFieldsC->load( $this->fieldid );

		} else {

			$updateField = false;

		}






		
		
		$libraryViewElementM = WModel::get( 'library.viewforms' );

		$libraryViewElementM->whereE( 'fdid', $this->fdid );

		if ( $updateField ) $libraryViewElementM->setVal( 'type', $fieldO->form );

		$libraryViewElementM->setVal( 'required', $this->required );

		if ( $this->_currentPublish != $this->publish ) $libraryViewElementM->setVal( 'publish', $this->publish );

		$libraryViewElementM->setVal( 'checktype', (int)$thereIsTypesB );

		$libraryViewElementM->update();



		
		$libraryViewElementM = WModel::get( 'library.viewlistings' );

		$libraryViewElementM->whereE( 'fdid', $this->fdid );

		if ( $updateField ) $libraryViewElementM->setVal( 'type', $fieldO->listing );

		$libraryViewElementM->setVal( 'search', $this->searchable );

		$libraryViewElementM->setVal( 'advsearch', $this->advsearchable );

		if ( $this->_currentPublish != $this->publish ) $libraryViewElementM->setVal( 'publish', $this->publish );

		$libraryViewElementM->update();





		
		if ( $this->_currentPublish != $this->publish && empty($this->publish) ) {

			$designViewfieldsM = WModel::get( 'design.viewfields');

			$designViewfieldsM->whereE( 'fdid', $this->fdid );

			$designViewfieldsM->delete();

		}




		
		if ( !empty( $this->updateall ) ) {



			$name = $this->getChild( 'design.modelfieldstrans', 'name' );

			$description = $this->getChild( 'design.modelfieldstrans', 'description' );



			$libraryViewElementM = WModel::get( 'library.viewformstrans' );


			$libraryViewElementM->makeLJ( 'library.viewforms' );

			$libraryViewElementM->whereE( 'fdid', $this->fdid, 1 );

			$libraryViewElementM->whereE( 'lgid', WUser::get('lgid') );

			$libraryViewElementM->setVal( 'name', $name );

			$libraryViewElementM->setVal( 'description', $description );

			$libraryViewElementM->update();



			$libraryViewElementM = WModel::get( 'library.viewlistingstrans' );


			$libraryViewElementM->makeLJ( 'library.viewlistings' );

			$libraryViewElementM->whereE( 'fdid', $this->fdid, 1 );

			$libraryViewElementM->whereE( 'lgid', WUser::get('lgid') );

			$libraryViewElementM->setVal( 'name', $name );

			$libraryViewElementM->setVal( 'description', $description );

			$libraryViewElementM->update();





			
			$designElementC = WClass::get( 'design.element' );

			$designElementC->updateEachParams( $this->fdid );





		}




		
		if ( $updateField ) {

			
			$designColumnsC = WClass::get( 'design.column' );

			$dbcid = $designColumnsC->updateColumn( $this->sid, $this->fieldid, $this->column, $this->dbcid );

			if ( !$dbcid ) return false;

		}


		return true;



	}












	function extra() {


		$designElementC = WClass::get( 'design.element' );

		
		if ( !empty($this->searchable) ) {

			$designElementC->addSearchableListingElement( $this->sid, $this->fdid, $this->dbcid, $this->column );

		} else {

			if ( !empty($this->dbcid) ) $designElementC->setUnSearchableListingElement( $this->sid, $this->dbcid, $this->column );

		}


		
		if ( !empty($this->advsearchable) ) {

			$designElementC->addSearchableListingElement( $this->sid, $this->fdid, $this->dbcid, $this->column, true );

		} else {

			if ( !empty($this->dbcid) ) $designElementC->setUnSearchableListingElement( $this->sid, $this->dbcid, $this->column, true );

		}

				$cacheC = WCache::get();
		$cacheC->resetCache( array( 'Model', 'Model_model_fields', 'Model_dataset_columns' ) );


		return true;



	}












	function deleteValidate($eid=0) {



		
		$designModelfieldsM = WModel::get( 'design.modelfields' );

		$designModelfieldsM->whereE( 'fdid', $eid );

		$allFieldInfoO = $designModelfieldsM->load( 'o', array('sid', 'dbcid') );

		$this->_deletedSID = $allFieldInfoO->sid;

		if ( !empty($allFieldInfoO->dbcid) ) $this->_deletedDBCID = $allFieldInfoO->dbcid;



		return true;


	}












	function deleteExtra($eid=0) {



		if ( !empty($this->_deletedSID) ) {

			
			$designModel = WModel::get( 'design.model' );

			$designModel->updatePlus( 'totalcustom', -1 );

			$newNAmekey = WModel::get( $this->_deletedSID, 'mainmodel' );

			$mySid = WModel::get( $newNAmekey, 'sid' );

			$designModel->whereE( 'sid', $mySid );

			$designModel->update();

		}




		$status = false;


		if ( !empty( $this->_deletedDBCID ) ) {

			
			$designColumnsM = WModel::get( 'design.columns' );

			$status = $designColumnsM->deleteAll( $this->_deletedDBCID );	


		} else {

			$message = WMessage::get();

			$message->codeE( 'The column could not be deleted! This is problem because it will cause the view to break.' );

		}






		if ( !empty($eid) ) {

			
			$libraryViewElementM = WModel::get( 'library.viewforms' );

			$libraryViewElementM->whereE( 'fdid', $eid );

			$libraryViewElementM->deleteAll();



			$libraryViewElementM = WModel::get( 'library.viewlistings' );

			$libraryViewElementM->whereE( 'fdid', $eid );

			$libraryViewElementM->deleteAll();



		}


		return $status;



	}










	public function secureTranslation($sid,$eid) {

		if ( ! WUser::get( 'uid' ) ) return false;

				if ( WRole::hasRole( 'admin' ) ) return true;

		return false;

	}











	private function _updateTheFieldTypes() {


		
		if ( !empty($this->_x['typeid']) ) $valuesA = $this->_x['typeid'];

		else $valuesA = array();





		$designModelFieldsTypeM = WModel::get( 'design.modelfieldstype' );


		$designModelFieldsTypeM->whereE( 'fdid', $this->fdid );

		$designModelFieldsTypeM->delete();



		if ( empty( $valuesA ) ) return false;



		
		$insertArrayA = array();

		foreach( $valuesA as $oneV ) {

			if ( empty($oneV) ) continue;

			$insertArrayA[] = array( $this->fdid, $oneV );

		}


		if ( empty( $insertArrayA ) ) return true;



		
		$designModelFieldsTypeM->insertMany( array( 'fdid', 'typeid' ), $insertArrayA );



		return true;



	}














	private function _checkTranslated() {



		$designFieldsM = WModel::get( 'design.fields' );

		$designFieldsM->whereE( 'fieldid', $this->fieldid );

		$translate = $designFieldsM->load( 'lr', 'translate' );



		if ( empty( $translate ) ) return true;



		

		$modelName = WModel::get( $this->sid, 'mainmodel' );



		$translatedSID = WModel::get( $modelName . 'trans' , 'sid' );





		$this->sid = $translatedSID;



		$this->translate = 1;



		return true;



	}














	private function _checkUniqueColumn($column) {



		$deesignModelFieldM = WModel::get( 'design.modelfields' );


		$tryiedColumn = $column;

		$exist = true;

		
		do {

			$deesignModelFieldM->whereE( 'sid', $this->sid );

			$deesignModelFieldM->whereE( 'column', $tryiedColumn );

			$exist = $deesignModelFieldM->exist();



			if ( $exist ) {

				$tryiedColumn = $column . '_' . WTools::randomString();

			}


		} while( $exist );


		$tryiedColumn2 = $tryiedColumn;
		if ( ! $this->_requireUniqueColumn ) {
			$sqlColumnsM = WModel::get( 'library.columns' );
			$sqlColumnsM->makeLJ( 'library.model', 'dbtid' );
			$sqlColumnsM->whereE( 'sid', $this->sid, 1 );
			$sqlColumnsM->whereE( 'name', $tryiedColumn2 );
			$exist = $sqlColumnsM->exist();

			if ( $exist ) {
				$this->userN('1423647407JIHV');

				$this->_columnAlreadyExist = true;
			}			return $tryiedColumn2;

		}



		$tryiedColumn2 = $tryiedColumn;

		$sqlColumnsM = WModel::get( 'library.columns' );

		
		do {

			$sqlColumnsM->makeLJ( 'library.model', 'dbtid' );

			$sqlColumnsM->whereE( 'sid', $this->sid, 1 );

			$sqlColumnsM->whereE( 'name', $tryiedColumn2 );

			$exist = $sqlColumnsM->exist();



			if ( $exist ) {

				$tryiedColumn2 = $tryiedColumn . '_' . WTools::randomString();

			}


		} while( $exist );


		$tryiedColumn3 = $tryiedColumn2;

		
		do {



			$modelM = WModel::get( $this->sid );

			if (!empty($modelM) ) $exist = $modelM->columnExists( $tryiedColumn3 );

			else $exist = false;



			if ( $exist ) {

				$tryiedColumn3 = $tryiedColumn2 . '_' . WTools::randomString();

			}


		} while( $exist );


		return $tryiedColumn3;



	}}