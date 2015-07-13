<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

















class WRender_Initialize_class extends Theme_Render_class {















  	public function render($data=null) {






  		
  		
		$option = WGlobals::getApp();

		$exist = WExtension::exist( $option . '.application' );



		if ( ! $exist && ! in_array( $option, array( 'jvendor' ) ) ) return true;



  		
  		if ( !empty($data) ) {

  			if ( $data == 'brand' ) {

  				WPage::addCSSFile( 'fonts/app/css/app.css' );

  				return '<i class="fa app-joobi-logo"></i>';

  			} elseif ( $data == 'font-awesome' ) return $this->_addFontAwesome( false );

  			elseif ( $data == 'font-awesome-animation' ) return $this->_addFontAwesome( true );

  			else return $this->value( $data );

  		}


		if ( !defined('JOOBI_URL_THEME_JOOBI') ) WView::definePath();



		





		
		WPage::addJSFile( 'js/bootstrap.js' );

		WPage::addJSFile( 'js/menu.js' );





		$this->_addFontAwesome();





		
		$skin = $this->value( 'skin' );

		$noBootstrap = $this->value( 'nobootstrap' );



		if ( empty($noBootstrap) ) {

			WPage::addCSSFile( 'css/bootstrap.css' );



			if ( !empty( $skin ) ) {

				$explodeSkinA = explode( '.', $skin );

				WPage::addCSSFile( $explodeSkinA[0] . '/css/' . $explodeSkinA[1] . '.css', 'skin' );

			}
		}




		WPage::addCSSFile( 'fonts/app/css/app.css' );







  		return true;



  	}












  	private function _addFontAwesome($animation=false) {

  		static $ft = true;

  		static $ftanm = true;



  		$font_awesome = $this->value( 'font.awesome' );



		if ( ('auto' == $font_awesome || 1 == $font_awesome) && $ft ) {

			
			WPage::addCSSFile( 'fonts/font-awesome/css/font-awesome.css', 'theme', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );

			$ft = false;

		}


		if ( $animation && $ftanm ) {

			WPage::addCSSFile( 'fonts/font-awesome/css/font-awesome-animation.css', 'theme' );

			$ftanm = false;

		}


  	}

}