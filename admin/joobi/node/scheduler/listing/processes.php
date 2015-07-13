<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_CoreProcesses_listing extends WListings_default{
function create(){



	$hidMaxprocess='maxprocess_'.$this->modelID;

	$maxprocess=$this->data->$hidMaxprocess;

	

	if( $this->value==0){

		$this->content='<span > Process ( '.$this->value.'/'.$maxprocess.' )</span>';

	}elseif( $this->value > $maxprocess){

		$this->content='<span style="color:red;"> Running ( '.$this->value.'/'.$maxprocess.' )</span>';

	}elseif($maxprocess==$this->value){

		$this->content='<span style="color:orange;"> Running ( '.$this->value.'/'.$maxprocess.' )</span>';

	}else{

		$this->content='<span style="color:green;"> Running ( '.$this->value.'/'.$maxprocess.' )</span>';

	}
	

	return true;

}}