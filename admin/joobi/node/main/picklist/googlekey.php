<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Googlekey_picklist extends WPicklist {
function create() {


	$mainCredentialsC = WClass::get( 'main.credentials' );

	$mainCredentialsC->picklistFromType( $this, 'googleapi' );



	return true;



}}