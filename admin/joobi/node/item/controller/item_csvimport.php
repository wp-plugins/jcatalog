<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_csvimport_controller extends WController {


function csvimport() {



	$productType = WGlobals::get( 'itemtype', '' );

	
	if ( empty($productType) ) {

		$myClassName = get_class( $this );

		$myClassNameA = explode( '_', $myClassName);

		$productType = strtolower( $myClassNameA[0] );

	}


		$hasUploadFile = false;

		$filesFancyuploadC = WClass::get( 'files.fancyupload' );

		$fancyFileUpload = $filesFancyuploadC->check();

		if ( $fancyFileUpload ) {

			$files = $this->getUploadedFiles();



			$map = 'x[import';



			if ( !empty($files['tmp_name'][0][0][$map]) ) {

				$fileLocation = $files['tmp_name'][0][0][$map];

				$csvFile = $files['name'][0][0][$map];

				$error = $files['error'][0][0][$map];

				$filetype = $files['type'][0][0][$map];

				$hasUploadFile = true;

			}


		} else {



			$trucs = WGlobals::get( 'trucs' , '', 'files');



			if ( !empty($trucs['tmp_name']['x']['import_file']) ) {

				$fileLocation = $trucs['tmp_name']['x']['import_file'];

				$csvFile = $trucs['name']['x']['import_file'];

				$error = $trucs['error']['x']['import_file'];

				$filetype = $trucs['type']['x']['import_file'];



				$hasUploadFile = true;

			}


		}


		$message = WMessage::get();



		if ( !$hasUploadFile ) {

			$message->userE('1369750880LIYV');

			return true;



		}




	$trucsLocation = WGlobals::get('trucs');










	$downloadFileLocation = $trucsLocation['x']['downloadfilepath'];

	$previewFileLocation = $trucsLocation['x']['previewfilepath'];

	$imageFileLocation = $trucsLocation['x']['imagefilepath'];

	$allowupdate = $trucsLocation['x']['allowupdate'];



	
	if ( !in_array( $filetype, array('text/csv', 'application/vnd.ms-excel', 'text/comma-separated-values') ) ) {

		$message->userE('1308652443MBNP');

		$this->setView( 'item_csv_import' );

		return true;

	}



	
	if ( $error > 0 ) {

		$message->userE('1417812852DFNC');

		$this->setView( 'theme_upload_file' );

		return true;

	}



	
	$fileClass = WGet::file();		
	$filecontent = $fileClass->read( $fileLocation );


	if ( empty($filecontent) ) {

		$message->userE('1308652443MBNQ');

		$this->setView( 'theme_upload_file');

		return true;

	}


	$params = new stdClass;

	$params->fileLocation = $fileLocation;

	$params->csvFile = $csvFile;

	$params->error = $error;

	$params->filetype = $filetype;

	$params->downloadFileLocation = $downloadFileLocation;

	$params->previewFileLocation = $previewFileLocation;

	$params->imageFileLocation = $imageFileLocation;

	$params->allowupdate = $allowupdate;

	if ( !empty($productType) ) $params->itemType = $productType;







	$importC = WClass::get( 'item.import' );

	$import = $importC->processItemImport( $params, $filecontent );



	if (!$import) {

		$message->userE('1308652443MBNR');

		$this->setView( 'item_csv_import');

	} else {

		$message->userS('1341596554FRRD');

	}


	
	$message->userB( 'finish' );



	return true;



}}