<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_configuration_form_view extends Output_Forms_class {

function prepareView() {



		$configElementA = WGlobals::get( 'configElementA', array(), 'global' );

		if ( empty( $configElementA ) ) return false;



		$orderedA = WGlobals::get( 'configOrderA', array(), 'global' );



		$SamplePane = $this->elements[0];



		$newElementsA = array();

		$count = 1;

		$parent = 0;

		foreach( $orderedA as $extension => $mapA ) {



			
			$Pane = null;

			$Pane = clone($SamplePane);

			$Pane->name = WExtension::get( $extension, 'name' );

			$Pane->fid = $count;

			$parent = $count;



			$newElementsA[] = $Pane;



			foreach( $mapA as $prefNamekey => $map ) {

				$count++;



				if ( !isset($configElementA[$map]) ) continue;

				$pref = $configElementA[$map];

				$pref->fid = $count;

				$pref->parent = $parent;



				$typeSplitA = explode( '.', $pref->type );

				if ( empty($typeSplitA[1]) ) {

					$pref->typeNode = 'output';

					$pref->typeName = $typeSplitA[0];

				} else {

					$pref->typeNode = $typeSplitA[0];

					$pref->typeName = $typeSplitA[1];

				}

				if ( 'output.customized' == $pref->type ) continue;


				$newElementsA[] = $pref;



			}


			$count++;



		}
		$this->elements = $newElementsA;



		return true;



	}
}