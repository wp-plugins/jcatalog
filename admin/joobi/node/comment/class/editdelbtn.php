<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_Editdelbtn_class extends WClasses {























function showdeledit($commentO) {



	
	static $once = false;

	static $roleC =	null;

	static $status = null;
	$loading = 1;

	$loguid = WUser::get('uid');					
	$content = '';

		if ($commentO->js == 'confirmation'){

		if (!$once) {

		$string="function confirmation(tkid,url,path) {
				   	var answer = confirm('Are you sure you want to delete?');

					if (answer) {

						window.location = url;

					}

				}" ;
		WPage::addJS( $string, 'text/javascript', true );

		$once=true;

		}		$loading = 0;

	}

	


	$roleC = WRole::get();

	if ( !isset($status) ) $status = WRole::hasRole( 'admin' );				

	$path= JOOBI_URL_INC . 'lib/jquery/';


	
	if ( $status || $loguid == $commentO->authoruid) {

		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'delete';
		$iconO->text = WText::t('1206732372QTKL');


		$delete = '<span id="cmtbutton-del'.$commentO->tkid.'"><a style="cursor:pointer" onclick="return '.$commentO->js.'('.$commentO->tkid.',\''.$commentO->delLink.'\',\''.$path.'\');">' . WPage::renderBluePrint( 'icon', $iconO ) . '</span>';

		if ($loading) {
			$iconO = WPage::newBluePrint( 'icon' );
			$iconO->icon = 'loading';
			$iconO->text = WText::t('1395500509GSSS');

			$delete .= '<span id="postloading'.$commentO->tkid.'" class="cmt-loading" style="display: none;">' . WPage::renderBluePrint( 'icon', $iconO ) . '</span>';
		}
		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'edit';
		$iconO->text = WText::t('1206732361LXFE');


		$edit = WPage::createPopUpLink( $commentO->editlink, WPage::renderBluePrint( 'icon', $iconO ), 550, 300, '', 'j'.$commentO->tkid );


		if ($commentO->privates){
			$toolbar = JOOBI_URL_JOOBI_IMAGES.'toolbar/16/';
			$privateIcon = '<img src="'.$toolbar.'private.gif"/>';

			$content = $privateIcon.'&nbsp;&nbsp;';
		}

		$content .= $delete.'&nbsp;&nbsp;'.$edit;



	}


	return $content;

}
}