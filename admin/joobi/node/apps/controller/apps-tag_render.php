<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_tag_render_controller extends WController {

	function render(){



		$id=WGlobals::get( 'id' );
			if( !empty($id)){
			$tag='{widget:alias|' . $id . '}';
		}elseif( empty($tag)){
			$tag=WGlobals::get( 'tag' );
		}
		if( empty($tag)){
			echo WText::t('1431936850KAHW');
			exit;
		}
		$html='';
				if( !empty($tag)){
			$tagClass=WClass::get('output.process');
			$tagClass->replaceTags( $tag );
			$html=$tag;
		}
		echo $html;
	

		return true;



	}
}