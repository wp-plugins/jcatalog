<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

















class WListing_Coredyninput extends WListings_default{





	function create() {
		static $onlyOnce = true;

						$linepropID = $this->name . $this->line;
		$divID1='dyn_'.$linepropID;
		$divID2='Ndyn_'.$linepropID;
		$ondblclick = 'wzflipIpt(\''.$divID1.'\',\''.$divID2.'\')';
		$div1 = new WDiv( $this->value );
		$div1->classes = 'jdyninput';
		$div1->ondblclick = $ondblclick;
		$div1->id = $divID1;
		$part1 = $div1->make();

		if ( $onlyOnce ) {
			$flipFunc = '';
			if ( WGet::isDebug() ) $flipFunc .= '/* function to flip the dynamic imput */' . $this->crlf;
			$flipFunc .= 'wzflipIpt=function(d1,d2){' . $this->crlf .
'document.getElementById(d1).style.display=\'none\';' . $this->crlf .
'document.getElementById(d2).style.display=\'block\';' . $this->crlf .
'}';
			$onlyOnce = false;
			WPage::addJS( $flipFunc );

		}

				
		$inputId='jdyninput' . $linepropID;
		$pkeyMap = $this->pkeyMap;

				if ( is_array($pkeyMap) ) {
			$eid = '';
			foreach( $pkeyMap as $onePK ) {
				$eid .= $onePK . '|' . $this->data->$onePK . ':';
			}
			$extras = "{'em':'em". $this->line."','zval':document.getElementById('".$inputId."').value,'mpk':'1'";

		} else {
			$eid = $this->data->$pkeyMap;
			$extras = "{'em':'em". $this->line."','zval':document.getElementById('".$inputId."').value";
		}
				
		if ( defined('PLIBRARY_NODE_SCRIPTTYPE') ) $script = PLIBRARY_NODE_SCRIPTTYPE;
		else $script=1;

				$param = new stdClass;
		$aid ='';
		if ( $script ) {
			$link = 'controller=' . $this->controller;
			$param->jsButton = array( 'ajaxToggle'=>1, 'ajxUrl'=> $link );
			$extras .= ", 'divId':'". $divID1."','elemType':'dyninput','myId':'". $eid."'";
		}
		$extras.="}";
				$onclick = $this->elementJS( $extras, $param );

		$inputBox = '<div class="input-group">';

		$inputBox .= '<input id="'.$inputId.'" size="' . strlen($this->value). '" type="text" value="' . $this->value . '" class="jdyninput form-control" style="width:100%!important;"/> ';
		$inputBox .= '<span class="input-group-addon"><a href="#" value="submit" onclick="'.$onclick.'" style="float:left;">';

		$legendO = new stdClass;
		$legendO->sortUpDown = true;
		$legendO->action = 'saveOrder';
		$legendO->alt = WText::t('1206732363AOLD');
		$inputBox .= WPage::renderBluePrint( 'legend', $legendO );

		$inputBox .= '</a></span>';
		$inputBox .= '</div>';

		$div2 = new WDiv( $inputBox );
		$div2->style='display:none;';
		$div2->id=$divID2;
		$part2 = $div2->make();

		$this->content = $part1 . $part2;
		return true;

	}
}


