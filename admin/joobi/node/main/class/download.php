<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Download_class extends WClasses {














public function download($fileInfoO) {

	$name = $fileInfoO->name;
	$path = $fileInfoO->path;
	$type = $fileInfoO->type;
	$size = $fileInfoO->size;
	$secure = $fileInfoO->secure;


		WTools::increasePerformance( null, ($size * 1.2) );

		$memoryLimit = WTools::returnBytes( @ini_get('memory_limit') );

	if ( $memoryLimit > 1 && $memoryLimit < $size ) {
		$message = WMessage::get();
		$message->userW('1348621436PSCH');
		$message->adminE( 'The server memory size needs to be higher than the size of the file!' );
		return true;
	}
		$fileName2use = $fileInfoO->name;


	$tname = $fileName2use;

		$tname = str_replace( ' ', '_', $tname );
	$notAccepted = preg_replace('/([A-Za-z0-9-_]+)/i', '', $tname );	$tname = preg_replace( '/([' .$notAccepted . '+)])/i', '', $tname ); 

	if ($secure) $directory = 'safe';
	else  $directory = 'media';

	if ( !empty($path) ) $path .= DS;
	$path = JOOBI_DS_USER . $directory . DS . $path . $name . '.' . $type;

	$hanlder = WGet::file();


		ob_end_clean();
		$contents = $hanlder->read( $path );

		if ( ini_get('zlib.output_compression') ) {
		@ini_set('zlib.output_compression', 'Off');
	}
	if ( empty($contents) ) {
		$mess = WMessage::get();
		$mess->pop();
		$mess->userE('1325473020QNJX');
		WPages::redirect('previous');
		return false;
	} else {

		$this->downloadFileContent( $contents, $name, $type, $size=null );


	}


}








	public function downloadFileContent($contents,$name,$type,$size=null) {

		if ( empty($contents) ) return false;

		if ( empty($size) ) $size = strlen($contents);

				$fichier = preg_replace('#[^a-z0-9\.]#i', '_', $name );

				$httpRange = 0;
		$HTTPServerRange = WGlobals::get( 'HTTP_RANGE', null, 'server' );
		if ( !empty($HTTPServerRange) ) {
			list( $a, $httpRange ) = explode( '=', $HTTPServerRange );
			str_replace($httpRange, '-', $httpRange);
			$newFileSize = $size - 1;
			$newFileSizeHR	= $size - $httpRange;
			header("HTTP/1.1 206 Partial Content");
			header("Accept-Ranges: bytes");
			header("Content-Length: ".(string)$newFileSizeHR);
			header("Content-Range: bytes ".$httpRange . $newFileSize .'/'. $size);
		} else {
			header( 'Content-Length: ' . $size );
		}



		header( 'Content-type: application/'.$type );
		header( 'Content-Disposition: attachment; filename="' . $fichier . '.' . $type . '"' ); 		header( 'Content-Transfer-Encoding: binary' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Cache-Control: pre-check=0, post-check=0, max-age=0' );
		header( 'Pragma: public' );
		header( 'Expires: 0' );

        
		echo $contents;
		exit();


	}
}