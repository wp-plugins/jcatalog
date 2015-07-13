<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_CoreProductgallery_form extends WForms_default {





    function show() {

        $definedImgWidth = (int)WGlobals::get( 'maxImageWidth', 180 );
        $definedImgHeight = (int)WGlobals::get( 'maxImageHeight', 180 );

        $imageUseZoom = WPref::load( 'PITEM_NODE_USEZOOM' );
                        if ( empty($this->value) ) { 
                        $previewID = $this->getValue( 'previewid' );
        if ( !empty( $previewID ) ) return false;

        $path = JOOBI_URL_MEDIA . 'images/products/';

        if ( !empty($definedImgHeight) || !empty($definedImgWidth) ) {
        $newSize = new stdClass;            $newSize->width = 180;
        $newSize->height = 180;
        $this->_resizePicture( $newSize, $definedImgHeight, $definedImgWidth );

        }
        if ( !isset($url) ) $url = $path . 'productx.png';

        $data = WPage::newBluePrint( 'image' );
        $data->location = $url;
        if ( !empty($newSize) ) {
        $data->width = $newSize->width;
        $data->height = $newSize->height;
        }        $data->text = WText::t('1395715505PJRP');
        $image = WPage::renderBluePrint( 'image', $data );

        $x = $definedImgWidth;
        $y = $definedImgHeight;

        $this->content .= WPage::createPopUpLink( $url, $image, ($x*1.08), ($y*1.08) );

        WGlobals::set( 'imageURL', $url );
        return true;

        } else {

        static $resultA = array();

        if ( !isset( $resultA[ $this->eid ] ) ) {
                static $productimgM = null;
        if ( empty( $productimgM ) ) $productimgM = WModel::get('item.images');
        $productimgM->makeLJ( 'files', 'filid' );
                $productimgM->select('filid');
        $productimgM->select( array('path', 'type', 'name', 'twidth', 'theight', 'width', 'height','thumbnail', 'storage' ), 1 );
        $productimgM->whereE('pid' , $this->eid );
        $productimgM->orderBy( 'premium', 'DESC' );
        $productimgM->orderBy( 'ordering', 'ASC' );
        $resultA[ $this->eid ] = $productimgM->load('ol');
        }
        $imagesA = $resultA[ $this->eid ];
        WPage::addJSFile( 'node/catalog/js/prettyphoto.js' );
        WPage::addCSSFile( 'node/catalog/css/prettyphoto.css' );

                        if ( empty($imagesA) ) return false;


        $myNewImageO = WObject::get( 'files.file' );

        if ( $imageUseZoom ) {

                WPage::addJSFile( 'node/catalog/js/bootstrap-magnify.js' );
        WPage::addCSSFile( 'node/catalog/css/bootstrap-magnify.css' );

        }

        $numberOfPictures = count($imagesA);
                        if ( $numberOfPictures == 1 ) {

            $oneImage = ( is_array($imagesA) ) ? $imagesA[0] : $imagesA;
            WGlobals::set( 'image-show-filid', $oneImage->filid );

                        $oneImage->path = implode( '/' , explode('|' , $oneImage->path) );

                        $imgN = $oneImage->name;                            $imgT = $oneImage->type;                            $urlID = $oneImage->path . '/'. $imgN . '.' . $imgT;
            $imgURL = JOOBI_URL_MEDIA . $urlID;
            if ( !empty($definedImgHeight) || !empty($definedImgWidth) ) {
                $newSize = new stdClass;
                $newSize->width = $oneImage->width;
                $newSize->height = $oneImage->height;
                $this->_resizePicture( $newSize, $definedImgHeight, $definedImgWidth );

                $imageHTMLSize = 'width="' . $newSize->width . '" height="' . $newSize->height . '" ';
            } else {
                $imageHTMLSize = '';
            }
            $myNewImageO->name = $oneImage->name;
            $myNewImageO->type = $oneImage->type;
            $myNewImageO->basePath = JOOBI_URL_MEDIA;
            $myNewImageO->folder = ( empty($oneImage->folder) ? 'media' : $oneImage->folder );
            $myNewImageO->path = $oneImage->path;
            $myNewImageO->fileID = $oneImage->filid;
            $myNewImageO->thumbnail = false;
            $myNewImageO->storage = $oneImage->storage;
            $url = $myNewImageO->fileURL();

            $image = ' <a href="'.$url.'" rel="prettyPhoto" class="thumbnail" style="border: none !important;"><img';
            if ( $imageUseZoom ) $image .= ' data-toggle="magnify"';
            $image .= ' '.$imageHTMLSize . 'src="' . $url .'"/></a>';

            $x = $oneImage->width;
            $y = $oneImage->height;

            $this->content .= WPage::createPopUpLink( $url, $image, ($x*1.08), ($y*1.08) );

            WGlobals::set( 'imageURL', $url );

            $css = '#ImageBox a.modal{overflow:visible!important;}';

            WPage::addCSS( $css );

        } else {

                if ( !is_array($imagesA) ) {
        $imaA = array();
        $imaA[] = $imagesA;
        $imagesA = $imaA;
        }
        WGlobals::set( 'image-show-filid', $imagesA[0]->filid );

                $JScode = "jQuery('#bigcarousel').carousel();";

                WPage::addJSLibrary( 'jquery' );
        WPage::addJSScript( $JScode, 'default', false );



        
        









    $divBK = '<div id="bkBlack"></div><div id="box"><div class="modal-body"><div id="anh"></div></div><div class="modal-footer"><button data-dismiss="modal" class="btn btn-warning bnt-close" type="button"><i class="fa fa-times-circle"></i>' . WText::t('1228820287MBVC') . '</button></div></div>';
    $JSSlider = "
jQuery('#mycarousel').carousel({
interval : false
});
jQuery('a.thumbnail').click(function() {
jQuery('#bigcarousel').carousel(jQuery(this).data('slide'));
});
function showA(anh){
jQuery('#bkBlack').fadeIn(300);
jQuery('#box').fadeIn(300);
jQuery('#anh').html('<img src='+anh.substr(0, anh.length) +' />');
}
function hideA(){
jQuery('#bkBlack').fadeOut(300);
jQuery('#box').fadeOut(300);
}
jQuery(document).ready(function(){
jQuery('#bigcarousel .carousel-inner .item').click(function(){
var src=jQuery(this).find('img').attr('src');
showA(src);
});
jQuery('.bnt-close').click(function(){hideA();});
jQuery('#bkBlack').click(function(){hideA();});
});
";

        $css = '#bkBlack{ display:none; background-color: rgba(11, 11, 11, 0.73);position: absolute;top:0px;left:0px;right:0px;bottom: 0px; z-index: 10000;}';
                $css .= '#box{display:none;left:20%;right:20%;position:absolute;top:10%;background-color: white;z-index:20000;padding:20px;}#anh img{width:100%;}';    
        WPage::addCSS( $css );
        
                WPage::addJSScript( $JSSlider, 'default', true );
        

        $imageHTML = '';
        $imagePagiHTML = '';
        $productName = $this->getValue( 'name' );
        $mainImage = null;
        $imgM= WModel::get('files');

                $maxHeight = 0;
        $maxWidth = 0;
        foreach( $imagesA as $oneImage ) {
        if ( $oneImage->height > $maxHeight ) $maxHeight = $oneImage->height;
        if ( $oneImage->width > $maxWidth ) $maxWidth = $oneImage->width;
        }        if ( $maxHeight > $definedImgHeight ) $maxHeight = $definedImgHeight;
        if ( $maxWidth > $definedImgWidth ) $maxWidth = $definedImgWidth;


        $thumbsize = 100;         $amount = round( ( $definedImgWidth/($thumbsize) ), 0, PHP_ROUND_HALF_DOWN );

                                for ($count = 0; $count < sizeof($imagesA); $count++) {
        $oneImage = $imagesA[$count];
        
                $imgN        = $oneImage->name;                        $imgT        = $oneImage->type;                        $imgW        = $oneImage->width;                        $imgH        = $oneImage->height;                    $imgtH        = $oneImage->theight;                    $imgtW        = $oneImage->twidth;                    
                $myNewImageO->name = $oneImage->name;
        $myNewImageO->type = $oneImage->type;
        $myNewImageO->basePath = JOOBI_URL_MEDIA;
        $myNewImageO->folder = ( empty($oneImage->folder) ? 'media' : $oneImage->folder );
        $myNewImageO->path = $oneImage->path;
        $myNewImageO->fileID = $oneImage->filid;
        $myNewImageO->thumbnail = true;
        $myNewImageO->storage = $oneImage->storage;
        $thumbURL = $myNewImageO->fileURL();

        $myNewImageO->thumbnail = false;
        $mainURL = $myNewImageO->fileURL();

        $newSize = new stdClass;
        $newSize->height = $imgH;
        $newSize->width = $imgW;
        $this->_resizePicture( $newSize, $definedImgHeight, $definedImgWidth );

                if ( !isset($mainImage) ) $mainImage = $mainURL;

        $alt = WGlobals::filter( $productName . '-' . $imgN, 'safejs' );
                $margin = ( ($maxHeight - $newSize->height - 48 ) * 50 ) / $maxHeight;
        if ( $margin < 0 ) $margin = 0;


                        ($count == 0) ? $active = "active" : $active = "";
            $marginSize = $newSize->height / 2;

            $x = $oneImage->width;
            $y = $oneImage->height;
            $imgXMax = round( $x*1.08 );
            $imgYMax = round( $y*1.08 );

            
                        
           $image = '
<div class="' . $active . ' item" data-slide-number="' . $count . '">
<div class="image" style="margin-top: -' . $marginSize . 'px">
<a  href="'.$mainURL.'" rel="prettyPhoto[gallery]" data-slide="' . $count . '" class="thumbnail" style = "border: none !important;">
<img data-toggle="magnify" class="img img-responsive" src="' . $mainURL . '" alt="">
</a>
</div>
</div>';
        $imageHTML .= $image;

        $newSize = new stdClass;
        $newSize->height = $imgtH;
        $newSize->width = $imgtW;
        $this->_resizePicture( $newSize, 48, 48 );
        $margin = ( 48 - $newSize->height ) / 2;

                                if($count % $amount == 0 && $count != 0) {
        $imagePagiHTML .= '
</div>
</div>
<div class="item">
<div class="row">';

        }
        $imagePagiHTML .= '
<div class="col" style="width:' . ($thumbsize - 10) . 'px">
<a data-slide="' . $count . '" class="thumbnail">
<img style="margin-top:\'' . $margin . '%\'" src="' . $thumbURL . '" width="' . $newSize->width . '" alt="' . $alt . '-thumb" class="img-responsive">
</a>
</div>';

        }





            $html = '
<div id="slideItemPhoto">
<div id="products">
<div id="bigcarousel" class="carousel slide">
<div class="carousel-inner">
';

        $html .= $imageHTML;


        $html .= '
</div>
</div>
<div id="mycarousel" class="carousel slide">
<div class="carousel-inner">
<div class="item active">
<div class="row">
' . $imagePagiHTML . '
</div>
</div>
</div>';
        if ($amount < $numberOfPictures) {
        $html .= '
<a class="left carousel-control" href="#mycarousel" data-slide="prev">‹</a>
<a class="right carousel-control" href="#mycarousel" data-slide="next">›</a>';
        }
        $html .='
</div>
</div>
</div>';



                $CSS = '
#products {width:' . $definedImgWidth . 'px;}
#bigcarousel .magnify {height:'.$definedImgHeight.'px;}
#bigcarousel > .carousel-inner{height:' . $definedImgHeight . 'px;}';

        WPage::addCSS( $CSS );

        WGlobals::set( 'imageURL', $mainImage );

        $this->content = $html;

        }
        }
        WPage::addJSLibrary( 'joobibox' );
        $JSSlidertest = 'jQuery("a[rel^=\'prettyPhoto\'], a[rel^=\'lightbox\']").prettyPhoto({social_tools: false}); console.log("called");';

       WPage::addJSScript( $JSSlidertest, 'default', true );

       return true;

    }














    private function _resizePicture(&$newSize,$maxHeight,$maxWidth) {

        $php5 = ( defined('PHP_ROUND_HALF_DOWN') ) ? true : false;

                if ( $newSize->height > $maxHeight && $maxHeight > 0 ) {
            $ratio =  $maxHeight / $newSize->height;
            $newSize->width = $php5 ? round( $newSize->width * $ratio, 0, PHP_ROUND_HALF_DOWN ) : round( $newSize->width * $ratio, 0 );
            $newSize->height = $maxHeight;
        }
                if ( $newSize->width > $maxWidth && $maxWidth > 0 ) {
            $ratio =  $maxWidth / $newSize->width;
            $newSize->height = $php5 ? round( $newSize->height * $ratio, 0, PHP_ROUND_HALF_DOWN ) : round( $newSize->height * $ratio, 0 );
            $newSize->width = $maxWidth;
        }
    }
}