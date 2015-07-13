<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Translation_Language_picklist extends WPicklist {








	function create(){



		$model=WModel::get( 'library.languages');



		if( isset( $this->wval1 ) && $this->wval1==5){

		}else{

			
			$model->whereE('publish',true);

		}
		$model->setLimit( 500 );

		$results=$model->load( 'ol', array('lgid', 'name', 'real'));



		
		if( !$this->onlyOneValue()){

			
			
			$eid=WGlobals::getEID();



			
			$lgid=( !empty($eid) ? WUser::get('lgid', $eid) : WUser::get('lgid'));



			$this->setDefault( $lgid, true );

			
			foreach($results as $result){

				$this->addElement( $result->lgid , $result->name.' ('.$result->real.')' );

			}
		}else{



			$defaults=$this->getDefault();

			
			foreach( $results as $res){

				if( $res->lgid==$defaults ) $result=$res;

			}


			
			if( empty($result)) return '';

			$cont=$result->name.' ('.$result->real.')';

			$this->addElement('' , $cont );

			return true;

		}




   }}