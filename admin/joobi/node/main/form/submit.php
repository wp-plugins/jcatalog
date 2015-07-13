<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.text' );
class WForm_Coresubmit extends WForm_text {

	protected $inputClass = 'button';
	protected $inputType = 'submit';	




	function create() {
										preg_match( '/[a-zA-Z0-9]+(?=\])/', $this->element->map, $matches );

						$task = ( !empty($matches) ) ? $matches[0] : '';

		$formObject = WView::form( $this->formName );
		$formObject->hidden('task', $task, true );
		$submitrequired = ( isset( $this->element->submitrequired) ) ? true : false;
		

		$req = ( !empty( $this->reqtask ) ) ? true : false;
		if ( !isset($this->nojsvalid ) ) {

			$paramsArray = array();
			$jscript = WPage::getScript();
						if ( $req || $submitrequired || in_array( $task, array( 'apply', 'save', 'register', 'goregister', 'gologin' ) ) ) {
				$paramsArray['validation']=true;
			}
			$paramsArray['enterSubmit'] = true;


			if ( WGlobals::get( 'is_popup', false, 'global' ) ) {
				if ( !empty($this->element->popclose) ) $paramsArray['popclose'] = true;
				if ( !empty($this->element->poprefresh) ) {
					$paramsArray['refresh'] = true;
					$paramsArray['ajx'] = true;
				}			}
			$paramsArray['disable']=true;
			$joobiRun = WPage::actionJavaScript( $task, $this->formName, $paramsArray );
			$this->extras = ' onClick="return '.$joobiRun .'"';

		}
				$this->value = $this->element->name;


		if ( !empty( $this->element->themepref ) ) {
			$explodeA = explode( '.', $this->element->themepref );
			$objButtonO = WPage::newBluePrint( 'prefcatalog' );
			$objButtonO->type = $explodeA[1];
		} else {
			$objButtonO = WPage::newBluePrint( 'button' );
			$objButtonO->type = 'button';
		}
		if ( !empty( $this->idLabel ) ) $objButtonO->id = $this->idLabel;

		$objButtonO->text = $this->element->name;
		if ( !empty($this->element->faicon) ) $objButtonO->icon = $this->element->faicon;
		if ( !empty($this->element->color) ) $objButtonO->color = $this->element->color;
		$objButtonO->linkOnClick = 'return ' . $joobiRun;

		if ( !empty( $this->element->themepref) ) {
			$this->content = WPage::renderBluePrint( 'prefcatalog', $objButtonO );
		} else {
			$this->content = WPage::renderBluePrint( 'button', $objButtonO );
		}
				if ( !empty($this->element->width) ) {
			$this->content = '<div style="width:' . $this->element->width . '">'  . $this->content . '</div>';
		}
		return true;

	}




	function show() {
		return $this->create();
	}





}