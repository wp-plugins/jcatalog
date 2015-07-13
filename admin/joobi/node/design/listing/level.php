<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Corelevel extends WListings_default{





	public function createHeader() {
				if ( empty($this->element->align) ) $this->element->align = 'center';
		if ( empty($this->element->width) ) $this->element->width = '40px';
				return false;
	}





	function create() {

		switch ((int)$this->value) {
			case 25:
				$color = 'orange';
				$groupname = 'PLUS';
				$this->valueTo=50;
				break;

			case 50:
				$color = 'red';
				$groupname = 'PRO';
				$this->valueTo=0;
				break;

			case 0:
			default:
				$color = 'black';
				$groupname = 'CORE';
				$this->valueTo=25;
				break;

		}
		$script = WPref::load( 'PLIBRARY_NODE_SCRIPTTYPE' );

				$param = new stdClass;
		$id ='';
		$aid ='';
		$extra ='';
		if ($script){
			$link = 'controller='.$this->controller;
			$param->jsButton =array('ajaxToggle'=>1, 'ajxUrl'=> $link );
			$pkeyMap = $this->pkeyMap;
						$id =  $this->element->sid.'_'.$this->element->map.'_'.$this->data->$pkeyMap;
			$aid="a".$id;
			$pkeyMap = $this->pkeyMap;
			$eid = $this->data->$pkeyMap;
			$extra = "{'em':'em". $this->line."','zval':".$this->valueTo.",'divId':'".$id."','elemType':'level','myId':'". $eid."'}";
			}
				$onclick=$this->elementJS($extra, $param);

		$this->content = '<a style="color: '.$color.'; cursor:pointer" id = "'.$id.'" onclick="'.$onclick.'">
		'. $groupname .'</a>';
		return true;

	}
}