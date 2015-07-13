<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_CoreAuthor_form extends WForms_default {
	

function show(){

	$sidext=WModel::get('apps.info','sid');

	$author_var='author_'.$sidext;

	$url_var='homeurl_'.$sidext;



	if(empty($this->data->$author_var)){

		$author='Joobi';

	}else{

		$author=$this->data->$author_var;

	}

	

	if(empty($this->data->$url_var)){

		if(!defined('PAPPS_NODE_HOME_SITE')) WPref::get('apps.node');

		$url=PAPPS_NODE_HOME_SITE;

	}else{

		$url=$this->data->$url_var;

	}

	$this->content=WText::t('1206732400OWZO') . ': <a target=“_blank” href="'.$url.'">'.$author.'</a>';

	return true;

}}