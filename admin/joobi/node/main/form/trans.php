<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














WView::includeElement( 'form.text' );
class WForm_Coretrans extends WForm_text {

	protected $image = '';
	protected $button = '';
	protected $infoBubble = '';
	protected $tooltip = '';
	protected $translationOF = '';
	protected $url = '';

	function create() {

		$useMultipleLang = WPref::load( 'PLIBRARY_NODE_MULTILANG' );

						if ( $useMultipleLang && WGlobals::checkCandy(50) && !empty($this->element->type) && $this->element->typeName == 'trans' && $this->newEntry == false ) {

			$this->infoBubble = WText::t('1206732374FDLR');

			parent::create();

			$model = WModel::get( $this->modelID, 'object' );

			
			$myLien = '&eid=' . $this->eid;
			$myLien .= '&' . $model->getPK() . '=' . $this->eid;
			$myLien .= '&eidmap=' . $model->getPK();
			$myLien .= '&lgid=' . WUser::get('lgid');
			$myLien .= '&map=' . $this->element->map;
			$myLien .= '&fieldtopo=box';

			if ( isset($this->element->width) ) $myLien .= '&width=' . $this->element->width;
			else {
				$this->element->width=40;
				$myLien .= '&width='.$this->element->width;
			}
			if ( isset($this->element->height) ) $myLien .= '&height='.$this->element->height;
			else {
				$this->element->height = 10;
				$myLien .= '&height='.$this->element->height;
			}
			$myLien .= '&sid='.$this->element->sid;
			$myLien .= '&title=' . urlencode($this->controller->controller);

			$this->url = WPage::linkPopUp( 'controller=translation-element&task=edit' . $myLien, false );


			$TRANSLATED_NAME = strtolower( $this->element->name );
			$this->translationOF = str_replace(array('$TRANSLATED_NAME'), array($TRANSLATED_NAME),WText::t('1339210773JBLQ'));

			$this->tooltip = str_replace(array('$TRANSLATED_NAME'), array($TRANSLATED_NAME),WText::t('1339210773JBLR'));


			$this->renderTransCreate();

		} else {

			$status = parent::create();
			return $status;

		}
		return true;

	}
}