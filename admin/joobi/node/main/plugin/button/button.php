<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Button_plugin extends WPlugin {

	public function onDisplay($name) {

		if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return '';

				if ( WRoles::isNotAdmin( 'manager' ) ) return '';


				$js = "function insertWidget(namekey){var tag='{widget:alias|'+namekey+'}';jInsertEditorText(tag,'".$name."');SqueezeBox.close();}";
		WPage::addJS( $js );


				$link = 'index.php?option=com_' . JOOBI_MAIN_APP . '&controller=main-widgets-tag&isPopUp=true&e_name=' . $name . URL_NO_FRAMEWORK;
		$link = str_replace( '&', '&amp;', $link );

		JHtml::_('behavior.modal');

		WText::load( 'main.node' );

		if ( JOOBI_FRAMEWORK == 'joomla16' ) {
						$button = new JObject;
			$button->set('modal', true );
			$button->set('link', $link );
			$button->set('text', WText::t('1206732392OZUO') );
			$button->set('name', 'readmore' );
			$button->set('options', "{handler:'iframe',size:{x:800,y:600}}");

		} else {

			$button = new JObject;
			$button->modal = true;
			$button->class = 'btn';
			$button->link = $link;
			$button->text = WText::t('1206732392OZUO');
			$button->name = 'save-new';
			$button->options = "{handler:'iframe',size: {x:800,y:600}}";

		}

		return $button;

	}
}