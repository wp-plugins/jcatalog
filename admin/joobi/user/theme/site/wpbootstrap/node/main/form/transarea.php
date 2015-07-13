<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class WForm_transarea extends WForm_Coretransarea {





	protected function renderTransCreate() {

		$buttonO = WPage::newBluePrint( 'button' );
		$buttonO->type = 'infoLink';
		$buttonO->tooltips = $this->infoBubble;
		$buttonO->link = $this->url;
		$buttonO->useTitle = false;
		$buttonO->text = '<i class="fa fa-language"></i>';
		$buttonO->id = 'tr_' . $this->idLabel;
		$buttonO->popUpIs = true;
		$buttonO->popUpWidth = '600';
		$buttonO->popUpHeight = '450';


				$html = $this->content;
		$html .= '<span class="add-on">';
		$html .= $myBotton;
		$html .= '</span>';

		$this->content = $html;


	}

}