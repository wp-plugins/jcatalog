<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_Triggerurl_class extends WClasses {










 	public function launch($urllink,$limitSeconds=30,$getResponse=false){

 		 		$php=phpversion();
 		$phpA=explode( '.', $php );
 		if( $phpA[0] >=5){
 			return $this->_triggerURL_PHP5( $urllink, $limitSeconds, $getResponse );
 		}else{
 			return $this->_triggerURL_PHP4( $urllink, $limitSeconds, $getResponse );
 		}
 	}









 	public function launchAndGetResult($urllink,$limitSeconds=30,$getResponse=false){

		if( function_exists('curl_init')){
			$CURL=curl_init();
			curl_setopt( $CURL, CURLOPT_URL,$urllink );
			curl_setopt( $CURL, CURLOPT_FAILONERROR, 1 );
			curl_setopt( $CURL, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $CURL, CURLOPT_TIMEOUT, $limitSeconds ) ;
			$result=curl_exec($CURL);
			curl_close( $CURL );
			return $result;
		}

		if( ini_get('allow_url_fopen')){
			return file_get_contents( $urllink );
		}
		return $this->launch( $urllink, $limitSeconds, $getResponse );

 	}








 	private function _triggerURL_PHP5($urllink,$limitSeconds=30,$getResponse=false){

 		$purl=parse_url( $urllink );
		$status=false;

		$ssl=( 'https'==$purl['scheme'] ? true : false );

				$port=!empty( $purl['port'] ) ? $purl['port'] : ( $ssl ? 443 : 80 );

				if( empty($purl['host'])) return false;

		$errno=0;
		$errstr='';
		$context=stream_context_create();
		$transport='';
		if( $ssl){
			$remote='ssl://' . $purl['host'] . ':' .$port;			}else{
			$remote=$purl['host'].':'.$port . $purl['path'];
		}

				if( $ssl){
			$result=stream_context_set_option( $context, 'ssl', 'verify_host', true );

			if( !empty($opts['cert'])){
				$result=stream_context_set_option($context, 'ssl', 'cafile', $opts['cert'] );
				$result=stream_context_set_option($context, 'ssl', 'verify_peer', true );
			}else{
				$result=stream_context_set_option($context, 'ssl', 'allow_self_signed', true );
			}		}
		$socket=@stream_socket_client( $remote, $errno, $errstr, $limitSeconds, STREAM_CLIENT_CONNECT | STREAM_CLIENT_ASYNC_CONNECT, $context );
		sleep(1);	
		if(!$socket){
		    echo "$errstr ($errno)<br />\n";
		}else{

			$out="GET ";
			$out .=empty($purl['path'])? "/" : $purl['path'] ;
			if(!empty($purl['query'])) $out.="?".$purl['query'];
			$out .=" HTTP/1.1\r\n";
			$out .="Host: ".$purl['host'];
			if( !empty( $purl['port'] )) $out .=":".$purl['port']."\r\n";

						if( !empty($purl['user']) && !empty($purl['pass'])){
				$out .="Authorization: Basic " . base64_encode( $purl['user'] . ":" . $purl['pass'])."\r\n";
			}
			if( !$getResponse){
				$out .="\r\nConnection: Close\r\n\r\n";
				@stream_set_blocking( $socket, 0 );
			}else{
				$out .="\r\n\r\n";
			}
			@fwrite( $socket, $out );
						if( $getResponse){
				while (!feof($socket)){
	    			$response=fgets($socket);
				}			}
		   $status=fclose($socket);

		}
		return $getResponse ? ( $status ? $response : $status ) : $status;

 	}

















 	private function _triggerURL_PHP4($urllink,$limitSeconds=30,$getResponse=false){

		$purl=parse_url( $urllink );

				$port=!empty( $purl['port'] ) ? $purl['port'] : 80;

				if( empty($purl['host'])) return false;

		$errno=0;
		$errstr='';
		$sock=fsockopen( $purl['host'], $port, $errno, $errstr,$limitSeconds);

		if( $sock){

			$out="GET ";
			$out .=empty($purl['path'])? "/" : $purl['path'] ;
			if(!empty($purl['query'])) $out.="?".$purl['query'];
			$out .=" HTTP/1.1\r\n";
			$out .="Host: ".$purl['host']."\r\n";
			$out .="Host: ".$purl['host'];
			if( !empty( $purl['port'] )) $out .=":".$purl['port']."\r\n";

						if( !empty($purl['user']) && !empty($purl['pass'])){
				$out .="Authorization: Basic " . base64_encode( $purl['user'] . ":" . $purl['pass'])."\r\n";
			}
			if( !$getResponse){
				$out .="\r\nConnection: Close\r\n\r\n";
				@stream_set_blocking( $sock, 0 );
			}else{
				$out .="\r\n\r\n";
			}
			@fwrite( $sock, $out );

						if( $getResponse){
				while (!feof($sock)){
	    			$response=fgets($sock);
				}			}
			$status=fclose( $sock );

			return $getResponse ? ( $status ? $response : $status ) : $status;

		}
		return false;

 	}
}