<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class WListing_Coreorder extends WListings_default{






	public function createHeader(){
				if( empty($this->element->align)) $this->element->align='center';
		if( empty($this->element->width)) $this->element->width='16px';
				return false;
	}





	function create(){

		static $myReferenceIdTable=array();

				if( isset($this->orderingMap)) $orderingMap=$this->orderingMap;
		$orderingByGroup=( isset($this->orderingByGroup)) ? $this->orderingByGroup : 'ordering_' . $this->modelID;

				if( empty($myReferenceIdTable)) $myReferenceIdTable=$this->myReferenceIdTable;

		if( $this->categoryRoot){				$jj=$this->i+1;
			$parentMapKey=$this->myParent['parent'];
			$orderingMapKey=$this->myParent['ordering'];
			$indexMinus=@$this->childOrderParent[$this->data->$parentMapKey][$this->data->$orderingMapKey - 1];
			$indexPlus=@$this->childOrderParent[$this->data->$parentMapKey][$this->data->$orderingMapKey + 1];

		}else{				$jj=$this->i;
			$indexMinus=@$myReferenceIdTable[$jj-1];
			$indexPlus=@$myReferenceIdTable[$jj+1];
		}
		$htmlData='';
		if( !empty( $this->data->$orderingMap )){

									$taskUp=(@$this->data->$orderingMap < @$this->listData[$indexMinus]->$orderingMap) ? 'orderdown' : 'orderup';
			$taskDown=(@$this->data->$orderingMap > @$this->listData[$indexPlus]->$orderingMap) ? 'orderup' : 'orderdown';


				$enabled=true;
					$htmlData .='<div style="float:left;">'. $this->_orderIcon( $this->i, $this->nb, (@$this->data->$orderingByGroup==@$this->listData[$indexPlus]->$orderingByGroup), $taskDown, $enabled, $this->formName ) . '</div>';

			$disabled=$this->currentOrder==$orderingMap ?  '' : 'disabled="disabled" ';
			$htmlData .= '<div style="float:left;"><input type="text" name="order[]" size="3" value="' . @$this->data->$orderingMap.'" ' . $disabled.' class="'.$disabled.'" style="text-align: center" /></div>';

			$htmlData .='<div style="float:left;">' . $this->_orderIcon( $this->i, $this->nb, (@$this->data->$orderingByGroup==@$this->listData[$indexMinus]->$orderingByGroup), $taskUp, $enabled, $this->formName) . '</div>';


		}
		$this->content='<div style="display:inline-flex;">' . $htmlData . '</div>';
		return true;

	}












	private function _orderIcon($i,$n,$condition=true,$task='orderdown',$enabled=true,$formName=''){
		static $downGreen=array();
		static $downGray=array();
		static $jsNamekeyA=array();

		if( $task !='orderdown'){
			$taskDir='up';
			$alt=WText::t('1242282450QJCO');
			$complexCondition=(($i > 0 || ($i + $this->limitstart > 0)) && $condition );
		}else{
			$taskDir='down';
			$alt=WText::t('1242282450QJCN');
			$complexCondition=(($i < $n -1 || $i + $this->limitstart < $this->total - 1) && $condition );
		}

		$html='&nbsp;';
		if( $complexCondition){
			if( $enabled){

				if( empty($jsNamekeyA[$taskDir])){
					if( WGet::isDebug()){
						$jsNamekeyA[$taskDir]='Order' . $taskDir . '_' . WGlobals::filter( $formName . '_' . $task . '_' . $taskDir, 'jsnamekey' );
					}else{
						$jsNamekeyA[$taskDir]='WZY_' . WGlobals::count('f');
					}				}
								$joobiRun=WPage::actionJavaScript( $task, $formName, array( 'zsid'=> $this->element->sid, 'zact'=> $taskDir, 'lstg'=>true ), 'em' . $i, $jsNamekeyA[$taskDir], 'order' );

				$html	='<a href="#" onclick="' . $joobiRun . '" title="' . $alt . '">';

				if( !isset( $downGreen[$taskDir] )){
					$legendO=new stdClass;
					$legendO->sortUpDown=true;
					$legendO->action=$taskDir . 'Green';
					$legendO->alt=$alt;
					$downGreen[$taskDir]=WPage::renderBluePrint( 'legend', $legendO );
				}
				$html .=$downGreen[$taskDir];
				$html	.='</a>';
			}else{
				if( !isset( $downGray[$taskDir] )){
					$legendO=new stdClass;
					$legendO->sortUpDown=true;
					$legendO->action=$taskDir . 'Gray';
					$legendO->alt=$alt;
					$downGray[$taskDir]=WPage::renderBluePrint( 'legend', $legendO );
				}				$html=$downGray[$taskDir];
			}		}else{
			$html='<div style="width:25px;">&nbsp;</div>';
		}
		return $html;

	}





	public function advanceSearch(){
		return false;
	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null){
	}

}


