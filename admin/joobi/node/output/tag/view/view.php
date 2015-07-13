<?php 

* @link joobi.co
* @license GNU GPLv3 */






class Output_View_tag {
 	 	




	function process($givenTagsA){
		$replacedTagsA=array();
		foreach( $givenTagsA as $tag=> $myTagO){

			if( empty($myTagO->name)) continue;
			if( empty($myTagO->controller)) continue;
			if( empty($myTagO->extension)) continue;
			$controller=new stdClass;
			$controller->controller=$myTagO->controller;
			$controller->wid=WExtension::get( $myTagO->extension, 'wid');
			if( !empty($myTagO->model)) $controller->sid=WModel::get( $myTagO->model, 'sid' );

			$replaceBackEID=false;
			$params=new stdClass;
									if( !empty($myTagO->eid) && is_numeric( $myTagO->eid )){
				$params->_eid=$myTagO->eid; 				$replaceBackEID=true;
				$eid=WGlobals::get( 'eid' );
				WGlobals::set( 'eid' , $myTagO->eid );
			}
			$view=WView::getHTML( $myTagO->name, $controller, $params );
			if( empty($view)){
				$replacedTagsA[$tag]='';
				if( $replaceBackEID ) WGlobals::set( 'eid' , $eid );
				continue;
			}
			$replacedTagsA[$tag]=$view->make();

						if( $replaceBackEID ) WGlobals::set( 'eid' , $eid );

						if( !empty($view->cssfile)){
				$widCat=WExtension::get( $view->folder . '.node', 'folder' );
				if( !empty($widCat)){
					WPage::addCSSFile( 'tag/' . $widCat . '/css/style.css' );
				}
			}
		}
		return $replacedTagsA;


	}
 }