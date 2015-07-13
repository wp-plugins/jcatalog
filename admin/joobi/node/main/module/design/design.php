<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_CoreDesign_module extends WModule {





	function create() {


				if ( !WUser::isRegistered() ) return '';









		$this->content = '<div class="btn-group-vertical">';

		if ( WRole::hasRole( 'manager' ) ) {
						$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT_MODULES' );
			$link = WPage::link( 'controller=main-module&task=directmodule&val=' . $directEdit );
			$text = Wtext::translate( 'Module Preferences' );
			$this->content .= $this->_createButton( $link, $text, 'success', 'fa-edit' );
		}

				$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' );
		$link = WPage::link( 'controller=main-module&task=directtranslate&val=' . $directEdit );
		$text = Wtext::translate( 'Direct Translate' );
		$this->content .= $this->_createButton( $link, $text, 'warning', 'fa-language' );


				$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT' );
		$link = WPage::link( 'controller=main-module&task=directedit&val=' . $directEdit );
		$text = Wtext::translate( 'Direct Edit' );
		$this->content .= $this->_createButton( $link, $text, 'danger', 'fa-edit' );


				$dbgqry = WPref::load( 'PLIBRARY_NODE_DBGERR' );			$link = WPage::link( 'controller=main-module&task=debugsite&val=' . $dbgqry );
		$text = Wtext::translate( 'Debug' );
		$this->content .= $this->_createButton( $link, $text, 'warning', 'fa-code' );

				$dbgqry = WPref::load( 'PLIBRARY_NODE_DBGQRY' );
		$link = WPage::link( 'controller=main-module&task=query&val=' . $dbgqry );
		$text = Wtext::translate( 'Show Query' );
		$this->content .= $this->_createButton( $link, $text, 'info', 'fa-eye' );


				$link = WPage::link( 'controller=main-module&task=cache' );
		$text = Wtext::translate( 'Clear Cache' );
		$this->content .= $this->_createButton( $link, $text, 'primary', 'fa-trash-o' );

		$this->content .= '</div>';

		return $this->content;


	}








	private function _createButton($link,$text,$color='primary',$icon='') {

		$objButtonO = WPage::newBluePrint( 'button' );
		$objButtonO->text = $text;
		$objButtonO->link = $link;
		$objButtonO->type = 'infoLink';
		$objButtonO->color = $color;
		$objButtonO->icon = $icon;
		$objButtonO->wrapperDiv = 'designButton';
		$html = WPage::renderBluePrint( 'button', $objButtonO );

		return $html;

	}

}