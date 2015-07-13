<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_cache_listing_view extends Output_Listings_class {

	function prepareQuery() {



		$fileClass = WGet::file();		
		$systemFolderC = WGet::folder();

		$folder = WApplication::cacheFolder();

		$files = $systemFolderC->folders( $folder, '', true, false );	


		$objData = array();					


		
		if ( !empty($files) ) {

			foreach($files as $one_file) {



				$objElement = new stdClass;

				$objElement->filename = $one_file;













				$objElement->filename2 = '<center>';

				$iconO = WPage::newBluePrint( 'icon' );
				$iconO->icon = 'delete';
				$iconO->text = WText::t('1206732372QTKL');
				$objElement->filename2 .= WPage::renderBluePrint( 'icon', $iconO );

				$objElement->filename2 .= ' <a href="'.WPage::routeURL('controller=main-cache&task=delete&folder=' . $one_file).'"> ';
				$objElement->filename2 .= WText::t('1206732372QTKL');

				$objElement->filename2 .=" </a>";
				$objElement->filename2 .="</center>";








				


												    






				$objData[]=$objElement;

			}


		}


		if ( !empty($objData) ) $this->addData( $objData );

		else {

			$message = WMessage::get();

			$message->userN('1260434893HJHQ');

		}


		return true;





	}}