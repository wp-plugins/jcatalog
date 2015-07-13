<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.text' );
class Users_Maxfilesize_form extends WForm_text {
function create(){



$status=parent::create();



$maxFileSize1=@ini_get('post_max_size');

$maxFileSize2=@ini_get('upload_max_filesize');

$maxFileSize=( $maxFileSize2 > $maxFileSize1 ) ? $maxFileSize2 : $maxFileSize1;


$maxFileSizeShow=WTools::returnBytes( WTools::returnBytes( $maxFileSize ), true );


$this->content .='&nbsp;&nbsp;' . WText::t('1331164428MGHN') . ' : ' . $maxFileSizeShow;



return $status;

}
}