<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');









class Translation_Populate_class extends WClasses {



















	public function updateTranslation($imac,$text,$langCode='en'){





		$language=WLanguage::get( $langCode, 'data' );

		if( empty($language)){

			$this->userE('1414850052DQVU');

			return false;

		}




		
		$populateModel=WModel::get( 'translation.populate' );


		$populateModel->makeLJ( 'library.columns', 'dbcid' );

		$populateModel->makeLJ( 'library.table', 'dbtid', 'dbtid', 1, 2 );

		$populateModel->select('dbtid',1);

		$populateModel->select('name',1);

		$populateModel->select('dbcid');

		$populateModel->whereE( 'imac', $imac );

		$populateModel->where( 'dbtid','>', 0, 1 );

		$populateModel->where( 'type','=', 20, 2 );	
		$populateModel->groupBy('dbcid');

		$populateFieldsA=$populateModel->load('ol');



		if( empty($populateFieldsA)) return false;



		
		$transTable=array();

		foreach( $populateFieldsA as $oneField){

			if( !isset($transTable[$oneField->dbtid])) $transTable[$oneField->dbtid]=array();

			$transTable[$oneField->dbtid][]=$oneField;

		}


		$this->_prepareUpdate( $transTable );





		
		foreach( $populateFieldsA as $oneField){



			if( empty( $this->allTables[$oneField->dbtid]->name )){

				$tableName=WModel::get( $oneField->dbtid, 'namekey' );


				continue;

			}




			if( empty($language->lgid)) continue;

			$languageCodeQuery=!empty( $language->code ) ? $language->code : 'en';

			$modelTranslation=WModel::get( 'translation.'. $languageCodeQuery );



			if( !method_exists($modelTranslation,'getTableID')) continue;



			$query='UPDATE IGNORE ' . $this->allTables[$oneField->dbtid]->name.' AS A LEFT JOIN ' . $tablePopulate . ' AS B ';

			$query .='ON A.`'.$this->allTables[$oneField->dbtid]->pkey.'`=B.`eid` AND B.`dbcid`=\''.$oneField->dbcid.'\' ';

			$query .='LEFT JOIN '.$modelTranslation->makeT().' AS C ON C.`imac`=B.`imac` ';

			$query .='SET A.`'.$oneField->name.'`=C.`text`, A.`auto`=C.`auto` ';

			$query .='WHERE ';



			
			if( $this->_dontForceInsert ) $query .='A.`auto` <=1 AND ';



			$query .='C.imac IS NOT NULL AND A.`lgid`='.$language->lgid;



			$populateModel->load( 'q',$query );







			


			
			
			
			$query='UPDATE IGNORE '.$this->allTables[$oneField->dbtid]->name.' AS A LEFT JOIN '.$this->allTables[$oneField->dbtid]->name.' AS B ';

			$query .='ON A.`'.$this->allTables[$oneField->dbtid]->pkey.'`=B.`'.$this->allTables[$oneField->dbtid]->pkey.'` AND B.`lgid`=1 ';

			$query .='SET A.`'.$oneField->name.'`=B.`'.$oneField->name.'` WHERE A.`lgid` !=1 AND B.`'.$oneField->name.'` !=\'\' AND (A.`'.$oneField->name.'` IS NULL OR A.`'.$oneField->name.'`=\'\')';


			$populateModel->load( 'q', $query );



		}






	}




















	private function _prepareUpdate($fields){

		$queries=array();



		if( empty($fields)) return false;



		


		
		$sqlForeignM=WModel::get( 'library.foreign' );


		$sqlForeignM->whereE( 'publish', 1 );

		$sqlForeignM->where( 'map','!=','lgid' );

		$sqlForeignM->where( 'map2','!=','lgid' );

		$sqlForeignM->whereIn( 'dbtid', array_keys($fields));

		$sqlForeignM->select( 'dbtid' );

		$sqlForeignM->select( 'ref_dbtid' );

		$sqlForeignM->groupBy( 'dbtid' );

		$tableHandle=$sqlForeignM->load( 'ol' );



		if( empty($tableHandle)){

			WMessage::log( $fields, 'translation-update-error' );

			return true;

		}


		foreach( $tableHandle as $oneTable){

			$loadDBTID[$oneTable->ref_dbtid]=$oneTable->ref_dbtid;

			$loadDBTID[$oneTable->dbtid]=$oneTable->dbtid;

		}


		$this->_loadAllTables( $loadDBTID );





		return true;



	}


















	private function _loadAllTables($loadDBTID){

		static $tableModel=null;



		if( !isset($tableModel)) $tableModel=WModel::get('library.table');

		$tableModel->whereIn( 'dbtid', $loadDBTID );




		$tableModel->select('pkey');

		$tableModel->select('dbtid');

		$tableModel->select('name',0,'tablename');

		$tableModel->setDistinct();

		$allTables=$tableModel->load('ol');






		foreach( $allTables as $myTable){


			$name='`'. JOOBI_DB_PREFIX . $myTable->tablename .'`';




			if( empty($this->allTables[$myTable->dbtid])) $this->allTables[$myTable->dbtid]=new stdClass;

			$this->allTables[$myTable->dbtid]->name=$name;



			$explode6=explode( ',', $myTable->pkey);

			$arraDiifA=array_diff( $explode6, array('lgid'));

			$this->allTables[$myTable->dbtid]->pkey=reset( $arraDiifA );



		}


	}




}
