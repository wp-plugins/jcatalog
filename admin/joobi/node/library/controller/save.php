<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class WController_save {

	private $_loadFileFieldNameA=array();	




	function save(&$localObj,$getlastId=false){
 		 		WTools::checkRobots();
		if( empty($localObj->sid)){
			return false;
		}

												$truc=WGlobals::get( 'trucs', array(), '', 'array' );
		if(empty($truc)) return false;
				$status=true;
		$localObj->_model=WModel::get( $localObj->sid );

		if( empty($localObj->_model)){
			return false;
		}
				$localObj->_model->setAudit();

		$fileTrucs=$this->getUploadedFiles();

				$this->_loadFileFieldNameA=WGlobals::get( 'laod-fild', array(), '', 'array' );			if( !empty($fileTrucs) && !empty($this->_loadFileFieldNameA)) $this->getTruc( $localObj, $this->getFilesInfo( $fileTrucs ));			else $this->getTruc( $localObj );
		if( $getlastId ) $localObj->_model->returnId(true);

		$processTags=WGlobals::get( 'tagsproz', 0, 'int' );
		if( $processTags==1){
			$localObj->processTags( $truc );
		}
								
		$savedStatus=$localObj->_model->save();
		if( $localObj->_model->_new){				$type='create';
		}else{
			$type='update';
		}
				$status=$localObj->showM( $savedStatus ,$type, 1, $localObj->sid );
				if( $localObj->getControllerSaveOrder() && $localObj->_model->getModelSaveOrder()){
			$this->_setOrder( $localObj );
		}

				$pKey=$localObj->_model->getPK();
		if( !empty($localObj->_model->$pKey)){
			$localObj->_eid=$localObj->_model->$pKey;
		}
		return $savedStatus;

	}




	function delete(&$localObj){

		if( empty($localObj->sid)){										$localObj->sid=WView::get( $localObj->yid, 'sid' );
			if( empty($localObj->sid)){
				$localObj->sid=WModel::get( str_replace('-','.', $localObj->controller), 'sid', null, false );
			}		}
		$localObj->_model=WModel::get( $localObj->sid );
		if( empty($localObj->_model)) return false;

				$localObj->_model->setAudit();


				if( $localObj->_model->multiplePK()){
			$myPKss=$localObj->_model->getPKs();
			if( !empty($myPKss)){
				foreach( $myPKss as $jpk){
					$valuePK=WForm::getPrev( $jpk );
										if( !empty($valuePK)){
						$localObj->_model->$jpk=$valuePK;
						$localObj->_model->whereE( $jpk, $valuePK );
					}else{
												return false;
					}				}			}
			$localObj->_model->delete();
						return true;

		}
		if( empty($localObj->_model)){
			return false;
		}
		if( !is_array($localObj->_eid)) return false;
		$status=true;

				$orderingExist=$localObj->_model->getParam('ordrg',false);

				if( $orderingExist){
			if( $localObj->_model->getParam('grpmap',false)){
				$groupingMap=$localObj->_model->getParam('grpmap');
				$groupingVal=$localObj->_model->load($localObj->_eid[0],$groupingMap);
			}else{
				$orderingExist=false;			}		}
				foreach( $localObj->_eid as $eid){
			if( !$localObj->_model->delete( $eid )){
				$status=false;
			}		}
						WGlobals::setEID( 0 );

				$nb=sizeof( $localObj->_eid );

		if( $orderingExist){
			$localObj->_model->$groupingMap=$groupingVal;
			$this->_setOrder( $localObj );
		}
						return $localObj->showM( $status , 'delete', $nb, $localObj->sid );

	}




	function deleteall(&$localObj){

		if( empty($localObj->sid)){										if( !empty($localObj->yid)) $localObj->sid=WView::get( $localObj->yid, 'sid', null, null, false );
			if( empty($localObj->sid)){
				$localObj->sid=WModel::get( str_replace('-','.', $localObj->controller), 'sid', null, false );
			}		}

				$localObj->_model=WModel::get( $localObj->sid );
		if( !isset($localObj->_model)) return false;
		if( !is_array($localObj->_eid)) return false;
		$status=true;

				$localObj->_model->setAudit();

				foreach( $localObj->_eid as $eid){
			$status=( $localObj->_model->deleteAll( $eid ) && $status );
			if( !$status ) break;			}
						WGlobals::setEID( 0);

						$orderingExist=$localObj->_model->getParam('ordrg',false);

		$nb=sizeof( $localObj->_eid );

				if( $orderingExist){
			$this->_setOrder( $localObj );
		}
						$localObj->showM( $status ,  'delete', $nb, $localObj->sid );
		return true;

	}




	function copy(&$localObj){

		$nd=$qSet=null;
		$status=true;
		$errId=array();
		$nb=0;

		if( !empty($localObj->_eid)){
						$localObj->_model=WModel::get( $localObj->sid );
			if( empty($localObj->_model)) return false;

						$localObj->_model->setAudit( 'copy' );


			if( is_array($localObj->_eid)){

				foreach( $localObj->_eid as $key=> $value){

					$value=(int)$value;
					if( !$localObj->_model->copy( $value )){
						$status=false;
						$errId[]=$value;
					}					$nb++;
				}
			}
			$nb=sizeof( $localObj->_eid );
			$errText=implode( '  ', $errId );

									WGlobals::setEID( 0 );

						$orderingExist=$localObj->_model->getParam('ordrg',false);
						if( $orderingExist){
				$this->_setOrder( $localObj );
			}
						$localObj->showM( $status , 'copy', $nb, $localObj->sid );
			return true;
		}
	}



	function copyall(&$localObj){

		if( !is_array($localObj->_eid)) return false;

		$localObj->_model=WModel::get( $localObj->sid );
		if( empty($localObj->_model)) return false;

				$localObj->_model->setAudit( 'copy' );


		$status=true;
				foreach( $localObj->_eid as $eid){
					if( !$localObj->_model->copyAll( $eid )){
				$status=false;
			}		}
				$nb=sizeof( $localObj->_eid );

						WGlobals::setEID( 0);

		$orderingExist=$localObj->_model->getParam('ordrg',false);

				if( $orderingExist){
			$this->_setOrder( $localObj );
		}
		$localObj->showM( $status , 'copy', $nb, $localObj->sid );
		return true;
	}







	function getTruc(&$localObj,$anotherArray=array()){
				$trucs=WGlobals::get( 'trucs', array(), '', 'array' );

				static $checkedEditors=false;

		if( !$checkedEditors){

			$checkedEditors=true;
			$editors=WGlobals::get( 'joobieditors', null, 'POST' );

			if( !empty($editors)){
				$editorClass=WClass::get( 'editor.get' );
				foreach( $editors as $editorName=> $fieldInfos){
					foreach($fieldInfos as $fieldName=> $realField){
						$fieldArgs=explode( '[', str_replace(']', '', $realField ));
						if(count($fieldArgs)==4){
							$trucs[$fieldArgs[1]][$fieldArgs[2]][$fieldArgs[3]]=$editorClass->getEditorContent( $editorName, $fieldName );
						}else{
							$trucs[$fieldArgs[1]][$fieldArgs[2]]=$editorClass->getEditorContent( $editorName, $fieldName );
						}					}				}
								WGlobals::set( 'trucs', $trucs, 'POST' );
			}
		}
		
		if( empty($trucs)) return true;
		$key=array_keys( $trucs );
		$truc=$trucs[ $key[0] ];

				if( !empty($anotherArray)){
			foreach( $anotherArray as $anotherArrayKey=>$anotherArrayVal){
				$trucs[$anotherArrayKey]['wfiles']=$anotherArrayVal['wfiles'];
			}		}
		$modelNamkey=WModel::get( $localObj->sid, 'namekey');
		if( empty($modelNamkey)) return ;

		$extraSID=WGlobals::get( 'mlt-s_extra', array());

				if( !empty($extraSID)){
			foreach( $extraSID as $extrakey=> $extraValA){

				foreach( $extraValA as $extraval){
										if( substr( $extraval, 1, 1)=='['){
						$typeMap=substr( $extraval, 0, 1);
						$realMap=substr( $extraval, 2, -1 );

						if( !isset($trucs[$extrakey][$typeMap][$realMap])){
							$trucs[$extrakey][$typeMap][$realMap]=array();
						}
					}else{
						if( !isset($trucs[$extrakey][$extraval])){
							$trucs[$extrakey][$extraval]=array();
						}					}
				}
			}
						$localObj->_model->_mlt_s_extra=$extraSID;

		}

		$securityCheck=array();
		if( !empty($this->_loadFileFieldNameA)){
						$securityFieldA=array();
			foreach( $this->_loadFileFieldNameA as $fieldk=> $fieldv){
				foreach( $fieldv as $fieldk2=> $fieldv2){
					$securityFieldA[]=$fieldk . '_' . $fieldv2;
					unset( $trucs[$fieldk][$fieldv2] );					}			}			sort( $securityFieldA );
			$securityCheck['sec']=$securityFieldA;

		}

		$modelTempM=WModel::get( $modelNamkey );
		$FileinfoA=( !empty($modelTempM->_fileInfo)) ? $modelTempM->_fileInfo : array();

		foreach( $trucs as $tSid=> $tporperty){
			if( $tSid=='s' ) continue;
			ksort($tporperty);
						if( !empty($tSid)){
				$tporperty2=$tporperty;
				if( $tSid=='x' ) $tporperty2='';				if( isset($tporperty2['x'])) unset( $tporperty2['x'] );					if( isset($tporperty2['m'])) unset( $tporperty2['m'] );
				if( isset($tporperty2['f'])) unset( $tporperty2['f'] );
				if( isset($tporperty2['wfiles'])) unset( $tporperty2['wfiles'] );
				if( empty($FileinfoA)) foreach( $FileinfoA as $$FileinfoAK=> $FileinfoAV ) if( isset($tporperty2[$FileinfoAK])) unset( $tporperty2[$FileinfoAK] );
				if( !empty($tporperty2)) $securityCheck[$tSid]=array_keys($tporperty2);
			}
			if( $localObj->sid==$tSid && isset($localObj->_model)){
					$localObj->_model->addProperties( $tporperty );
			}elseif( $tSid!=0){

				$childName='C'. $tSid;

				if( !isset($localObj->_model)) $localObj->_model=new stdClass;
				if( !isset($localObj->_model->$childName)) $localObj->_model->$childName=new stdClass;

				foreach( $tporperty as $ppKey=> $ppval){
					$localObj->_model->$childName->$ppKey=$ppval;
				}
			}
		}
		if( $localObj->checkSecureForm && PLIBRARY_NODE_CKFRM && PLIBRARY_NODE_SECLEV > 1){

			ksort($securityCheck);

						$newElement=( !empty($trucs['s']['new']) ? $trucs['s']['new'] : 0 );
			if( $newElement){
				$eid=array();
			}else{
				$eid=WGlobals::getEID( true );
			}
			$securityCheck['eid']=empty($eid) ? '0' : serialize($eid);			$formSecure=( !empty($trucs['s']['cloud'] ) ? $trucs['s']['cloud'] : '' );

			if( !WTools::checkSecure( $securityCheck, $formSecure )){
				$message=WMessage::get();
					$message->exitNow('A security error occurred. It might happen when you keep a window open for too long. Please reload your page.');

			}
		}

	}












	function getFilesInfo($trucs=null){

		if( !isset($trucs)) $trucs=WGlobals::get( 'trucs', array(), 'FILES', 'array' );

		$requestTrucs=WGlobals::get('trucs');
		$formType=$requestTrucs['s']['ftype'];

		$mapArray=array();
		$fileArray=array();
		$errorFile=array();
						foreach( $trucs as $fileParams=> $values){

			if( !empty($values)){
				$i=0; 					foreach( $values as $sidKey=> $sidValue){
										foreach( $sidValue as $sidValueK=> $sidValueV){
						if( $fileParams=='error' && $sidValueK!=0){															$errorFile[$sidKey]=$sidValueK;
							break;
						}					}
					if( $formType){

						foreach( $sidValue as $key1=> $valueFinal){
							$mapArray[$key1]=true;
							if( is_array( $valueFinal )){
								$arrayKey=key($valueFinal);
								$name=$arrayKey;
								$val=$valueFinal[$arrayKey];
							}else{
								$name=$key1;
								$val=$valueFinal;
							}							if( !isset($fileArray[$sidKey]['wfiles'][$name][$i])) $fileArray[$sidKey]['wfiles'][$name][$i]=new stdClass;
							$fileArray[$sidKey]['wfiles'][$name][$i]->$fileParams=$val;
							$fileArray[$sidKey]['wfiles'][$name][$i]->map=$name;
							$fileArray[$sidKey]['wfiles'][$name][$i]->multiple=true;

							$i++;	
						}
					}else{

						foreach( $sidValue as $key1=> $valueFinal){

							if( is_array( $valueFinal )){
								$arrayKey=key($valueFinal);
								$name=$arrayKey;
								$val=$valueFinal[$arrayKey];
							}else{
								$name=$key1;
								$val=$valueFinal;
							}							if( !isset($fileArray[$sidKey]['wfiles'][$name][$i])) $fileArray[$sidKey]['wfiles'][$name][$i]=new stdClass;
							$fileArray[$sidKey]['wfiles'][$name][$i]->$fileParams=$val;
							$fileArray[$sidKey]['wfiles'][$name][$i]->map=$name;
							$fileArray[$sidKey]['wfiles'][$name][$i]->multiple=true;

							$i++;	
						}
					}
				}
			}		}
				if( !empty($errorFile)){
			foreach( $errorFile as $myfileerrorK=> $myfileerrorV){
				unset( $fileArray[$myfileerrorK]['wfiles'][$myfileerrorV] );
			}		}
		return $fileArray;

	}





	public function getUploadedFiles(){
		$fileTrucs=array();
				$filesFancyuploadC=WClass::get( 'files.fancyupload' );
		$fancyFileUpload=$filesFancyuploadC->check();
		if( $fancyFileUpload){

			$axFilesA=WGlobals::get( 'ax-uploaded-files', array(), 'request', 'array' );
			if( !empty( $axFilesA )){

				foreach( $axFilesA as $asMap=> $oneFileAx){

					$asMapA=explode( '_', $asMap );
					$axModelID=$asMapA[0];
					$axMapID=$asMapA[1];
					if( !is_array($oneFileAx)) $oneFileAx=array( $oneFileAx );

					foreach( $oneFileAx as $oneFileValeu){

						if( empty($oneFileValeu)) continue;
												$fileValues=json_decode( stripslashes( $oneFileValeu ));
						if( empty($fileValues)) continue;

						$fileTrucs['name'][$axModelID][][$axMapID]=$fileValues->name;
						$fileTrucs['type'][$axModelID][][$axMapID]=$fileValues->type;
						$fileTrucs['tmp_name'][$axModelID][][$axMapID]=JOOBI_DS_TEMP . 'uploads' . DS . $fileValues->name;
						$fileTrucs['error'][$axModelID][][$axMapID]=0;
						$fileTrucs['size'][$axModelID][][$axMapID]=$fileValues->size;

					}
				}			}
		}else{
			$fileTrucs=WGlobals::get( 'trucs', array(), 'FILES', 'array' );
		}
		return $fileTrucs;

	}




	private function _setOrder(&$localObj){
		
						$orderSID=$localObj->_model->getModelID();

			$groupings=array();
			if( $localObj->_model->getParam('ordg',false))
				return;
			$groupingMap=$localObj->_model->getParam('grpmap');

			$pKeys=$localObj->_model->getPKs();
			if( $localObj->_model->multiplePK()){
				$arraDiff=array_diff( $pKeys, array($groupingMap));
				$pKey=reset( $arraDiff );
			} else  $pKey=$localObj->_model->getPK();

			if( !isset($localObj->_model->$groupingMap)){
				return;			}			$localObj->_model->select( 'ordering' );
			$localObj->_model->orderBy( 'ordering' );
			$localObj->_model->whereE( $groupingMap,  $localObj->_model->$groupingMap );
			$localObj->_model->setLimit( 5000 );
			$values=$localObj->_model->load( 'ol',$pKeys);

			if( empty($values)) return;
						$localObj->_order=array();
			$localObj->_eid=array();
			foreach( $values as $value){
				$localObj->_order[]=$value->ordering;
				$localObj->_eid[]=$value->$pKey;
			}
			$localObj->_groupingValue=$localObj->_model->$groupingMap;

			$localObj->saveorder();

	}






	private function _verifySpoof(){
				if( WRoles::isNotAdmin( 'manager' )){
			$spoof_type=WGlobals::get( 'wz_sp_type');
			$token	=WPage::getSpoof($spoof_type);
			if( !WGlobals::get( $token, 0, 'post' ))
				return false;
		}		return true;
	}

}