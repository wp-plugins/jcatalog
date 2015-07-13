<?php 

* @link joobi.co
* @license GNU GPLv3 */

















WView::includeElement( 'form.textarea' );
class WForm_Coretransarea extends WForm_textarea {

	protected $image = '';
	protected $button = '';
	protected $infoBubble = '';
	protected $tooltip = '';
	protected $translationOF = '';
	protected $url = '';

	function create() {

		$useMultipleLang = WPref::load( 'PLIBRARY_NODE_MULTILANG' );


		
				if ( $useMultipleLang && WGlobals::checkCandy(50) && isset($this->element->type) && $this->newEntry == false) {

			$this->infoBubble = WText::t('1206732374FDLR');

			parent::create();

			$model = WModel::get( $this->modelID, 'object' );


			$myLien = '&eid='.$this->eid;
			$myLien .= '&'.$model->getPK().'='.$this->eid;
			$myLien .= '&eidmap='.$model->getPK();
			$myLien .= '&lgid='.WUser::get('lgid');
			$myLien .= '&map='.$this->element->map;
			$myLien .= '&fieldtopo=area';

			if ( isset($this->element->width) ) $myLien .= '&width='.$this->element->width;
			else {
				$this->element->width=40;
				$myLien .= '&width='.$this->element->width;
			}
			if ( isset($this->element->height) ) $myLien .= '&height='.$this->element->height;
			else {
				$this->element->height = 10;
				$myLien .= '&height='.$this->element->height;
			}
			$myLien .= '&sid=' . $this->element->sid;
			$myLien .= '&title=' . urlencode($this->controller->controller);

			$this->url = WPage::linkPopUp( 'controller=translation-element&task=edit' . $myLien, false );


			$TRANSLATED_NAME = strtolower($this->element->name);
			$this->translationOF = str_replace(array('$TRANSLATED_NAME'), array($TRANSLATED_NAME),WText::t('1339210773JBLQ'));

			$this->tooltip = str_replace(array('$TRANSLATED_NAME'), array($TRANSLATED_NAME),WText::t('1339210773JBLR'));



			$this->renderTransCreate();

		} else {

			return parent::create();

		}
		return true;

	}
}