<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Item_Images_model extends WModel {








	function __construct() {




		$myImageO = new stdClass;

		$myImageO->fileType = 'images';

		$myImageO->folder = 'media';

		$myImageO->path = 'images' . DS . 'products';

		$myImageO->secure = false;

		$prodPref = WPref::load( 'PITEM_NODE_IMGFORMAT' );

		if ( !empty($prodPref) ) {

			$imgFormat = explode(',', $prodPref );

		}
		$myImageO->format = ( !empty($imgFormat) ) ? $imgFormat : array( 'jpg', 'png', 'gif', 'jpeg');



		
		$myImageO->thumbnail = 1;	
		$myImageO->maxSize = WPref::load( 'PITEM_NODE_IMGMAXSIZE' ) * 1028;

		$myImageO->maxHeight = ( WPref::load( 'PITEM_NODE_MAXPH' ) > 50 ? PITEM_NODE_MAXPH : 50 );

		$myImageO->maxWidth = ( WPref::load( 'PITEM_NODE_MAXPW' ) > 50 ? PITEM_NODE_MAXPW : 50 );

		$myImageO->maxTHeight = ( WPref::load( 'PITEM_NODE_SMALLIH' ) > 20 ? array( PITEM_NODE_SMALLIH ) : 20 );

		$myImageO->maxTWidth = ( WPref::load( 'PITEM_NODE_SMALLIW' ) > 20 ? array( PITEM_NODE_SMALLIW ) : 20 );

		$myImageO->watermark = WPref::load( 'PITEM_NODE_WATERMARKITEM' );

		$myImageO->storage = WPref::load( 'PITEM_NODE_FILES_METHOD_PHOTOS' );


		$this->_fileInfo = array();

		$this->_fileInfo['filid'] = $myImageO;



		
		parent::__construct();



	}
}