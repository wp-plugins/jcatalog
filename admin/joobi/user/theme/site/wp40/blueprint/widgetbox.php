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

	public $bottomRightA = array();

	public $bottomCenterA = array();



	





	public $faicon = null;

	public $color = null;





}




class WRender_Widgetbox_class extends Theme_Render_class {



	private static $_paneIcon = null;

	private static $_paneColor = null;





























  	public function render($data) {



  		if ( empty($data->content) || '<div></div>' == $data->content ) return '';



  		$container =



		$panel = WPage::newBluePrint( 'panel' );

		$panel->type = $this->value( 'catalog.container' );


		$panel->header = $data->title;

		$panel->body = $data->content;

		if ( !empty($data->id) ) $panel->id = $data->id;

		$panel->headerRightA = $data->headerRightA;

		$panel->headerCenterA = $data->headerCenterA;

		$panel->bottomRightA = $data->bottomRightA;

		$panel->bottomCenterA = $data->bottomCenterA;

		$panel->faicon = $data->faicon;

		$panel->color = $data->color;

		$panel->class = 'widgetBox';



		$widgetHTML = WPage::renderBluePrint( 'panel', $panel );

		return $widgetHTML;





  	}


}