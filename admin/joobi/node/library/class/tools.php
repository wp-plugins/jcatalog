<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class WTools {























	public static function format($value,$format='decimal',$unit=null,$decimal=null,$useStyle=false,$className=''){

		WLoadFile( 'library.class.format' );
		return Library_Format_class::format( $value, $format, $unit, $decimal, $useStyle, $className );

	}









	public static function dateFormat($type,$timeZoneIdentifier=false){

				$use24Format=WPref::load( 'PMAIN_NODE_DATEFORMAT' );
		$hour=( WPref::load( 'PMAIN_NODE_DATEFORMAT' ) ? 'H' : 'h' );
		$am=( WPref::load( 'PMAIN_NODE_DATEFORMAT' ) ? '' : 'A' );

		switch( $type){
			case 1:
			case 'day-date':
				$format='l, j F Y';
				break;
			case 2:
			case 'day-date-time':
				$format='l, j F Y ' . $hour . ':i' . $am;
				break;
			case 4:
			case 'date-number':
				$format='d.m.y';
				break;
			case 5:
			case 'date-time':
				$format='j F Y ' . $hour . ':i' . $am;
				break;
			case 6:
			case 'date-time-number':
				$format='d.m.y ' . $hour . ':i' . $am;
				break;
			case 7:
			case 'date-short':
				$format='j M y';
				break;
			case 8:
			case 'date-time-short':
				$format='j M y ' . $hour . ':i' . $am;
				break;
			case 15:
			case 'date-time-second':
				$format='j M y ' . $hour . ':i' . $am;
				break;
			case 9:
			case 'time-unix':
				$format='Y-m-d ' . $hour . ':i:s' . $am;
				break;
			case 16:
			case 'day-month':
				$format='j F';
				break;
			case 17:
			case 'time-min':
				$format='' . $hour . ':i' . $am;
				break;
			case 3:
			case 'date':
			default:
				$format='j F Y';
				break;

		}
		if( $timeZoneIdentifier){
			$tmZoneSymoblBp='T';				$format .=' (' . $tmZoneSymoblBp .')';
		}
		return $format;

			
		

	}








	public static function randomString($length=8,$special=false){

		$salt='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		if( $special ) $salt .='%^&$*+-_?::,.{}[]()';
		$len=strlen($salt);
		$makepass='';
		mt_srand( 10000000 * (double) microtime());

		for($i=0; $i < $length; $i ++){
			$makepass .=$salt[mt_rand(0, $len -1)];
		}
		return $makepass;

	}







	public static function checkRobots(){
		static $alreadyDone=false;
		if($alreadyDone) return;

		$alreadyDone=true;
				if( preg_match('#.*(libwww-perl|python).*#i',$_SERVER['HTTP_USER_AGENT'] )){
			$message=WMessage::get();
			$message->exitNow('Robots are not allowed on this page');
		}	}





	public static function strtotime($time,$useTimeZone=true){
		static $timezone=null;
		if( !isset($timezone)){
					$timezone=WUser::timezone();
		}
		if( !is_numeric($time)) $time=strtotime( $time );
		if( $useTimeZone ) $time=$time + $timezone;
		return $time;
	}









	public static function durationToString($duration=null,$ago=false){

		if( $duration < 0){
			$duration=-1 * $duration;
			$changeSign=true;
		} else $changeSign=false;

		$time=time();
		if( !isset($duration)) $duration=time(); 		if( $ago){
	        if( $time > $duration){
	        	$duration=$time - $duration;		        }else{
	        	$duration=$duration - $time;		        }
		}
		$years=WText::t('1206732357ILFH');
		$months=WText::t('1206732357ILFI');
		$weeks=WText::t('1206732357ILFJ');
		$days=WText::t('1206732357ILFK');
		$hours=WText::t('1206732357ILFL');
		$minutes=WText::t('1206732357ILFM');
		$seconds=WText::t('1206732357ILFN');

						if($ago) $formats=array( $years=> 31556736, $months=>2629800 , $weeks=>604800, $days=>86400, $hours=>3600, $minutes=>60, $seconds=>1);		else $formats=array( $years=>31536000, $months=>2592000 , $weeks=>604800, $days=>86400, $hours=>3600, $minutes=>60, $seconds=>1);
		$lfto=0;
		$result='';
		$results=array();

				foreach( $formats as $format=> $number ){
			if( $duration < $number){
												continue;
			}else{
				 				 				 				 if($format!=$seconds){
				 	$total=$duration;
				 	$duration=floor($duration / $number);
				    $lfto=($total-($duration*$number));
				 }								$results[$format]=$duration.' '.$format;
	        		        	$duration=$lfto;
	        }		}
		$result='';

		$count=1;

								$limit=( count($results) < PLIBRARY_NODE_DATE_SPECS ) ? count($results) : PLIBRARY_NODE_DATE_SPECS;

				foreach( $results as $key=>$res){
			if( $count>=$limit){
				$result.=$res;
				break;
			}else	$result.=$res . ' '; 			$count++;
		}
		return ( $changeSign ) ? '- ' . $result : $result;

	}









	public static function increasePerformance($maxExecutionTime=0,$setMemory=null){
		static $done=false;
		static $maxExecution=null;

				if( $done && empty($maxExecutionTime)) return $maxExecution;
		$done=true;

		$maxMemory=@ini_get('memory_limit');
		if( empty($maxMemory)) $maxMemory=@get_cfg_var('memory_limit');
		$limit=WTools::returnBytes($maxMemory);
		if( isset($setMemory)){
			if( !is_numeric($setMemory)){
				$setMemory=WTools::returnBytes( $setMemory, true );
			}			if( $limit < $setMemory){
				@ini_set( 'memory_limit', WTools::returnBytes( $setMemory, true ));
			}
		}elseif( $limit > 0 && $limit < WTools::returnBytes('128M')){
			@ini_set( 'memory_limit', '128M' );
		}
				if( empty($maxExecutionTime) || $maxExecutionTime < 1 ) $maxExecutionTime=300;

				$maxExecution=@ini_get('max_execution_time');
		if( !empty( $maxExecution ) && $maxExecution < $maxExecutionTime){
			@ini_set('max_execution_time', $maxExecutionTime );
			$maxExecution=@ini_get('max_execution_time');		}
				if( @ini_get('pcre.backtrack_limit') < 10000000){
			@ini_set( 'pcre.backtrack_limit', 10000000 );
		}
 		if( ! ini_get('safe_mode')){ 			@set_time_limit( $maxExecution );
        }

		return $maxExecution;

	}







	public static function returnBytes($val,$inverse=false){

		if( !$inverse){
			$val=trim($val);
			if( empty($val)) return 0;

			$last=strtolower(substr($val,strlen($val/1),1));
			switch($last){
								case 'g':
				$val *=1073741824;
				break;
				case 'm':
				$val *=1048576;
				break;
				case 'k':
				$val *=1024;
				break;
			}
			return (int)$val;

		}else{
			if( $val >=1073741824){
				$string=round( $val / 1073741824 ) . 'G';
			}elseif( $val >=1048576){
				$string=round( $val / 1048576 ) . 'M';
			}elseif( $val >=1024){
				$string=round($val / 1024 ) . 'K';
			}else{
				$string=$val;
			}			return $string;
		}	}







	public static function parseJSText($message){

										$message=addslashes( $message );

				if( JOOBI_CHARSET !='UTF-8'){
			$message=WPage::changeEncoding( $message, 'UTF-8', JOOBI_CHARSET );
		}		return $message;
	}








	public static function checkSecure($data,$secureString){
		$finalSecure=WTools::secureMe( $data );
		$status=( $secureString !=$finalSecure ) ? ( $secureString !=WTools::secureMe( $data, true ) ? false : true ) : true;
		return $status;
	}







	public static function secureMe($data,$otherToken=false){
		static $token=null;
		static $securedA=array();
		if( empty($data)) return false;

		$serialized=serialize($data);
		if( isset($securedA[$serialized])) return $securedA[$serialized];
				if( !isset($token)){
						if( !defined('PLIBRARY_NODE_TOKENCURRENT')) WTools::updateToken();

						$token=constant( 'PLIBRARY_NODE_TOKEN'.strtoupper(PLIBRARY_NODE_TOKENCURRENT));

						if( empty($token)) $token=WTools::updateToken();

		}
		if( $otherToken){
			$tokenName=( strtoupper(PLIBRARY_NODE_TOKENCURRENT)=='A' ) ? 'B':'A';
			$token=constant( 'PLIBRARY_NODE_TOKEN'.$tokenName );
		}
		$securedA[$serialized]=sha1( $serialized . $token . WPage::frameworkToken());			return $securedA[$serialized];

	}





	public static function updateToken(){

				
				if( PLIBRARY_NODE_TOKENCURRENT !='A' && PLIBRARY_NODE_TOKENCURRENT !='B'){
			$prefM=WPref::get( 'library.node' );
			$prefM->updatePref( 'tokencurrent', 'B' );
		}
				if( PLIBRARY_NODE_TOKENTIME < time()){
						$prefM=WPref::get( 'library.node' );
			$tokenName=( PLIBRARY_NODE_TOKENCURRENT=='A' ) ? 'b' : 'a';
			$newToken=WTools::randomString( 50, true );
			$prefM->updatePref( 'token' . $tokenName, $newToken );
						$prefM->updatePref( 'tokencurrent', strtoupper($tokenName));

															$lifetime=JOOBI_SESSION_LIFETIME * 60; 						if( $lifetime < 3600 ) $lifetime=3600;													if( $lifetime > 604800 ) $lifetime=604800;

			$prefM->updatePref( 'tokentime', time() + $lifetime );

		}else{
			$newToken=constant( 'PLIBRARY_NODE_TOKEN'.strtoupper( PLIBRARY_NODE_TOKENCURRENT ));
		}
		return $newToken;
	}






	public static function checkAvailable($function){
				if(is_array($function)){
			foreach($function as $func){
				if(!WTools::checkAvailable($func)) return false;
			}
			return true;
		}

		if(!function_exists($function)) return false;

		if(!is_callable($function)) return false;

		$disabled_functions=explode(',', ini_get('disable_functions'));
		if(in_array($function, $disabled_functions)) return false;

		return true;
	}









	public static function checkMemory($allocate=4000000,$available=false){
		static $maxMemory=0;
				if( empty( $maxMemory )){
			$maxMemory=@ini_get( 'memory_limit' );
			if( empty( $maxMemory )) $maxMemory=@get_cfg_var( 'memory_limit' );
			$maxMemory=WTools::returnBytes( $maxMemory );
		}
		$peakMemory=memory_get_usage() * 1.4; 
		if( $peakMemory > $maxMemory ) return false;
				if( is_string( $allocate )) $allocate=WTools::returnBytes( $allocate );
		if( !empty( $allocate ) && ( $peakMemory + $allocate > $maxMemory )) return false;

		if( $available ) return $maxMemory - $peakMemory;
		else return true;

	}






	public static function setParams($data){

		if( empty($data)) return null;

		$paramsA=array();
		foreach( $data as $k=> $v ) $paramsA[]=$k . '=' . $v;

		return implode( "\n", $paramsA );

	}








	public static function getParams(&$data,$paramsName='params',$prefix=''){

		if( !isset($data->$paramsName)) return false;
		if( empty($data->$paramsName)){
			unset($data->$paramsName);
			return false;
		}


		$myParams=explode( "\n", $data->$paramsName );
		if( empty( $myParams ))  return true;

		foreach( $myParams as $myParam){
			if( empty($myParam  )) continue;

			$position=strpos( $myParam, '=' );
			if($position===false) continue;

			$propertyName=$prefix . substr( $myParam, 0, $position );
			if( empty( $propertyName )){
				continue;
			}
						$data->$propertyName=trim( substr( $myParam, $position+1 ));

		}
		unset( $data->$paramsName );
		return true;

	}







	public static function pref2String($pref){

		if( empty($pref)) return array();

						if( strpos( $pref, ',' ) !==false ) return explode( ',', trim( $pref, ',' ));
		if( strpos( $pref, '|_|' ) !==false ) return explode( '|_|', trim( $pref, '|_|' ));

				return explode( '|', trim( $pref, '|' ));

	}

}


abstract class WOrderingTools {












	public static function getOrderedList($parent,$data,$type=1,$categoryRoot=false,&$childOrderParent,$reassignParent=true){
		WLoadFile( 'library.class.ordering' );
		return Library_Ordering_class::getOrderedList( $parent, $data, $type, $categoryRoot, $childOrderParent, $reassignParent );
	}













	public static function treeRecurse($parent,$id,$indent,$list,&$children,$maxlevel=999,$level=0,$type=1,$categoryRoot=false,&$childOrderParent,$totalIndent){
		WLoadFile( 'library.class.ordering' );
		return Library_Ordering_class::treeRecurse( $parent, $id, $indent, $list, $children, $maxlevel, $level, $type, $categoryRoot, $childOrderParent, $totalIndent );
	}
}