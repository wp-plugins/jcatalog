<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_Apps_user_logs_view extends Output_Listings_class {

	
	function prepareQuery(){



		$fileClass=WGet::file();		
		$systemFolderC=WGet::folder();

		$folder=JOOBI_DS_USER.'logs'.DS;

		$files=$systemFolderC->files( $folder, '', false, false, array( 'index.html', '.htaccess'));                


		$objData=array();					


		
		if( !empty($files)){


			foreach($files as $one_file){

				$objElement=new stdClass;

				$objElement->filename=$one_file;



				$objElement->download='<center><a href="' . WPage::routeURL( 'controller=apps-logs&task=download&bfrhead=1&file='. $one_file ) . '"> ';

				$objElement->download .=WText::t('1206961905BHAV');
				$iconO=WPage::newBluePrint( 'icon' );
				$iconO->icon='down';
				$iconO->text=WText::t('1206961905BHAV');
				$objElement->download .=WPage::renderBluePrint( 'icon', $iconO );


				$objElement->download .=" </a></center>";



				$objElement->filename2='<center><a href="'.WPage::routeURL('controller=apps-logs&task=delete&file='.$one_file).'"> ';

				$objElement->filename2 .=WText::t('1206732372QTKL');


				$iconO=WPage::newBluePrint( 'icon' );
				$iconO->icon='delete';
				$iconO->text=WText::t('1206732372QTKL');
				$objElement->filename2 .=WPage::renderBluePrint( 'icon', $iconO );


				$objElement->filename2 .=" </a></center>";



				$objElement->filename='<a href="'.WPage::routeURL('controller=apps-logs&file='.$one_file.'&task=details&titleheader=' . $one_file ).'">';

				$objElement->filename .=$one_file;

				$objElement->filename .="</a>";



				
				$LastModified=filemtime($folder.$one_file);

				$objElement->modify=date("l dS \of F Y h:i:s A", $LastModified);    
												    
				$created=filectime($folder.$one_file);

				$objElement->created=date("d F Y h:i:s A", $created);



				$objElement->size=round(( $fileClass->size($folder.$one_file))/1024, 3 ) ;

				$objElement->size.=' KB';


				$objData[]=$objElement;

			}


		}


		if( !empty($objData)) $this->addData( $objData );

		else {

			$message=WMessage::get();

			$message->userN('1260434893HJHQ');

		}


		return true;



	}
}