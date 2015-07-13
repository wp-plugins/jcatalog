<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');





























class WRender_Widgetbox_classObject {



	





	public $title = '';



	





	public $content = '';



	





	public $id = null;



	





	public $headerRightA = array();

	public $headerCenterA = array();



	





	public $faicon = null;

	public $color = null;





}




class WRender_Widgetbox_class extends Theme_Render_class {



	private static $_paneIcon = null;

	private static $_paneColor = null;





























  	public function render($data) {



  		if ( empty($data->content) || '<div></div>' == $data->content ) return '';






		
		if ( WPref::load( 'PMAIN_NODE_DIRECT_EDIT' ) ) {

			$outputDirectEditC = WClass::get( 'output.directedit' );

			$editButton = $outputDirectEditC->editView( 'form', $this->yid, $data->element->fid, 'form-layout' );

			if ( !empty($editButton) ) $data->params->text = $editButton . $data->params->text;

		} elseif ( WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' ) ) {

			$outputDirectEditC = WClass::get( 'output.directedit' );

			$editButton = $outputDirectEditC->translateView( 'form', $this->yid, $data->element->fid, $data->params->text );

			if ( !empty($editButton) ) $data->params->text = $editButton . $data->params->text;

		}


		if ( !empty($data->element->fid) ) {

			$nagivation = WGlobals::get( 'paginationFormElementNav' . $data->element->fid, '', 'global' );

			WGlobals::set( 'paginationFormElementNav' . $data->element->fid, '', 'global' );

			$NbDisplay = WGlobals::get( 'paginationFormElementDisplay' . $data->element->fid, '', 'global' );

			WGlobals::set( 'paginationFormElementDisplay' . $data->element->fid, '', 'global' );

		}




		$panel = new stdClass;

		if ( !empty( $data->params->idText ) ) $panel->id = $data->params->idText;

		if ( !empty($data->element->faicon) ) $panel->faicon = $data->element->faicon;

		if ( !empty($data->element->color) ) $panel->color = $data->element->color;

		if ( empty( $data->element->notitle ) && empty( $data->element->spantit ) && !empty($data->params->text) ) {

			$panel->header = $data->params->text;

		}


		$panel->body = $data->content;



		if ( empty( $data->element->spantit ) && !empty($nagivation) ) {

			$panel->headerRightA[] = $nagivation;

		}


		$widgetHTML = WPage::renderBluePrint( 'panel', $panel );

		return $widgetHTML;





  	}


}