<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Output_uploadfile_controller extends WController {

function uploadfile(){

	
	error_reporting( E_ALL ^ E_NOTICE ); 
		$fileName	=WGlobals::get( 'ax-file-name' );
	$currByte	=WGlobals::get( 'ax-start-byte' );
	$maxFileSize=WGlobals::get( 'ax-maxFileSize' );
	$html5fsize	=WGlobals::get( 'ax-fileSize' );
	$isLast		=WGlobals::get( 'isLast' );

		$thumbHeight=WGlobals::get( 'ax-thumbHeight' );
	$thumbWidth	=WGlobals::get( 'ax-thumbWidth' );
	$thumbPostfix=WGlobals::get( 'ax-thumbPostfix' );
	$thumbPath	=WGlobals::get( 'ax-thumbPath' );
	$thumbFormat=WGlobals::get( 'ax-thumbFormat' );

	$TYTYTY=WGlobals::get( 'ax-allow-ext' );

	$allowExt=( empty( $TYTYTY )) ? array() : explode('|', $TYTYTY );


	$uploadPath=JOOBI_DS_TEMP . 'uploads' . DS;


	$dirSys=WGet::folder();
	if( !$dirSys->exist( $uploadPath )){
		$dirSys->create( $uploadPath );
	}
	$thumbPath='';

	$axFilesA=WGlobals::get( 'ax-files', null, 'files' );

					
	if( isset($axFilesA)){

			    foreach( $axFilesA['error'] as $key=> $error){

	        if( $error==UPLOAD_ERR_OK){
	        	$newName=!empty($fileName)? $fileName:$axFilesA['name'][$key];
	        	$fullPath=Output_uploadfile_controller::_checkFilename( $allowExt, $uploadPath, $maxFileSize, $newName, $axFilesA['size'][$key] );

	        	if($fullPath){

					move_uploaded_file( $axFilesA['tmp_name'][$key], $fullPath );
					if(!empty($thumbWidth) || !empty($thumbHeight))
						Output_uploadfile_controller::_createThumbGD( $fullPath, $thumbPath, $thumbPostfix, $thumbWidth, $thumbHeight, $thumbFormat);
					WText::load( 'output.node' );
					$fileUPdaedText=WText::t('1360160364KSSI');
					echo json_encode( array('name'=>basename($fullPath), 'size'=> filesize($fullPath), 'status'=>'uploaded', 'info'=> $fileUPdaedText ));
					die;
	        	}	        }  else {
	        	echo json_encode( array('name'=>basename($axFilesA['name'][$key]), 'size'=>$axFilesA['size'][$key], 'status'=>'error', 'info'=>$error));
	        	die;
	        }	    }
	}elseif( isset( $fileName)){

				$fullPath=(( $currByte!=0 ) ? $uploadPath . $fileName : Output_uploadfile_controller::_checkFilename( $allowExt, $uploadPath, $maxFileSize, $fileName, $html5fsize ));

		if( $fullPath){

			$flag=( $currByte==0 ) ? 0 : FILE_APPEND;

			$receivedBytes=file_get_contents( 'php://input' );



								    while( @file_put_contents( $fullPath, $receivedBytes, $flag )===false){
		    	usleep(50);
		    }
		    if( $isLast=='true'){
		    	Output_uploadfile_controller::_createThumbGD( $fullPath, $thumbPath, $thumbPostfix, $thumbWidth, $thumbHeight, $thumbFormat );
		    }
		    WText::load( 'output.node' );
	        $fileUPdaedText=WText::t('1360160364KSSJ');
		    echo json_encode( array( 'name'=>basename($fullPath), 'size'=>$currByte, 'status'=>'uploaded', 'info'=> $fileUPdaedText ));
	        die;

		}
	}

	return true;

}





private function _createThumbGD($filepath,$thumbPath,$postfix,$maxwidth,$maxheight,$format='jpg',$quality=75){

	if($maxwidth<=0 && $maxheight<=0)
	{
		return 'No valid width and height given';
	}

	$gd_formats	=array('jpg','jpeg','png','gif');	$file_name	=pathinfo($filepath);
	if(empty($format)) $format=$file_name['extension'];

	if(!in_array(strtolower($file_name['extension']), $gd_formats))
	{
		return false;
	}

	$thumb_name	=$file_name['filename'].$postfix.'.'.$format;

	if(empty($thumbPath))
	{
		$thumbPath=$file_name['dirname'];
	}

	$thumbPath.=((!in_array(substr($thumbPath, -1), array('\\','/')) ) ? DS : '');
		list($width_orig, $height_orig)=getimagesize($filepath);
	if($width_orig>0 && $height_orig>0)
	{
		$ratioX	=$maxwidth/$width_orig;
		$ratioY	=$maxheight/$height_orig;
		$ratio 	=min($ratioX, $ratioY);
		$ratio	=($ratio==0)?max($ratioX, $ratioY):$ratio;
		$newW	=$width_orig*$ratio;
		$newH	=$height_orig*$ratio;

				$thumb=imagecreatetruecolor($newW, $newH);
		$image=imagecreatefromstring(file_get_contents($filepath));

		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newW, $newH, $width_orig, $height_orig);

				switch (strtolower($format)){
			case 'png':
				imagepng($thumb, $thumbPath.$thumb_name, 9);
			break;

			case 'gif':
				imagegif($thumb, $thumbPath.$thumb_name);
			break;

			default:
				imagejpeg($thumb, $thumbPath.$thumb_name, $quality);
			break;
		}
		imagedestroy($image);
		imagedestroy($thumb);
	}
	else
	{
		return false;
	}
}



private function _checkFilename($allowExt,$uploadPath,$maxFileSize,$fileName,$size,$newName=''){

		$maxsize_regex=preg_match("/^(?'size'[\\d]+)(?'rang'[a-z]{0,1})$/i", $maxFileSize, $match);
	$maxSize=4*1024*1024;	if( $maxsize_regex && is_numeric($match['size'])){
		switch (strtoupper($match['rang'])){ 			case 'K': $maxSize=$match[1]*1024; break;
			case 'M': $maxSize=$match[1]*1024*1024; break;
			case 'G': $maxSize=$match[1]*1024*1024*1024; break;
			case 'T': $maxSize=$match[1]*1024*1024*1024*1024; break;
			default: $maxSize=$match[1];		}
	}
	if(!empty($maxFileSize) && $size>$maxSize)
	{
		WText::load( 'output.node' );
		$fileUPdaedText=WText::t('1360160364KSSK');
		echo json_encode(array('name'=>$fileName, 'size'=>$size, 'status'=>'error', 'info'=> $fileUPdaedText ));
				die;
	}
	

		$windowsReserved	=array('CON', 'PRN', 'AUX', 'NUL','COM1', 'COM2', 'COM3', 'COM4', 'COM5', 'COM6', 'COM7', 'COM8', 'COM9',
            				'LPT1', 'LPT2', 'LPT3', 'LPT4', 'LPT5', 'LPT6', 'LPT7', 'LPT8', 'LPT9');
	$badWinChars		=array_merge(array_map('chr', range(0,31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*"));

	$fileName	=str_replace($badWinChars, '', $fileName);
    $fileInfo	=pathinfo($fileName);
    $fileExt	=$fileInfo['extension'];
    $fileBase	=$fileInfo['filename'];

    	if(in_array($fileName, $windowsReserved))
	{
		echo json_encode(array('name'=>$fileName, 'size'=>0, 'status'=>'error', 'info'=> 'File name not allowed. Windows reserverd.' ));
				die;
	}


    	if( !in_array( strtolower($fileExt), $allowExt ) && count($allowExt)){			WText::load( 'output.node' );
		$FILE_EXTENSION=$fileExt;
		$fileUPdaedText=str_replace(array('$FILE_EXTENSION'), array($FILE_EXTENSION),WText::t('1360160364KSSL'));
		echo json_encode(array('name'=>$fileName, 'size'=>0, 'status'=>'error', 'info'=> $fileUPdaedText ));
				die;
	}
	$fullPath=$uploadPath . $fileName;
    $c=0;
	while(file_exists($fullPath)){
		$c++;
		$fileName	=$fileBase."($c).".$fileExt;
		$fullPath 	=$uploadPath.$fileName;
	}

	return $fullPath;

}
}