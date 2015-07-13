<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');































class WRender_Tooltips_classObject {



	public $tooltips = '';	
	public $text = '';	


	public $title = '';	


	public $id = '';



	public $class = '';	


}




class WRender_Tooltips_class extends Theme_Render_class {



	private static $_method = null;

	private static $_placement = '';

	private static $_html = true;

	private static $_trigger = '';

	private static $_location = '';





























  	public function render($data) {



  		if ( empty($data->tooltips) ) return '';



  		
  		if ( !isset(self::$_method) ) {

			self::$_method = $this->value( 'tooltip.method' );

			self::$_placement = $this->value( 'tooltip.placement' );

			self::$_html = $this->value( 'tooltip.html' );

			self::$_trigger = $this->value( 'tooltip.trigger' );

			if ( self::$_trigger == 'hover focus' && self::$_method == 'tooltip' ) {

				self::$_trigger = '';

			} elseif ( self::$_trigger == 'click' && self::$_method == 'popover' ) {

				self::$_trigger = '';

			}
			self::$_location = $this->value( 'tooltip.location' );



  		}


		$data->tooltips = htmlspecialchars( $data->tooltips );

		if ( !empty($data->title) ) $data->title = htmlspecialchars( $data->title );





  		$html = '<label class="hasTooltip';	
  		if ( !empty($data->class) ) $html .= ' ' . $data->class;

  		$html .= '"';

  		$html .= ' data-toggle="' . self::$_method . '"';	
  		if ( !empty(self::$_placement) ) $html .= ' data-placement="' . self::$_placement . '"';

  		 if ( !empty(self::$_html) ) {

  			$html .= ' data-html="true"';

  			


  		}
  		if ( !empty(self::$_trigger) ) $html .= ' data-trigger="' . self::$_trigger . '"';





  		if ( 'popover' == self::$_method ) {

  			
  			if (!empty($data->title) ) $html .= ' title="' . $data->title . '"';

  			$html .= ' content="' . $data->tooltips . '"';

  		} else {

  			
  			if ( !empty($data->id) ) $html .= ' for="' . $data->id . '"';

  			$html .= ' title="' . $data->tooltips . '"';

  		}


  		$html .= '>';

  		$html .= $data->text;

  		$html .= '</label>';



  		return $html;



  	}


}
