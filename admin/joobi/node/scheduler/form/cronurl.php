<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Scheduler_CoreCronurl_form extends WForms_default {
function create(){



	$link='controller=scheduler&task=process' . URL_NO_FRAMEWORK;

	$pwd=WPref::load( 'PSCHEDULER_NODE_USEPWD' );

	if( $pwd ) $link .='&password=ENTER YOUR PASSWORD HERE';

	$formated=WPage::linkHome( $link, false );



	$this->content='<a target="_blank" href="'.$formated.'">'.$formated.'</a>';



	return true;



}}