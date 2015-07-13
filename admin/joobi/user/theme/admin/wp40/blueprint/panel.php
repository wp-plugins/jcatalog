<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');





























class WRender_Panel_classObject {



	public $id = 'panelID';	
	public $color = '';

	public $faicon = '';

	public $header = '';

	public $body = '';

	public $footer = '';

	public $headerRightA = array();	


	

	public $style = '';



}




class WRender_Panel_class extends Theme_Render_class {



	private static $_paneIcon = null;

	private static $_paneColor = null;

	private static $_isRTL = null;





























  	public function render($data) {



  		if ( !isset( self::$_paneIcon ) ) {

  			self::$_paneIcon = $this->value( 'pane.icon' );

  			self::$_paneColor = $this->value( 'pane.color' );

  			self::$_isRTL = WPage::isRTL();

  		}




  		$html = '<div id="' . $data->id . '" class="panel';

  		if ( self::$_paneIcon && !empty($data->color) ) $html .= ' panel-' . $data->color;

  		else $html .= ' panel-default';

  		$html .= '">';



  		if ( !empty($data->header) || !empty( $data->headerRightA ) || !empty( $data->headerCenterA ) ) {



	  		$html .= '<div class="panel-heading">';

	  		if ( empty( $data->headerRightA ) ) {

		  		if ( self::$_paneIcon && !empty($data->faicon) ) $html .= '<i class="fa ' . $data->faicon . '"></i>';

		  		$html .= '<h4 class="panel-title">' . $data->header . '</h4>';	

	  		} else {

	  			if ( !self::$_isRTL ) {

	  				$left = 'left';

	  				$right = 'right';

	  			} else {

	  				$left = 'right';

	  				$right = 'left';

	  			}
	  			$html .= '<div class="pull-' . $left . '">';

		  		if ( self::$_paneIcon && !empty($data->faicon) ) $html .= '<i class="fa ' . $data->faicon . '"></i>';

		  		$html .= '<h4 class="panel-title">' . $data->header . '</h4>';	

		  		$html .= '</div>';

	  			$html .= '<div class="pull-' . $right . '">';

	  			$html .= implode( ' ', $data->headerRightA );	
		  		$html .= '</div>';



	  		}
	  		$html .= '</div>';

  		}


  		$html .= '<div class="panel-body">';

  		$html .= $data->body;

  		$html .= '</div>';



  		
  		if ( !empty($data->footer) ) {

	  		$html .= '<div class="panel-footer">';

	  		$html .= $data->footer;

	  		$html .= '</div>';

  		}


  		$html .= '</div>';



















		return $html;



  	}


}