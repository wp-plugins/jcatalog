<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
 defined('JOOBI_SECURE') or die('J....');











class Events_Access_picklist extends WPicklist {






function create(){

	static $list=null;



	if( !isset($list)){

		$sql=WModel::get( 'role' ); 


		
		$parent=array();

		$parent['pkey']='rolid';

		$parent['parent']='parent';

		$parent['name']='name';



		$sql->makeLJ( 'roletrans', 'rolid');

		
		$sql->whereLanguage(1);

		$sql->select('name', 1);	


		$sql->orderBy( 'lft','ASC' );

		$sql->select( 'rolid' );  
		$sql->select('parent');



		$sql->where('type','!=','2');

		$myitems=$sql->load('ol');



		$childOrderParent=array();

		$list=WOrderingTools::getOrderedList( $parent, $myitems, 1, false, $childOrderParent );



	}


	$this->addElement(0, WText::t('1250145257BXGB'));

	foreach( $list as $itemList){

		$this->addElement($itemList->rolid, $itemList->name);

	}
}}