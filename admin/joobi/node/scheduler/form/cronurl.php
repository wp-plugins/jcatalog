<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_CoreCronurl_form extends WForms_default {
function create(){



	$link='controller=scheduler&task=process' . URL_NO_FRAMEWORK;

	$pwd=WPref::load( 'PSCHEDULER_NODE_USEPWD' );

	if( $pwd ) $link .='&password=ENTER YOUR PASSWORD HERE';

	$formated=WPage::linkHome( $link, false );



	$this->content='<a target="_blank" href="'.$formated.'">'.$formated.'</a>';



	return true;



}}