<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Currency_CoreExample_listing extends WListings_default{










function create() {



	$this->content = WTools::format( 129.35 , 'money', $this->value );

	return true;



















}}