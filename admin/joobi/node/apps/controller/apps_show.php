<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Apps_show_controller extends WController {










	function show(){

		$all=WGlobals::get( 'update', false );
		if( $all=='all'){
			WGlobals::setSession( 'installProcess', 'what', 'multiple' );
		}else{
			WGlobals::setSession( 'installProcess', 'what', 'single' );
		}


				
		$autotrigger=WGlobals::get( 'autotrigger', 0 );



				$cache=WCache::get();
		$cache->resetCache();

		$systemFolderC=WGet::folder();
		$FOLDER=JOOBI_DS_USER . 'installfiles';
		if( $systemFolderC->exist( $FOLDER ) && ! $systemFolderC->delete( $FOLDER )){
			$mess=WMessage::get();
			$mess->userN('1249562683MMMY',array('$FOLDER'=>$FOLDER));
			return true;
		}


		
		if( $autotrigger){

			WPage::addJSScript( WView::addJSAction( 'instup', 'wfzy' ));

			WPage::addJSScript('joobi.disableAll();');

			$hideJoobiMenu='joobimenu=document.getElementById("toolbar-box");';

			$hideJoobiMenu .="if(joobimenu){joobimenu.style.display='none';}";

			WPage::addJSScript( $hideJoobiMenu );

		}


		
		WPage::addJSLibrary( 'rootscript' );
		WPage::addJSFile( 'js/install.1.1.js' );




		if( isset( $_SESSION['joobi']['installwithminilib'] )){

			unset( $_SESSION['joobi']['installwithminilib'] );

		}


		return true;


	}



}