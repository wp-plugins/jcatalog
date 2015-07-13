<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_model_generateview_controller extends WController {










	function generateview() {



WMessage::log( '1', 'jdesign-generateview' );











		$sid = WController::getFormValue( 'sid' );

		$wid = WController::getFormValue( 'wid' );

		$controller = WController::getFormValue( 'controller' );

		$rolid = WController::getFormValue( 'rolid' );

		$view = WController::getFormValue( 'view' );





WMessage::log( '2', 'jdesign-generateview' );


WMessage::log( '2.1', 'jdesign-generateview' );

WMessage::log( ' sid: '.$sid.' wid: '.$wid.' controller: '.$controller, 'jdesign-generateview' );

WMessage::log( '2.2', 'jdesign-generateview' );

		if ( empty($sid) || empty($wid) || empty($controller) ) return false;

		preg_match_all('/[a-zA-Z0-9-]+/', $controller, $result);

		$string = implode('', $result[0]);



WMessage::log( '3', 'jdesign-generateview' );



		if ($string !== $controller) {

			$message->userE('1309938333EEVB');

			WPages::redirect('controller=model&task=view&eid='.WGlobals::getEID());

		}


WMessage::log( '4', 'jdesign-generateview' );

		$modelView = WObject::get( 'model.view' );

		$modelO = new stdClass;

		$modelO->sid = $sid;

		$modelO->wid = $wid;

		$modelO->controller = $controller;

		$modelO->access = $access;

		$modelO->view = $view;

		$modelView->generate( $modelO );

WMessage::log( '5', 'jdesign-generateview' );

		
		$this->showM( true, 'create', 1, $sid );

WMessage::log( '6', 'jdesign-generateview' );

		if ( $view=='show' || $view=='form' ) {

			$shownamekey = WGlobals::get('shownamekey');

			$link = str_replace(array('$shownamekey','$controller'), array($shownamekey,$controller),WText::t('1309938333EEVC'));

			$link .= '<a href="' . WPage::routeURL('controller='.$controller) . '">' . WText::t('1309938333EEVD') . '</a>';

		} else $link = '<a href="' . WPage::routeURL('controller='.$controller) . '">' . WText::t('1309938333EEVE') . '</a>';

WMessage::log( '7', 'jdesign-generateview' );

$message->userS($link);

WMessage::log( '8', 'jdesign-generateview' );



		return true;



	}}