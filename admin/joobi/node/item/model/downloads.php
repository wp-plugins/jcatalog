<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Downloads_model extends WModel {








	function __construct() {



		WPref::load( 'PITEM_NODE_DWLDFORMAT' );



		$myImageO = new stdClass;

		$myImageO->fileType = 'files';

		$myImageO->folder = 'safe';

		$myImageO->path = 'products';

		$myImageO->secure = true;		
		$myImageO->format = PITEM_NODE_DWLDFORMAT;	
		$myImageO->maxSize = PITEM_NODE_DWLDMAXSIZE * 1028;	
		$myImageO->storage = PITEM_NODE_FILES_METHOD_DOWNLOADS;



		$this->_fileInfo = array();

		$this->_fileInfo['filid'] = $myImageO;



		
		parent::__construct();



	}
}