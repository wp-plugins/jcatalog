<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Columns_model extends WModel {


	private $_modelToUpdate = array( 'library.viewlistings', 'library.viewforms' );





	function validate() {



		
		
		if ( empty($this->pkey) ) {

			if ( $this->type <= 8 || $this->type == 25 ) {

				if ( $this->mandatory==1 && $this->default == '' ) {

					$this->default = '0';





	
				}
			}
		}


		return true;



	}













	function addValidate() {



		
		$this->returnId();



		if ( empty($this->name) ) {

			$message = WMessage::get();

			$message->userE('1220215719BHFI');

			return false;

		}


		$this->name = strtolower( preg_replace('#[^a-z0-9,_\-\.]#i', '', $this->name) );



		
		if ( !isset($this->ordering) ) $this->ordering = 99;



		
		$myModel=WModel::get( $this->getModelID() );

		$myModel->whereE( 'name', $this->name );

		$myModel->whereE( 'dbtid', $this->dbtid );

		if ( $myModel->exist() ) {

			$message = WMessage::get();

			$FIELD = $this->name;

			$message->userW('1418159512LBWK',array('$FIELD'=>$FIELD));

			return false;

		}


		if ( empty($this->namekey) ) $this->namekey = $this->name.$this->dbtid;

		if ( !empty($this->pkey) ) $this->mandatory = true;

		if ( !isset($this->mandatory) ) $this->mandatory = true;

		if ( !isset($this->default) ) $this->default = '';

		if ( !isset($this->extra) ) $this->extra = 0;

		if ( !isset($this->export) && isset($this->core) ) $this->export = $this->core;



		$this->_checkColumn();



		return parent::addValidate();



	}












	function editValidate() {



		if (!empty($this->dbcid)) {

			$myTable = WModel::get($this->getModelID());

			$myTable->whereE($this->getPK(),$this->dbcid);

			$this->_updatedColumn = $myTable->load('o',array('name','pkey'));

		}


		return parent::editValidate();



	}












	function extra() {



		if ( !parent::extra() ) return false;



		if ( empty($this->dbtid) ) {

			$this->codeE( 'The table is not specified' );

			return false;

		}

		$table = WTable::get($this->dbtid);

		
		$column = array();



			
		$columns = WType::get( 'design.columns' );	
		$attributes = WType::get( 'design.attributes' );



		$column['name'] = strtolower( $this->name );

		$column['type'] = strtoupper( $columns->getName( $this->type ) );

		$column['size'] = isset($this->size) ? $this->size : 0;

		if (!empty($this->attributes)) {

			$column['attributes'] = strtoupper( $attributes->getName( $this->attributes ) );

		}

		$column['mandatory'] = $this->mandatory ? true : false;

		$column['default'] = $this->default;

		$column['autoinc'] = $this->extra ? true : false;

		$columnUpdated = null;



		if ( !empty($this->_updatedColumn) ) {

			$columnUpdated['name'] = $this->_updatedColumn->name;

			
			$this->_updateInterfaces();

		}

		$table->changeColumn( $column, $columnUpdated );





		
		if ( !empty($this->pkey) || !empty($this->_updatedColumnName->pkey) ) {

			$helper = WClass::get( 'database.redo' );

			$helper->checkPK( $this->dbtid );

		}


		return true;



	}














	function addExtra() {

		if (!parent::addExtra()) return false;



		$this->_addForeign();

		$this->_addConstraint();



		return true;



	}














	function deleteValidateReserved($eid) {



		
		$modelTable = WModel::get($this->getModelID());

		$modelTable->whereE($this->getPK(),$eid);

		$this->_deletedColumn = $modelTable->load('o',array('dbtid','name'));

		return true;



	}












	function deleteExtra($eid=0) {



		if ( !empty($this->_deletedColumn->name) ) {

			$table = WTable::get( $this->_deletedColumn->dbtid );

			$table->dropColumn( $this->_deletedColumn->name );

		}


		
		$this->_deleteInterfaces();



		return true;

	}












	private function _checkColumn() {



		switch ( $this->name ) {

			case 'rolid' :

				$this->type = 2;

				$attributes = WType::get('database.attributes');

				$this->attributes =  $attributes->getValue('UNSIGNED');

				break;

			case 'publish':

				$this->type = 1;

				$this->attributes =  0;

				break;

			case 'description':

				$this->type = 16;

				$this->size = 0;

				break;

			case 'created':

			case 'modified':

				$this->type = 4;

				
				$this->columntype = 1;

				$this->checkval = 1;

				$attributes = WType::get('database.attributes');

				$this->attributes =  $attributes->getValue('UNSIGNED');

				break;

			case 'modifiedby':

			case 'checkedout':

			case 'uid':		
				$this->type = 4;

				$attributes = WType::get('database.attributes');

				$this->attributes =  $attributes->getValue('UNSIGNED');

				break;

			case 'name':

			case 'namekey':

				$this->type = 14;

				if (empty($this->size)) $this->size = 50;

				break;

			case 'ordering':

				$attributes = WType::get('database.attributes');

				$this->attributes =  $attributes->getValue('UNSIGNED');

				break;

			case 'level':

				$this->type =1;

				$attributes = WType::get('database.attributes');

				$this->attributes =  $attributes->getValue('UNSIGNED');

				break;

			case 'core':

			case 'premium':

				$this->type = 25;

				break;

		}


		if ( empty($this->size) && ( $this->type==0 || $this->type==14 || $this->type==15 ) ) $this->size=255;




		if ( ($this->type==14 || $this->type==15 ) && $this->size > 255 ) {

			$this->size = 255; 
			$this->type == 2; 
		}


		
		if ( $this->type>11 ) {

			$this->attributes =  0;

		}


	}















	private function _addForeign() {



		$ondelete = 1;

		$onupdate = 1;



		switch ( $this->name ) {

			case 'uid' :

				$refModel = WModel::get('users','object');

				break;

			case 'rolid' :

				$refModel = WModel::get('role','object');

				break;

			case 'parent' :

				$ref_dbtid = $this->dbtid;

				break;

			case 'lgid' :

				$refModel = WModel::get( 'library.languages','object');

				$ondelete = 3;

				break;

		}



		
		if (!empty($refModel)) {

			$ref_dbtid = $refModel->getTableId();

		}



		
		
		
		
		if (empty($ref_dbtid)) {



			
			$tables = WModel::get('library.table');



			$myGroup = $this->_getTablesInfo( $this->dbtid, 'group' );



			$tables->makeLJ('library.columns','dbtid'); 
			$tables->whereE('pkey',1,1);

			$tables->whereE('name',$this->name,1);

			$tables->whereE('group',$myGroup);

			$tables->whereIn('type',array('20','30'),0,true);

			$ref_dbtid = $tables->load('lr',array('dbtid'));

		}



		if (!empty($ref_dbtid)) {



			
			



			$tableName = $this->_getTablesInfo( $this->dbtid, 'name' );



			$foreign = WModel::get( 'library.foreign' );



			
			$columnModel = WModel::get('library.columns');

			$columnModel->whereE('name',$this->name);

			$columnModel->whereE('dbtid',$ref_dbtid);

			$columnModel->select($columnModel->getPK());

			$ref_feid = $columnModel->load('lr');



			$foreign->setVal('ondelete',$ondelete);

			$foreign->setVal('onupdate',$onupdate);

			$foreign->setVal('ref_dbtid',$ref_dbtid);

			$foreign->setVal('ref_feid',$ref_feid);

			$foreign->setVal('dbtid',$this->dbtid);

			$foreign->setVal('feid',$this->dbcid);

			


			
			$foreign->setVal('namekey','FK'.'_'.$tableName.'_'.$this->name);



			$foreign->setVal('map',$this->name);

			$foreign->setVal('map2',$this->name);

			$foreign->insert();



			$message = WMessage::get();

			$message->userS('1418694571IHYE');

		}


	}










	private function _getTablesInfo($dbtid,$return='') {

		static $myGroupA = array();



		if ( !isset($myGroupA[$dbtid]) ) {

			$tables = WModel::get('library.table');

			$tables->whereE('dbtid',$dbtid);

			$myGroupA[$dbtid] = $tables->load( 'o' );



		}


		if ( empty($return) ) return $myGroupA[$dbtid];

		elseif ( isset($myGroupA[$dbtid]->$return) ) $myGroupA[$dbtid]->$return;

		else return null;



	}













	private function _addConstraint() {



		if ( $this->name == 'namekey' ) {



			$table = WTable::get($this->dbtid);

			$uniqueModel = WModel::get('database.constraints');

			$pkey = $uniqueModel->getPK();

			$uniqueModel->setVal('namekey','UK_namekey_'.$table->getTableName());

			$uniqueModel->setVal('dbtid',$this->dbtid);

			$uniqueModel->setVal('type',1);

			$uniqueModel->returnId();

			$uniqueModel->insert();



			$constraintId = $uniqueModel->$pkey;

			$constraintItems = WModel::get('database.constraintsitems');

			$constraintItems->setVal($pkey,$constraintId);

			$constraintItems->setVal('dbcid',$this->dbcid);

			$constraintItems->insert();



			$message = WMessage::get();

			$message->userS('1418694571IHYF');



		}


	}














	private function _updateInterfaces() {



		
		if (empty($this->dbtid) || empty($this->_updatedColumn->name) || $this->_updatedColumn->name == $this->name) return;



		
		$models = WModel::get('library.model', 'object');

		$models->whereE('dbtid',$this->dbtid);

		$models->setLimit( 5000 );

		$linkedSid = $models->load('lra','sid');



		
		if ( empty($linkedSid) ) return;





		
		$total = 0;

		foreach($this->_modelToUpdate as $myModel) {

			$model = WModel::get($myModel);

			$model->setVal('map',$this->name);

			$model->whereE('map',$this->_updatedColumn->name);

			$model->whereIn('sid',$linkedSid);

			$model->update();

			$total = $total + $model->affectedRows();

		}


		if ( !empty($total) ) {

			$message = WMessage::get();

			$message->userS('1418694571IHYG',array('$total'=>$total));

		}


	}
















	private function _deleteInterfaces() {



		
		if (empty($this->_deletedColumn->name) OR empty($this->_deletedColumn->dbtid)) return;



		
		$models = WModel::get('library.model', 'object');

		$models->whereE('dbtid',$this->_deletedColumn->dbtid);

		$models->setLimit( 1000 );

		$linkedSid = $models->load('lra','sid');



		
		if ( empty($linkedSid) ) return;





		foreach( $this->_modelToUpdate as $myModel ) {



			$model = WModel::get( $myModel );

			$model->whereE('map', $this->_deletedColumn->name );

			$model->whereIn('sid',$linkedSid);

			$model->deleteAll();



		}


	}
}