<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_CoreFilename_listing extends WListings_default{
function create() {



	$this->content = $this->getValue( 'name', 'files' );	

	$type =  $this->getValue( 'type', 'files');

	if ( $type != '' ) {

		$this->content .=  '.' . $type;

	}


return true;



}}