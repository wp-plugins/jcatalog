<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













class Api_Wp4_Editor_addon extends WClasses {



	









	public $cols=80;



	









	public $rows=10;



	









	public function display(){

		$editor=JFactory::getEditor( $this->editorName );

		$editor->initialise();

		$html=$editor->display( $this->name, $this->content ,$this->width, $this->height, $this->cols, $this->rows, $this->showButtons );

		return $html;

	}
















	public function getEditorName(){
















		$editors=array();

		$editors['framework.']=WText::t('1352226844OYVM');











		return $editors;

	}


}