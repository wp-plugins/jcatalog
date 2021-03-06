<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');









class Images_Resize_class extends WClasses{

    public $source=null;

        public $height=0;
    public $width=0;
    public $mime=null;

    public $max_width=200;
    public $max_height=200;
    public $thumb_width=50;
    public $thumb_height=50;
    public $dest='';
    public $type='';
    public $size=null;











    public function resizeImageDimentions(&$width,&$height,$maxWidth=30,$maxHeight=30){
    	$this->max_width=$maxWidth;
    	$this->max_height=$maxHeight;

    	$this->calcImageSize( $width, $height );

    	$width=$this->thumb_width;
        $height=$this->thumb_height;

    }




    public function resizeImage(){


        switch ( strtolower($this->type)){
            case 'gif':
                $img_src=@imagecreatefromgif( $this->source );
                break;
            case 'jpg':
            case 'jpeg':
                $img_src=@imagecreatefromjpeg( $this->source );
                break;
            case 'png':
                $img_src=@imagecreatefrompng( $this->source );
                break;
            default:
            	return false;
            	break;
        }

        $this->calcImageSize( $this->GetWidth(), $this->GetHeight());

                if( empty($this->thumb_width) || $this->thumb_width < 1 ) $this->thumb_width=50;
        if( empty($this->thumb_height) || $this->thumb_height < 1 ) $this->thumb_height=50;
        $img_des=imagecreatetruecolor((int)$this->thumb_width, (int)$this->thumb_height );


		if( strtolower($this->type)=='png' ){ 			imagealphablending($img_des, false);
			imagealphablending($img_des, false);
			imagesavealpha($img_des,true);
			$transparent=imagecolorallocatealpha($img_des, 255, 255, 255, 127);
			imagefilledrectangle($img_des, 0, 0, $this->thumb_width, $this->thumb_height, $transparent);
		}elseif( strtolower($this->type)=='gif' ){ 			$whitebg=imagecolorallocate ($img_des, 255, 255, 255);
	       	imagefilledrectangle($img_des, 0, 0, $this->thumb_width, $this->thumb_height, $whitebg );
		}
		$result=@imagecopyresampled( $img_des, $img_src, 0, 0, 0, 0, $this->thumb_width, $this->thumb_height, $this->GetWidth(), $this->GetHeight());

		if( !is_writable( dirname($this->dest))){
						@chmod( dirname($this->dest), '755' );
			if( !is_writable( dirname($this->dest))){
				$message=WMessage::get();
				$FOLDER=dirname($this->dest);
				$message->userW('1212843259ITHW',array('$FOLDER'=>$FOLDER));
				return false;
			}		}

		switch ( strtolower($this->type)){
            case 'gif':
                return ((imagegif( $img_des, $this->dest )==true ) ? true: false );
                break;
            case 'jpg':
            case 'jpeg':
                return ((imagejpeg( $img_des, $this->dest, 100 )==true ) ? true: false );
                break;
            case 'png':
               return ((imagepng( $img_des, $this->dest )==true ) ? true: false );
               break;
        }

     }


        private function GetWidth($reset=false){
		$this->_getProp($reset=false);
		return $this->width;
    }

        private function GetHeight($reset=false){
		$this->_getProp($reset=false);
		return $this->height;
    }






    private function _getProp($reset=false){
		static $dimensionA=null;

    	if(!isset($dimensionA) || $reset){
	    	$dimensionA=@getimagesize($this->source);
			$this->width=$dimensionA[0];
			$this->height=$dimensionA[1];
			$this->mime=$dimensionA['mime'];
	    }
    }

        private function resizeHeight($width,$height,$ratio=0){

        if( $ratio==0 ) $ratio=$height / $this->max_height;
        $newHeight=$height / $ratio;
        return array( 'ratio'=>$ratio ,'newHeight'=>intval($newHeight));	    }







    private function resizeWidth($width,$height,$ratio=0){

        if( $ratio==0 ) $ratio=$width / $this->max_width;
        $newWidth=$width / $ratio;
        return array('newWidth'=>intval($newWidth),'ratio'=>$ratio );	    }








    private function calcImageSize($width,$height){

		if( $this->max_width < 1 || $this->max_height < 1 ) return false;

  				if( $width > $this->max_width){

            $newWidthObj=$this->resizeWidth( $width, $height );
			$width=$newWidthObj['newWidth'];
            $newHeightObj=$this->resizeHeight( $width, $height, $newWidthObj['ratio'] );
			$height=$newHeightObj['newHeight'];

        }
  		        if( $height > $this->max_height){

            $newHeightObj=$this->resizeHeight( $width, $height );
			$height=$newHeightObj['newHeight'];
            $newWidthObj=$this->resizeWidth( $width, $height, $newHeightObj['ratio'] );
			$width=$newWidthObj['newWidth'];

        }
        $this->thumb_width=$width;
        $this->thumb_height=$height;
    }


}