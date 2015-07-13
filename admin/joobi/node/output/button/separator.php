<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WButton_Coreseparator extends WButtons_default {

var $_noJS=true;





	function create(){

		$width=( !empty($this->width)) ? ' style="width:'.$this->width.';"' : '';

		if( $this->buttonO->type==90){
			$this->content='&nbsp;<div class="dividerBar"'.$width.'></div>';
		}elseif( $this->buttonO->type==91){
			$this->content='&nbsp;<div class="dividerSpace"'.$width.'></div>';
		}
		return true;

	}
}
