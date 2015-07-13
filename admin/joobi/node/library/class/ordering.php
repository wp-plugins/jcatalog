<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














abstract class Library_Ordering_class {












	public static function getOrderedList($parent,$data,$type=1,$categoryRoot=false,&$childOrderParent,$reassignParent=true){
						$children=array();
		$gotParent=false;

		WGlobals::set( 'getOrderedList', true, 'global' );

				if( $reassignParent){

			$reassignedParentID=0; 
						$parentList=array();
			$itemList=array();
			foreach($data as $value){
				$parentList[$value->$parent['parent']]=true;
				$itemList[$value->$parent['pkey']]=true;
			}
			$parentDoesNOTExist=array();
			if( !empty($parentList)){
				unset( $parentList[0] );
				foreach( $parentList as $oneParentList=> $valNOTUSED){
					if( !in_array($oneParentList, array_keys($itemList)) ) $parentDoesNOTExist[$oneParentList]=true;
				}			}			if( !empty($parentDoesNOTExist)) $parentDoesNOTExist=array_keys($parentDoesNOTExist);
			else $reassignParent=false;	
		}
				foreach($data as $value){

			$pt=$value->$parent['parent'];
			if( $pt > 0 ) $gotParent=true;

						if( $reassignParent){
				if( in_array( $pt, $parentDoesNOTExist)) $pt=$reassignedParentID;
			}			$list=@$children[$pt] ? $children[$pt] : array();
			array_push( $list, $value );
			$children[$pt]=$list;

		}


		if( !isset($children[0])){	
						if( !isset($parent['ordering']))  $parent['ordering']=$parent['name'];

						if( empty($data[0])){
				return $data;
			}
						$myParentValue=$data[0]->$parent['parent'];

						$parentIDTable=array();
			$newArray=array();
			$newArrayAlreadyUsedID=array();
			$totalItm=count( $data );
			foreach( $data as $nonKey=> $child){
				$parentIDTable[$child->$parent['pkey']]=$child->$parent['parent'];
			}
						foreach( $data as $nonKey=> $child){

				$myParentValue=$child->$parent['parent'];

								$ct=0;
				while ( isset($parentIDTable[$myParentValue]) && $parentIDTable[$myParentValue] !=0 && $ct <=$totalItm){
					$ct++;
					$myParentValue=$parentIDTable[$myParentValue];
				};

												if( $myParentValue!=0 && !isset($newArrayAlreadyUsedID[$myParentValue])){

					$gostItem=new stdClass;
					$newArrayAlreadyUsedID[$myParentValue]=true;
					$gostItem->$parent['pkey']=$myParentValue;
					$gostItem->$parent['name']='';
					$gostItem->$parent['parent']=0;
					$gostItem->$parent['ordering']=1;
					$gostItem->ghost87=true;							$newArray[0][]=$gostItem ;
					$parentIDTable[$myParentValue]=0;

				}
			}
			foreach( $children as $childKey=> $child){
				$newArray[$childKey]=$child;
			}
			$children=$newArray;

		}
		$totalIndent=0;
						if( $gotParent ) $list=WOrderingTools::treeRecurse( $parent, 0, '', array(), $children, 999, 0, $type, $categoryRoot, $childOrderParent, $totalIndent );
		else $list=$data;

		return $list;

	}














	public static function treeRecurse($parent,$id,$indent,$list,&$children,$maxlevel=999,$level=0,$type=1,$categoryRoot=false,&$childOrderParent,$totalIndent){

		$spacerCharacter='¦';

		if( isset($children[$id]) && $level <=$maxlevel){
			$spacer='';
			$noIndent=false;
			if( $categoryRoot){
				$myTest=$children[$id][0]->$parent['parent'];
				if( $myTest=='1'){
						$noIndent=true;
						$spacer='&nbsp; ';
				}elseif( $myTest=='0'){
					$noIndent=true;
				}			}
			if( $type==2 || $noIndent){
				$pre 	='';
				$spacer .='';
				$indent='';
			}elseif( $type==1){
				$pre 	='¦&nbsp;&nbsp; ';					$spacer=$spacerCharacter . '&nbsp;&nbsp; ';				}else{
				$pre 	='- ';
				$spacer='&nbsp; ';				}
			foreach($children[$id] as $v){
				if( isset($parent['ordering'])) $childOrderParent[$v->$parent['parent']][$v->$parent['ordering']]=$v->$parent['pkey'];

				$id=$v->$parent['pkey'];
				if( !isset($v->$parent['name'])){
					continue;
				}
				if( $v->$parent['parent']==0){
					$txt=$v->$parent['name'];
				}else{
					$txt=$pre . $v->$parent['name'];
				}
				$pt=$v->$parent['name'];
				$list[$id]=$v;
				$list[$id]->$parent['name']="$indent$txt";


								$list[$id]->indentTreeNumber=$totalIndent;

				$nextCountIndent=$totalIndent + 1;
				$nextIndent=$indent . $spacer;


				if( !isset($list[$id])){
										$keys=array_keys($list);
					$parentID=array_shift($keys);

					$gostItem=new stdClass;
					$gostItem->$parent['pkey']=$parentID;
					$gostItem->$parent['name']='';
					$gostItem->$parent['oredering']=99;
					$gostItem->$parent['parent']=0;								$gostItem->ghost87=true;		
					$newArray=array();
					$newArray[$id]=array( $gostItem );
					foreach( $list as $childKey=> $child){
						$newArray[$childKey]=$child;
					}
					$list=$newArray;

				}
				$list=WOrderingTools::treeRecurse( $parent, $id, $nextIndent, $list, $children, $maxlevel, $level+1, $type, $categoryRoot, $childOrderParent, $nextCountIndent );

			}
		}
		return $list;

	}
}