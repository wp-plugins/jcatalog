<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Wordpress_Menus_picklist extends WPicklist {
	function create() {



		$this->addElement( 0, '- ' . WText::t('1431736280LVYX') . ' -' );


		$wid = $this->getValue( 'wid' );


				$folder = WExtension::get( $wid, 'folder' );
		$yid = WView::get( $folder . '_main_fe', 'yid', null, null, false );



		$libraryViewM = WModel::get( 'library.viewmenus' );
		$libraryViewM->makeLJ( 'library.viewmenustrans', 'mid' );
		$libraryViewM->whereLanguage();
		$libraryViewM->whereE( 'yid', $yid );

		$libraryViewM->select( 'name', 1 );
		$libraryViewM->select( array( 'action', 'params' ) );

		$libraryViewM->whereE( 'publish', 1 );

		$libraryViewM->orderBy( 'name', 'ASC', 1 );

		$libraryViewM->setLimit( 100 );



		$menusA = $libraryViewM->load( 'ol' );

		if ( !empty($menusA) ) {



			foreach( $menusA as $menu )  {


								$tag = 'page_' . $folder . '__' . str_replace( array( 'controller=', '&task=', '&eid=', '&type=' ), array( 'ctrl_', '__task_', '__eid_', '__type_' ), $menu->action );
								$pos = strpos( $tag, '__eid_' );
				if ( $pos !== false ) {
					$tag = substr( $tag, 0, $pos + 6 ) . '1';
				}				$pos = strpos( $tag, '__type_' );
				if ( $pos !== false ) {
					$tag = substr( $tag, 0, $pos + 7 ) . '1';
				}
				$this->addElement( $tag, $menu->name );



			}


		}




		return true;



	}}