<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');































class WRender_Frame_class extends Theme_Render_class {





	  	public function render($data) {




	  		$params = $data->params;

			
			switch( $data->frame ) {

				case 11:	
					WLoadFile( 'blueprint.frame.list', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_list( $params );

					break;

				case 21:

					$formTabFade = $this->value( 'form.tabfade' );

					WLoadFile( 'blueprint.frame.tabs', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_tabs( $params );

					$frame->fade = $formTabFade;

					break;

				case 27:

					$formTabFade = $this->value( 'form.tabfade' );

					WLoadFile( 'blueprint.frame.tabvertical', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_tabvertical( $params );

					$frame->fade = $formTabFade;

					break;





				case 31:

				case 91:

					WLoadFile( 'blueprint.frame.div', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_div( $params );

					break;

				case 51:

					WLoadFile( 'blueprint.frame.sliders', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_sliders( $params );

					break;

				case 115:

					WLoadFile( 'blueprint.frame.nopane', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_nopane( $params );

					break;

				case 83:	
					WLoadFile( 'blueprint.frame.column', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_column( $params );

					break;

				case 84:

					WLoadFile( 'blueprint.frame.row', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_row( $params );

					break;

				default:

					WLoadFile( 'blueprint.frame.list', JOOBI_DS_THEME_JOOBI );

					$frame = new WPane_list( $params );

					break;



			}


			return $frame;



	  	}




}












abstract class WPane extends WElement {	


	var $useCookies = true;











	function &getInstance($behavior='tabs',$params=array()) {



		$classname = 'WPane_'.$behavior;

		$instance = new $classname($params);



		return $instance;

	}


}






















































































