<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.text' );
class Main_CoreExtendsclass_form extends WForm_text {


	function create() {



		$eid = WGlobals::getEID();



		$pattern='/[a-zA-Z0-9]+(?=\])/';

		preg_match($pattern,$this->element->map, $matches);

		$task = $matches[0];



		WLoadFile( 'design.system.class', JOOBI_DS_NODE );

		$extFileA = WAddon::get( 'design.' . $task );

		$this->value = $extFileA->getExtends( $eid );



		return parent::create();

	}}