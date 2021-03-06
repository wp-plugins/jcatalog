<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');








class WRender_Others_class extends Theme_Render_class {








  	public function render($data) {

  		if ( empty($data) || empty($data->type) ) {
  			  			$this->codeE( 'WRender_Others_class data incomplete!' );
  			return false;
  		}
  		switch( $data->type ) {
  			case 'rss':
				$html = '<a href="' . $data->link . '" target="_blank">';
				$html .= '<i class="fa fa-rss fa-2x"></i>';
				$html .= '</a>';
  			break;

  			case 'editView':
  				$html = $this->_editView( $data );
  				break;

  			case 'translationView':
  				$html = $this->_translationView( $data );
  				break;

  			case 'editModule':
  				$html = $this->_editModule( $data );
  				break;

  			default:
  				$html = '';
  				break;
  		}
		return $html;

  	}






	private function _editView($data) {


		$image = '<i class="fa fa-edit fa-lg text-danger"></i>';	
		if ( empty($data->studio) ) $link = WPage::linkPopUp( 'controller=main-'. $data->controller . '&task=edit&eid='.$data->eid );
		else $link = WPage::linkPopUp( 'controller=view-'. $data->controller . 's&task=edit&eid='.$data->eid );

		$linkHTML = WPage::createPopUpLink( $link, $image, '80%', '90%', '', '', $data->text );

		$content = '';
		if ( !empty($data->look) ) $data->controller = $data->look;
		switch( $data->controller ) {
			case 'form':
				$content = $linkHTML;
				break;
			case 'form-layout':
				$content = '<div class="editElement editFormLayout">' . $linkHTML . '</div>';
				break;
			case 'listing':
				$content = '<div class="editElement editListing">' . $linkHTML . '</div>';
				break;
			case 'menu':
				$content = '<div class="editElement editMenu">' . $linkHTML . '</div>';
				break;
			case 'view':
				$content = '<div class="editElement editView">' . $linkHTML . '</div>';
				break;
			default:
				$content = '<div class="editElement">' . $linkHTML . '</div>';
				break;
		}		return $content;

	}






	private function _translationView($data) {

		$image = '<i class="fa fa-language fa-lg text-info"></i>';	
		$lgid = WUser::get( 'lgid' );
		$link = WPage::linkPopUp( 'controller=main-translate&task=edit&type='. $data->controller .'&eid='.$data->eid . '&text=' . $data->text . '&lgid=' . $lgid, false );
		$linkHTML = WPage::createPopUpLink( $link, $image, '80%', 200, 'translation', '', $data->text );

		$content = '';
		switch( $data->controller ) {
			case 'form':
				$content = $linkHTML;
				break;
			case 'form-layout':
				$content = '<div class="editElement translateFormLayout">' . $linkHTML . '</div>';
				break;
			case 'listing':
				$content = '<div class="editElement translateListing">' . $linkHTML . '</div>';
				break;
			case 'menu':
				$content = '<div class="editElement translateMenu">' . $linkHTML . '</div>';
				break;
			case 'view':
				$content = '<div class="editElement translateView">' . $linkHTML . '</div>';
				break;
			default:
				$content = '<div class="editElement">' . $linkHTML . '</div>';
				break;
		}
		return $content;

	}







	private function _editModule($data) {

		
		$image = '<i class="fa fa-edit fa-2x text-success"></i>';	
				$link = WPage::linkPopUp( 'controller=main-widgets-preference&task=edit&id=' . $data->moduleID . '&goty=com_modules' );

		$linkHTML = WPage::createPopUpLink( $link, $image, '80%', '80%', '', '', WText::t('1381500293NYJF') );

		$content = '<div class="editElement translateView">' . $linkHTML . '</div>';

		return $content;

	}

}