<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



 class Main_Alias_tag {

 	private $_namekeyA = array();






	public function process($object) {
		static $count=1;

		$this->_namekeyA = array();
		$namekeyToTagA = array();

				foreach( $object as $tag => $parameters ) {
			$tmp = trim( $tag, '{}');
			$explodeA = explode( '|', $tmp );
			if ( !empty($explodeA[1]) ) {
				$id = trim($explodeA[1]);
				$this->_namekeyA[$tag] = $id;
				$parameters->key = $id;
				$namekeyToTagA[$id] = $tag;
			}
		}
		if ( empty($this->_namekeyA) ) {
			return $this->_returnTagsValues( $object );
		}
		$outputWidgetsC = WClass::get( 'output.widgets' );
		$allWidgetsA = $outputWidgetsC->loadWidgetsFromNamekey( $this->_namekeyA );
		
		$tagsA = array();

		$tagProcessC = WClass::get('output.process');

		foreach( $allWidgetsA as $oneWidget ) {

						if ( empty($namekeyToTagA[$oneWidget->namekeyWidget]) ) continue;

			$myTag = $namekeyToTagA[$oneWidget->namekeyWidget];

			$name = explode( '.', $oneWidget->namekey );
			$exists = WLoadFile( $name[0].'.module.'.$name[1].'.'.$name[1] , JOOBI_DS_NODE  );
			$className = ucfirst( $name[0] ) . 'Core_' . ucfirst($name[1]).'_module';


			if ( $exists && class_exists( $className ) ) {
				
				WTools::getParams( $oneWidget );

				if ( empty($oneWidget->widgetID) ) $oneWidget->widgetID = 'wdgtalias_' . $count++;
				if ( empty($oneWidget->widgetSlug) ) $oneWidget->widgetSlug = str_replace( '.', '_', $oneWidget->namekey );

				$newClass = new $className( $oneWidget );
				$newClass->create();
				$convertedTag = $newClass->content;

							} else {
				
								$convertedTag = '{widget:' . $name[1] . '|' . str_replace( "\n", '|', $oneWidget->params ) . '}';
				$tagC = WClass::get('output.process');
				$tagC->replaceTags( $convertedTag );

			}

			$tagsA[$myTag] = $convertedTag;

		}
				foreach( $object as $tag => $parameters ) {
			if ( !isset($tagsA[$tag]) ) $tagsA[$tag] = '';
		}
		return $tagsA;

	}






	private function _returnTagsValues($object,$resultA=array()) {

		$tagsA = array();
		foreach( $object as $tag => $parameters ) {

			if ( !empty( $this->_namekeyA[$tag] ) ) {
				$namekey = $this->_namekeyA[$tag];
				if ( !empty($resultA[$namekey]) ) {
					$tagsA[$tag] = $resultA[$namekey];
				} else {
					$tagsA[$tag] = '';
				}
			} else {
				$tagsA[$tag] = '';
			}
		}
		return $tagsA;

	}
}