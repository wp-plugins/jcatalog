<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

























 class WController_save_preferences {











	public function savepref(&$localObj){



 		
 		WTools::checkRobots();



		if( isset($localObj->_dontCallSave)) return true;




		$status=true;

		$this->_loadFromTruc( $localObj );



		
		if( !empty($localObj->generalPreferences)){

			$status=$this->_saveCurrentPref( $localObj->generalPreferences, 'updatePref' );	
		}


		
		if( $status && !empty($localObj->userPreferences)){



			$status=$this->_saveCurrentPref( $localObj->userPreferences, 'updateUserPref' );	
		}


		
		$cache=WCache::get();

		$cache->resetCache( 'Preference' );



		
		return $localObj->showM( $status , 'save', 1, null, WText::t('1241490506ODOB'));	


	}

















































































	private function _loadFromTruc(&$localObj){



		$trucs=WGlobals::get( 'trucs', array(), '', 'array' );

		
		$localObj->generalPreferences=array();

		$localObj->userPreferences=array();

		if( empty($trucs)) return false;






		$editors=WGlobals::get( 'joobieditors', null, 'POST' );

		if( !empty($editors)){

			$editorClass=WClass::get( 'editor.get' );

			foreach( $editors as $editorName=> $fieldInfos){

				foreach( $fieldInfos as $fieldName=> $realField){

					$fieldArgs=explode( '[', str_replace(']', '', $realField ));

					if(count($fieldArgs)==4){

						$trucs[$fieldArgs[1]][$fieldArgs[2]][$fieldArgs[3]]=$editorClass->getEditorContent( $editorName, $fieldName );

					}else{

						$trucs[$fieldArgs[1]][$fieldArgs[2]]=$editorClass->getEditorContent( $editorName, $fieldName );

					}
				}
			}


		}




			if( isset( $trucs['c'] )){



				$localObj->generalPreferences=$this->_mergePreferences( $localObj->generalPreferences, $trucs['c'] );


			}
			if( isset($trucs['u'])){

				$localObj->userPreferences=$this->_mergePreferences( $localObj->userPreferences, $trucs['u'] );

			}





		$mltExtraA=WGlobals::get( 'mlt-s_extra' );

		if( !empty($mltExtraA)){

			foreach( $mltExtraA as $oneA){

				foreach( $oneA as $pref){

					$type=substr( $pref, 0, 1 );

					$PrefA=explode( '][', substr( $pref, 2, -1 ));

					if( count($PrefA) < 2){


						continue;

					}
					if( 'c'==$type){

						if( !isset( $localObj->generalPreferences[$PrefA[0]][$PrefA[1]] )){

							$localObj->generalPreferences[$PrefA[0]][$PrefA[1]]='';

						}
					}else{

						if( !isset( $localObj->userPreferences[$PrefA[0]][$PrefA[1]] )){

							$localObj->userPreferences[$PrefA[0]][$PrefA[1]]='';

						}
					}
				}
			}
		}






	}
















	private function _mergePreferences($currentA,$extraA){

		$merged=array();





		if( !empty($currentA)){



			foreach( $currentA as $key=> $val){

				
				if( isset($extraA[$key])){

					$merged[$key]=array_merge( $currentA[$key], $extraA[$key] );

				}else{

					$merged[$key]=$currentA[$key];

				}
			}


		}





		
		foreach( $extraA as $key=> $val){

			
			if( is_array($val) && !empty($val)){

				WPref::get( $key );

				$nodeName=str_replace( '.', '_', $key );



				foreach( $val as $subKey=> $subVal){

					$preName='P' . strtoupper( $nodeName . '_' . $subKey );




					if( !isset($merged[$key][$subKey])) $merged[$key][$subKey]=$extraA[$key][$subKey];

				}


			}
		}





		return $merged;



	}
















	private function _saveCurrentPref($myPreference,$fctName){

		static $preference=null;



		foreach( $myPreference as $key=> $values){


			$realKey=strtolower( $key );

			WPref::get( $realKey );

			$realKey2=str_replace( '.', '_', $realKey );

			$external[$realKey]=true;



			foreach( $values as $property=> $val){



				$mypref='P' . strtoupper( $realKey2 . '_' . $property );



				
				if( is_array($val)){

					$val=implode( '|_|', $val );

				}





				if( !empty($property) &&


					 ( WPref::load( $mypref ) !=$val )	
					){



					if( !isset($preference)){

						$preference=new myPreferences(); 
						
						$preference->setAudit();



					}


					$preference->setup( $realKey );

					
					
					if( ! $preference->$fctName( $property, $val )){


					}
				}
			}
		}


		return true;



	}











































 }
