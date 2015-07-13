<?php 

* @link joobi.co
* @license GNU GPLv3 */



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