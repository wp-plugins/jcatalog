<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Scheduler_Schedulerparameters_form extends WForm_layout {
function create(){



	
	$namekey=$this->getValue('viewname');

	$namekey=str_replace( '.', '_', $namekey ) . '_scheduler_pref';

	$controller=new stdClass;

	$controller->controller='scheduler';

	$controller->nestedView=true;

	$controller->wid=WExtension::get( 'scheduler','wid');


		$exist=WView::get( $namekey, 'yid', null, null, false );


	



	if($exist){

		$this->viewID=$namekey;

		return parent::create();



		
	}else{

		return false;

	}


	








	return true;



}}