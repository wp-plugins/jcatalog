<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Images_Process_class extends WClasses {


	public function process(&$imageM){

		if( !function_exists('gd_info')){
			$message->userW('1405632893JOWQ');
			return true;
		}		$this->imagePath=$imageM->_completePath . DS . $imageM->name . '.' . $imageM->type;


			$thumbnailMaxHeight=( is_array($imageM->_maxTHeight)) ? $imageM->_maxTHeight[0] : $imageM->_maxTHeight;
			$thumbnailMaxHeight=( $thumbnailMaxHeight ) ? $thumbnailMaxHeight : 15;				$thumbnailMaxWidth=( is_array($imageM->_maxTWidth)) ? $imageM->_maxTWidth[0] : $imageM->_maxTWidth;
			$thumbnailMaxWidth=( $thumbnailMaxWidth ) ? $thumbnailMaxWidth : 15;	
			$filesResizeC=WClass::get( 'images.resize' );
			$filesResizeC->source=$imageM->_tmp_name;
			$filesResizeC->type=$imageM->type;
			$info=$this->_imageSize( $imageM->_tmp_name );

						if( $imageM->_maxWidth > 0 || $imageM->_maxHeight > 0){

								if($info[0] > $imageM->_maxWidth || $info[1] > $imageM->_maxHeight){
					
					$filesResizeC->max_width=$imageM->_maxWidth;
					$filesResizeC->max_height=$imageM->_maxHeight;
					$filesResizeC->width=$info[0];
					$filesResizeC->height=$info[1];

					$filesResizeC->dest=$this->imagePath;

					if( $filesResizeC->resizeImage()){
												$info=$this->_imageSize( $this->imagePath );
						$imageM->width=@$info[0];
						$imageM->height=@$info[1];

						$ratio=$imageM->_maxHeight / $thumbnailMaxHeight;
						$this->twidth=$info[0] / $ratio;
						$this->theight=$info[1] / $ratio;
						$imageM->_resized=true;
						$newSize=filesize( $this->imagePath );
						if( !empty($newSize)) $imageM->size=$newSize;
					}else{
						$imageM->width=@$info[0];
						$imageM->height=@$info[1];
						$imageM->_resized=false;
					}
				}else{
										$imageM->width=@$info[0];
					$imageM->height=@$info[1];
					$imageM->_resized=false;
				}			}else{
				$info=$this->_imageSize( $this->imagePath, $imageM->_tmp_name );
				$imageM->width=@$info[0];
				$imageM->height=@$info[1];

				$ratio=$imageM->_maxHeight / $thumbnailMaxHeight;
				if( !empty($ratio)){
					$this->twidth=$info[0] / $ratio;
					$this->theight=$info[1] / $ratio;
				}
			}
						if( !empty($imageM->_watermark)){
				$imagesWatermarkC=WClass::get( 'images.watermark' );
				$imagesWatermarkC->processWatermark( $filesResizeC, $imageM->width, $imageM->height );

			}

						if( $imageM->thumbnail){

				$filesResizeC->max_width=$thumbnailMaxHeight;
				$filesResizeC->max_height=$thumbnailMaxWidth;
				if( empty( $filesResizeC->width )) $filesResizeC->width=$info[0];
				if( empty( $filesResizeC->height )) $filesResizeC->height=$info[1];

				$folder=WGet::folder();
				$turl=$imageM->_completePath . DS . 'thumbnails';
				$folder->create( $turl, '', true );
				$filesResizeC->dest=$turl . DS . $imageM->name . '.' . $imageM->type;
				if( $filesResizeC->resizeImage()){

					$info=$this->_imageSize( $filesResizeC->dest );
					$imageM->twidth=@$info[0];
					$imageM->theight=@$info[1];
				}else{
					$imageM->twidth=0;
					$imageM->theight=0;
				}
			}

									if( $imageM->_resized ) $imageM->_completePath=$imageM->_completePath . DS . 'oversize';

			return true;


		return true;

	}







	private function _imageSize($path,$tempPath=''){

		if( file_exists( $path )){
			return @getimagesize( $path );
		}
				if( !empty($tempPath) && file_exists( $tempPath )){
			return @getimagesize( $tempPath );
		}
		$message=WMessage::get();
		$IMG_FILE=$path;
		$message->adminE( 'The image file ' . $IMG_FILE . ' does not exist.' );

		return false;

	}

}