<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class WListing_Corepremium extends WListings_default{





	public function createHeader() {
				if ( empty($this->element->align) ) $this->element->align = 'center';
		if ( empty($this->element->width) ) $this->element->width = '30px';
				return false;
	}





	function create() {

		if ( defined('PLIBRARY_NODE_SCRIPTTYPE') ) $script = PLIBRARY_NODE_SCRIPTTYPE;
		else $script = 1;

		if ( isset($this->element->noscript) ) $script = 0; 
				$script = 0;

		if ( !empty($this->value) ) {
			$class 	= 'yes';
			$nameTag = WText::t('1206732372QTKI');
			$order = 1;
			$this->valueTo=0;
		} else {
						$class 	= 'cancel';
			$nameTag = WText::t('1206732372QTKJ');
			$order = 2;
			$this->valueTo='1';
		}
		if ( isset( $this->element->style) ) $style = 'style="'. $this->element->style .'" ';
		else $style ='';

		if ( !isset($this->element->infonly) && !isset($this->element->lien) ) {

			$pkeyMap = $this->pkeyMap;
			$eid = $this->data->$pkeyMap;

			$extra="";
						$param = new stdClass;
			$id ='';
			$aid ='';
			if (strpos($pkeyMap,',')) { 				$message=WMessage::get();
				$message->adminN('You cannot have premium on a cross table. Kindly remove premium column!');
				$this->content='';
				return true;
			}
			if ( $script ) {
				$link = 'controller=' . $this->controller;

				$param->jsButton = array( 'premium'=>1, 'ajxUrl'=> $link );
				if ( empty($this->element->noscript) ) $param->jsButton['ajaxToggle'] = 1; 
								$id =  $this->element->sid.'_'.$this->element->map.'_'.$this->data->$pkeyMap;
				$aid="a".$id;
				$extra="{'em':'em". $this->line."','zval':".$this->valueTo;
				$extra .= ",'divId':'".$id."','title':'". $nameTag."','elemType':'premium','myId':'". $eid."'";
				$extra.="}";

				$param->extra = 'premium';
								$onclick = $this->elementJS( $extra, $param );
				$name = $id;
				if ($class=='yes') $id = 'premium' . $eid;

				$this->content = '<a style="cursor:pointer" id="'.$aid.'" onclick="'.$onclick.'" title="'.  $nameTag.' '.WText::t('1206732372QTKR') .'">';

			} else {

				$paramA = array();
				$paramA['zsid'] = $this->element->sid;
				$paramA['zmap'] = $this->element->map;
				$zsc = WTools::secureMe( $paramA );
				$link = WPage::link( 'controller=' . $this->controller . '&task=toggle&eid=' . $eid . '&zmap=premium&zsid=' . $this->element->sid . '&zval=' . $this->valueTo . '&zsc=' . $zsc  );
				$this->content = '<a href="' . $link . '" id="' . $aid . '" title="'.  $nameTag . ' ' . WText::t('1206732372QTKR') .'">';

			}

			$data = new stdClass;
			$data->image = $class;
			$data->text = $nameTag;
			$data->group = 'publish';
			$data->ID = $id;
			$imageHTML = WPage::renderBluePrint( 'legend', $data );

			$this->content .= $imageHTML;
			$this->content .= '</a>';

		} else {

			$data = new stdClass;
			$data->image = $class;
			$data->text = $nameTag;
			$data->group = 'publish';
			$this->content = WPage::renderBluePrint( 'legend', $data );

		}
		return true;

	}
}