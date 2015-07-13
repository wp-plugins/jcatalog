<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



class Design_Column_class extends WClasses {



















	public function createColumn($sid,$fieldid,$columnName,$dbcid=0) {



		if ( empty($sid) || empty($fieldid) ) return false;



		
		$designFieldsC = WClass::get( 'design.fields' );

		$designColumnsM = $designFieldsC->loadDefaultColumn( $fieldid );



		
		$modelM = WModel::get( $sid );

		$columnExists = $modelM->columnExists( $columnName );

		if ( $columnExists ) {

			
			$COLUMNNAME = $columnName;

			$this->userE('1369750859IGJB',array('$COLUMNNAME'=>$COLUMNNAME));

			WPages::redirect( 'controller=design-model-fields&task=add&sid=' . $sid );

		}



		if ( !empty($dbcid) ) $designColumnsM->dbcid = $dbcid;

		$designColumnsM->name = $columnName;

		$designColumnsM->dbtid = WModel::get( $sid, 'dbtid' );

		$designColumnsM->returnId();

		$status = $designColumnsM->save();



		if ( $status ) return $designColumnsM->dbcid;

		else return false;



	}




















	public function getColumnID($sid,$columnName) {



		if ( empty($sid) || empty($columnName) ) return false;



		$designColumnsM = WModel::get( 'design.columns' );

		$dbtid = WModel::get( $sid, 'dbtid' );

		$designColumnsM->whereE( 'dbtid', $dbtid );

		$designColumnsM->whereE( 'name', $columnName );

		return $designColumnsM->load( 'lr', 'dbcid' );



	}




















	public function updateColumn($sid,$fieldid,$columnName,$dbcid) {



		if ( empty($sid) || empty($fieldid) ) return false;



		
		$designFieldsC = WClass::get( 'design.fields' );

		$designColumnsM = $designFieldsC->loadDefaultColumn( $fieldid );


		$designColumnsM->dbcid = $dbcid;

		$designColumnsM->name = $columnName;

		$designColumnsM->dbtid = WModel::get( $sid, 'dbtid' );

		$status = $designColumnsM->save();





		return $status;



	}




}