<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Apps_Roles_picklist extends WPicklist {














	function create(){



		static $myPicklist=array();

		$sql=WModel::get( $this->sid ); 




		
		$transNameModel=$sql->getModelNamekey().'trans';



		
		$parent=array();

		$parent['pkey']=$sql->getPK();

		$parent['parent']='parent';

		$parent['name']='name';

		if( !isset($myPicklist[$transNameModel])){



			$modelRef=WModel::get( 'library.model', 'object' );

			$modelRef->whereE( 'namekey', $transNameModel );

			if( $modelRef->exist()){	
				$sql->makeLJ( $transNameModel, $sql->getPK());

				
				$sql->whereLanguage( 1 );

				$sql->select($parent['name'], 1);	
			}else{

				$sql->select($parent['name']);	
			}


			
			$sql->select($parent['parent']);	
			$sql->orderBy( $parent['parent'] );

			$sql->select( $sql->getPK());  
			$sql->whereE('type','1'); 
			$sql->setLimit( 500 );

			$myitems=$sql->load('ol');

			$childOrderParent=array();

			$list=WOrderingTools::getOrderedList( $parent, $myitems, 1, true, $childOrderParent );

			$myPicklist[$transNameModel]=$list;

		}


		foreach( $myPicklist[$transNameModel] as $itemList){

			$this->addElement(  $itemList->$parent['pkey'], $itemList->$parent['name']);

		}


	}
}