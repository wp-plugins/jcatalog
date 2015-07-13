<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Events_Actions_model extends WModel {
	

function validate(){


	$code=( !empty($this->x['action']) ? $this->x['action'] : '' );
	if( empty($code)) return true;
	
	$extensionFolder=WExtension::get( $this->wid, 'folder' );
		
	$fileC=WGet::file();
	$fileC->write( JOOBI_DS_USER . 'custom' . DS . $extensionFolder . DS . 'action' . DS . $this->folder . DS . $this->folder . '.php', $code, 'overwrite' );
	
	return true;
	

}
function addValidate(){
	
	$extensionFolder=WExtension::get( $this->wid, 'folder' );
	$this->namekey=$extensionFolder . '.' . $this->folder;
	
	return true;
	
}

function deleteValidate($eid=0){
	$this->_x=$this->load( $eid );
	return true;
}
function deleteExtra($eid=null){
	
	$extensionFolder=WExtension::get( $this->_x->wid, 'folder' );
		
	$fileC=WGet::folder();
	$fileC->delete( JOOBI_DS_USER . 'custom' . DS . $extensionFolder . DS . 'action' . DS . $this->_x->folder );
	
	return true;
	
}
}