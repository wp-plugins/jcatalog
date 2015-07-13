<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Address_Header_class extends WClasses {







	function display($controller,$actual='none',$end='') {
		$title = '<H2>'.WText::t('1206961913QQBR').'</h2>';

				$option = WGlobals::getApp();
		if ( !empty($option) ) $option = substr( $option, 4 );

				if ( empty($option) ) $option = 'jstore';

		if ($actual == 'none'){
			$name = $this->getName($controller, $actual);
			$html = $title.'<a href="'.WPage::routeURL('controller='.$controller, '', 'default', '', true, $option).'">'.$name.'</a>&nbsp;';
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'fleche';
			$iconO->text = 'Arrow';
			$html = WPage::renderBluePrint( 'icon', $iconO );

			return $html;
		} else {
			$name = $this->getName($controller);
			$name2 = $this->getName($controller, $actual);
			$trail = '<a href="'.WPage::routeURL('controller='.$controller, '', 'default', '', true, $option).'">'.$name.'</a>&nbsp;';
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'fleche';
			$iconO->text = 'Arrow';
			$trail = WPage::renderBluePrint( 'icon', $iconO );

			$trail .= '&nbsp;<a href="#">'.$name2.' '.$end.'</a>';
			return $title . $trail;
		}
	}






	function getName($controller,$task='none'){
		if (isset($controller)){
			$contr = WModel::get('controller','object');
			$contr->whereE('app',$controller);
			$contr->whereE('publish',1);
			$contr->whereE('admin',0);
			if ($task != 'none'){
				$contr->whereE('task',$task);
			} else {
				$contr->whereE('premium',1);
			}
			$jos = $contr->load('o','yid');
			if (isset($jos)){
				$view = WModel::get('viewtrans');
				$view->whereE('yid',$jos->yid);
				$view->whereLanguage( 1 );
				$title = $view->load('o','name');
				if (isset($title)){
					return $title->name;
				}
			}		}	}}