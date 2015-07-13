<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














class WForm_Corewidgetbox extends WForms_default {




	function create() {
				return true;
	}



	function show() {
		return true;
	}



	function start(&$frame,$params=null) {
						if ( !empty($params->parent) ) return parent::start( $frame, $params );
		$frame->startPane( $params );

	}




	public function addElementToField(&$frame,$params=null,$HTML=null) {

		if ( empty($HTML) ) return '';


				if ( WPref::load( 'PMAIN_NODE_DIRECT_EDIT' ) ) {
			$outputDirectEditC = WClass::get( 'output.directedit' );
			$editButton = $outputDirectEditC->editView( 'form', $this->yid, $this->element->fid, 'form-layout' );
			if ( !empty($editButton) ) $params->text = $editButton . $params->text;
		} elseif ( WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' ) ) {
			$outputDirectEditC = WClass::get( 'output.directedit' );
			$editButton = $outputDirectEditC->translateView( 'form', $this->yid, $this->element->fid, $params->text );
			if ( !empty($editButton) ) $params->text = $editButton . $params->text;
		}

		$data = WPage::newBluePrint( 'widgetbox' );
		$data->content = $HTML;
		$data->fid = $this->element->fid;

		if ( empty( $this->element->notitle ) && empty( $this->element->spantit ) ) {
			$data->title = $params->text;
		}
		$data->id = $params->idText;
		if ( !empty($this->element->faicon) ) $data->faicon = $this->element->faicon;
		if ( !empty($this->element->color) ) $data->color = $this->element->color;

		$nagivation = WGlobals::get( 'paginationFormElementNav' . $this->element->fid, '', 'global' );
		WGlobals::set( 'paginationFormElementNav' . $this->element->fid, '', 'global' );
		$NbDisplay = WGlobals::get( 'paginationFormElementDisplay' . $this->element->fid, '', 'global' );
		WGlobals::set( 'paginationFormElementDisplay' . $this->element->fid, '', 'global' );

		if ( empty( $this->element->spantit ) && !empty($nagivation) ) {
			$panel->headerRightA[] = $nagivation;
		}

		$widgetHTML = WPage::renderBluePrint( 'widgetbox', $data );

		$frame->cell( $widgetHTML, 'Widgetbox' );
		$frame->line( $this->element );

	}





}