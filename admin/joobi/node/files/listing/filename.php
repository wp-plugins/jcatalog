<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Files_CoreFilename_listing extends WListings_default{
function create() {



$myType = $this->getValue('type');

$this->value = $this->getValue('name', 'files');



if ( $myType != 'url' ) {

	$this->value .= '.' . $this->getValue('type');

}



return parent::create();



}}