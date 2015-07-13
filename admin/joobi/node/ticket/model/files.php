<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Files_model extends WModel {


var $_fileInfo = array();









	function __construct() {



		$formatAccepted = WPref::load( 'PTICKET_NODE_TKATTACHFORMATS' );


		$formats = str_replace( ' ', '', $formatAccepted );



		$filid = new stdClass;

		$filid->fileType = 'files';

		$filid->folder = 'media';

		$filid->path = 'attach' . DS . 'tickets';

		$filid->secure = false;

		$filid->format = explode(',',$formats);

		$filid->maxSize = WPref::load( 'PTICKET_NODE_TKATTACHMAXSIZE' ) * 1024;



		$this->_fileInfo = array();

		$this->_fileInfo['filid'] = $filid;


		parent::__construct( 'ticket', 'files', 'filid,tkid' );


	}
}