<?php 

* @link joobi.co
* @license GNU GPLv3 */



WLoadFile( 'users.class.parent', JOOBI_DS_NODE );
class Users_Wordpress_addon extends Users_Parent_class {

	function getPicklistElement(){
		$wordpress=new stdClass;
		$wordpress->option='wordpress';
		$wordpress->label='wordpress';
		$wordpress->extension='wordpress';
		return $wordpress;
	}
}