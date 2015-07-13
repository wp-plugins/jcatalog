<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class WForm_Coreprogressbar extends WForms_default {


	var $targetTotal = ''; 	  	 	var $target = '';		 	var $labelStyle = ''; 		 	var $labelMsg = '';      	 	var $completeStyle = ''; 	 	var $completeMsg = '';       	var $zeroStyle = ''; 		 	var $zeroMsg = '';     		 	var $percentage = 0;         	var $height = '';     			var $width = ''; 			

	function create() {

		
		if (empty($this->percentage)){
						if (empty($this->targetTotal)){
				if ( empty($this->value))return false;
				else $this->targetTotal = $this->value;
			}
						if (empty($this->target)){
				$target = $this->getValue('target');
				if (empty($target)) $this->target = 0;
				else $this->target = 	$target;
			}		}



		$progressO = WPage::newBluePrint( 'progressbar' );
		$progressO->targetTotal = $this->targetTotal;
		$progressO->target = $this->target;
		$progressO->labelStyle = $this->labelstyle;
		$progressO->labelMsg = $this->labelMsg;
		$progressO->completeStyle = $this->completeStyle;
		$progressO->completeMsg = $this->completeMsg;
		$progressO->zeroStyle = $this->zeroStyle;
		$progressO->zeroMsg = $this->zeroMsg;
		$progressO->height = ( !empty($this->height) ? $this->height : '30px' );
		$progressO->width = ( !empty($this->width) ? $this->width: '200px' );

		$this->content = WPage::renderBluePrint( 'progressbar', $progressO );

		return true;

	}}


