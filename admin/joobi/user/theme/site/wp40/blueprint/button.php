<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class WRender_Button_classObject {

	









	public $style = 'button';

	public $text = '';	
	public $useTitle = true;		public $title = '';	
	public $link = '#';		public $linkOnClick = '';		public $float = '';		public $size = '';	
	public $color = '';		public $colorDefault = 'default';	
	public $iconShow = true;
	public $icon = '';		public $iconPosition = null; 	public $iconSize = ''; 	public $coloredIcon = false;	
	public $iconLocation = '';		public $tooltip = '';	
	
	public $popUpIs = false;
	public $popUpWidth = '80%';
	public $popUpHeight = '80%';

	public $target = '';			public $extraTags = null; 		public $extraClasses = '';		public $extraStyle = ''; 	
	
	public $buttonType = 'button';

	public $loading = false;	
}


class WRender_Button_class extends Theme_Render_class {

	private static $btnColor = null;
	private static $btnDefaultColor = null;
	private static $btnIcon = null;
	private static $btnIconPosition = null;





























  	public function render($data) {

  		if ( empty($data->type) ) $data->type = 'infoLink';
  		if ( 'standard' == $data->type ) {
			return $data->text;
		}
				if ( !isset( self::$btnColor ) ) {
			self::$btnColor = $this->value( 'button.color' );
			self::$btnDefaultColor = $this->value( 'button.defaultcolor' );
			if ( empty(self::$btnDefaultColor) ) self::$btnDefaultColor = 'default';
			self::$btnIcon = $this->value( 'button.icon' );
			self::$btnIconPosition = $this->value( 'button.iconposition' );
		}


				if ( empty(self::$btnColor) ) $data->color = '';

		if ( !isset( $data->colorDefault ) ) $data->colorDefault = self::$btnDefaultColor;
		if ( !isset( $data->iconShow ) ) $data->iconShow = self::$btnIcon;
		if ( !isset( $data->iconPosition ) ) $data->iconPosition = self::$btnIconPosition;

		if ( empty($data->link) ) $data->type = 'button';

		if ( 'button' == $data->type ) {
			if ( empty( $data->buttonType ) ) $data->buttonType = 'button';
			$html = '<button type="' . $data->buttonType . '"';
		} else {
						$html = '<a href="' . $data->link . '"';
			if ( !empty($data->target) ) $html .= ' target="' . $data->target . '"';
		}
		if ( !empty($data->popUpIs) && !empty($data->link) ) {
			$data->extraTags = WPage::createPopUpRelTag( $data->popUpWidth, $data->popUpHeight );
		}

						if ( !empty( $data->color ) && empty($data->coloredIcon) ) {
				$html .= ' class="btn btn-' . $data->color;
			} else {
				$html .= ' class="btn btn-' . $data->colorDefault;
			}
			if ( !empty($data->extraClasses) ) {
				$html .= ' ' . $data->extraClasses;
			}
						if ( !empty( $data->size ) ) {
				switch( $data->size ) {
					case 'large':
					case 'xlarge':
					case 'xxlarge':						case '2xlarge':
					case '3xlarge':
					case '4xlarge':
						$html .= ' btn-lg';
						break;
					case 'small':
						$html .= ' btn-sm';
						break;
					case 'xsmall':
						$html .= ' btn-xs';
						break;
					default:
						break;
				}
			}
			$html .= '"';	
			if ( !empty($data->linkOnClick) ) {
				$html .= ' onclick="' . $data->linkOnClick . '"';
			}
			if ( !empty($data->extraStyle) ) {
				$html .= ' style="' . $data->extraStyle . '"';
			}
			if ( !empty($data->extraTags) ) {
				$html .= $data->extraTags;
			}
						if ( !empty($data->loading) ) {
				$loagingMessage = WText::t('1395500509GSSS');
				$html .= ' data-loading-text="' . $loagingMessage . '..."';
			}
			if ( !empty($data->useTitle) && empty($data->title) ) {
												$data->title = WGlobals::filter( $data->text, 'phrase' );
			}
			if ( !empty($data->title) ) $html .= ' title="' . $data->title . '"';
			if ( !empty($data->id) ) $html .= ' id="' . $data->id . '"';

			$html .= '>';

			$iconHTML = '';
			if ( !empty($data->icon) ) {
				$iconHTML = '<i class="fa ' . $data->icon;					if ( !empty($data->iconSize) ) {
		 			switch( $data->iconSize ) {
		 				case 'medium':
		  					break;
		  				case 'large':
		  					$iconHTML .= ' fa-lg';
		  					break;
		  				case 'xlarge':
		  					$iconHTML .= ' fa-2x';
		  					break;
		  				case 'xxlarge':
		  				case '2xlarge':
		  					$iconHTML .= ' fa-3x';
		  					break;
		  				case '3xlarge':
		  					$iconHTML .= ' fa-4x';
		  					break;
		  				case '4xlarge':
		  					$iconHTML .= ' fa-5x';
		  					break;
		  				default:
		  					$iconHTML .= ' ' . $data->iconSize;
		  					break;
		  			}				}
				if ( !empty($data->coloredIcon) ) {
					if ( empty($data->color) ) $data->color = 'primary';
					$iconHTML .= ' text-' . $data->color;
				}				$iconHTML .= '"></i>';

			}
			if ( !empty($data->iconPosition) && 'right' == $data->iconPosition ) {
				$html .= $data->text;
				$html .= $iconHTML;
			} else {
				$html .= $iconHTML;
				$html .= $data->text;
			}

		if ( 'button' == $data->type ) {
			$html .= '</button>';
		} else {
			$html .= '</a>';
		}
		return $html;

  	}
}