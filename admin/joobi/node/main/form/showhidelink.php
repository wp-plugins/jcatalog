<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WForm_Coreshowhidelink extends WForms_default {









	function create() {
		static $onlyOnce = true;


		if ( empty( $this->element->toogledivname ) ) return false;

				if ( $onlyOnce ) {
			$onlyOnce = false;

			$JScode = 'function hideShowDiv(e,id){jQuery(\'#\'+id).toggle(\'slow\',function(){var text=jQuery(e).val() ? jQuery(e).val():jQuery(e).text();var other_text=jQuery(e).attr("name");jQuery(e).attr("name", text);jQuery(e).val() ? jQuery(e).val(other_text):jQuery(e).text(other_text);});}';
			WPage::addJSScript( $JScode, 'jquery', false );

		}
		if ( !empty($this->element->style) ) $style=' style="'.rtrim( $this->element->style, ';' ).';"';
		else $style='';


		$this->content = '<div name="'. $this->element->name .'" onclick="hideShowDiv(this,\''. $this->element->toogledivname .'\');return false;"'.$style.'>'. $this->element->name .'</div>';	
		return true;

	}









	function show() {

		return $this->create();

	}
}