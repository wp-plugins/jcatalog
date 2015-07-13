<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class WRender_Prefcatalog_classObject {

	


	public $type = 'buttonAddToCart';

				public $version = 2;


}


class WRender_Prefcatalog_class extends Theme_Render_class {



















  	public function render($data) {

  		$html = '';
  		$objButtonO = WPage::newBluePrint( 'button' );
  		foreach( $data as $key => $value ) $objButtonO->$key = $value;

  		if ( empty($objButtonO->id) ) $objButtonO->id = $data->type;

  		switch( $data->type ) {

  			case 'buttonViewMap':					$objButtonO->type = 'infoLink';
				$objButtonO->icon = $this->value( 'catalog.viewmapicon' );					$objButtonO->size = $this->value( 'catalog.viewmapsize' );
				$objButtonO->color = $this->value( 'catalog.viewmapcolor' );					$html = WPage::renderBluePrint( 'button', $objButtonO );
  				break;

  			case 'buttonEditAddress':					$objButtonO->type = 'infoLink';
				$objButtonO->icon = $this->value( 'catalog.editaddressicon' );					$objButtonO->size = $this->value( 'catalog.editaddresssize' );
				$objButtonO->color = $this->value( 'catalog.editaddresscolor' );					$html = WPage::renderBluePrint( 'button', $objButtonO );
  				break;

  			case 'itemAddPhoto':					$objButtonO->type = 'button';
				if ( $this->value( 'toolbar.icon' ) ) $objButtonO->icon = 'fa-download';
				$objButtonO->size = $this->value( 'catalog.editaddresssize' );
				if ( $this->value( 'toolbar.color' ) ) {
					$objButtonO->color = 'info';
				} else {
					$objButtonO->color = 'default';
				}				$html = WPage::renderBluePrint( 'button', $objButtonO );
  				break;

  			case 'showAllLink':	  				$html = '<div class="showAll">' . $data->html . '</div>';
  				break;

  			default:
  				break;
  		}
  		return $html;

  	}
}