<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Item_Import_class extends WClasses {














	function processItemImport($params,$filecontent='',$vendid=0) {

		$itemType = ( !empty($params->itemType) ? $params->itemType : '' );

		$fileLocation = ( !empty($params->fileLocation) ? $params->fileLocation : '' );
		$csvFile = ( !empty($params->csvFile) ? $params->csvFile : '' );
		$error = ( !empty($params->error) ? $params->error : '' );
		$filetype = ( !empty($params->filetype) ? $params->filetype : '' );


		$downloadFileLocation = ( !empty($params->downloadFileLocation) ? $params->downloadFileLocation : '' );
		$previewFileLocation = ( !empty($params->previewFileLocation) ? $params->previewFileLocation : '' );
		$imageFileLocation = ( !empty($params->imageFileLocation) ? $params->imageFileLocation : '' );


				if ( strpos( $imageFileLocation, JOOBI_FOLDER  . DS . 'user' . DS . 'media'  ) !== false ) {
			$message = WMessage::get();
			$message->userE('1357833462DNRP');
			return false;
		}		if ( strpos( $previewFileLocation, JOOBI_FOLDER  . DS . 'user' . DS . 'media'  ) !== false ) {
			$message = WMessage::get();
			$message->userE('1357833462DNRQ');
			return false;
		}		if ( strpos( $downloadFileLocation, JOOBI_FOLDER  . DS . 'user' . DS . 'media'  ) !== false ) {
			$message = WMessage::get();
			$message->userE('1357833462DNRR');
			return false;
		}

		if ( empty($filecontent) ) {
						$fileClass = WGet::file();					$filecontent = $fileClass->read( $fileLocation );
		}
		
				$filecontent = str_replace(array("\r\n","\r"),"\n",$filecontent);
		$allLinesA = explode( "\n", $filecontent );

				$properties = explode( '|', $allLinesA[0] );

				$objectPossibleHeadings = array( 'namekey', 'name', 'introduction', 'description', 'alias', 'category', 'currency', 'curid', 'comment', 'type', 'priceType', 'price',
				'previewFile', 'itemFile', 'imageFile', 'publish', 'featured', 'created', 'modified', 'biddingstart', 'biddingend', 'startingbid', 'reservebid', 'private', 'auto', 'credits', 'period', 'value',
		 'credittype', 'recurring', 'createlist', 'stock', 'weight', 'electronic', 'availablestart', 'availableend', 'publishstart', 'publishend', 'itemType', 'vendor' );
		$objectAcceptedCol = new stdClass;
		$objectNOTAcceptedCol = new stdClass;
				$message = WMessage::get();

		foreach( $properties as $key => $HEADING ) {
						$HEADING = str_replace( '"', '', $HEADING );
			$HEADING = trim( $HEADING );
			$HEADING = preg_replace("/[^A-Za-z]/", '', $HEADING); 
						if ( !in_array( $HEADING, $objectPossibleHeadings ) ) {
				if ( !empty($HEADING) ) $message->userW('1337642920KLLX',array('$HEADING'=>$HEADING));
				continue;
			}
			$objectAcceptedCol->$HEADING = $key;

		}

		$objectData = new stdClass;
		foreach( $allLinesA as $key => $line ) {
			if ( $key == 0 ) continue; 
						
			$data = explode( '|', $line );
			foreach( $data as $datakey => $oneData ) {
				$oneData = trim( $oneData, '"' );
				$objectData->$datakey = $oneData;
			}
			$product = new stdClass;
			foreach( $objectAcceptedCol as $property => $value ) {

				if ($property == 'type') {
					$product->type = stripslashes($objectData->$value);
					continue;
				}
				if ($property == 'name' && empty($product->namekey) ) {
					$product->namekey = 'csv_import_' . str_replace(' ', '', stripslashes($objectData->$value));
				}
				$product->$property = stripslashes($objectData->$value);

			}
						$product->downloadFileLocation = $downloadFileLocation;
			$product->previewFileLocation = $previewFileLocation;
			$product->imageFileLocation = $imageFileLocation;


			if ( empty($itemType) ) $itemType = 'item';
			if ( empty($product->type) ) $product->type = $itemType;

						if ( $product->type == 'auction' ){
				if (empty($product->biddingstart)){
					$product->biddingstart = time() ;
				} else {
					if ( is_int($product->biddingstart) ) $product->biddingstart = $product->biddingstart;
					else $product->biddingstart = WApplication::stringToTime($product->biddingstart) ;
				}
				if (empty($product->biddingend)){
					$product->biddingend = time() + 200000 ;
				} else {
					if ( is_int($product->biddingend) ) $product->biddingend = $product->biddingend;
					else $product->biddingend = WApplication::stringToTime($product->biddingend) ;
				}
				if (empty($product->availablestart)){
					$product->availablestart = time() ;
				} else {
					if ( is_int($product->availablestart) ) $product->availablestart = $product->availablestart;
					else $product->availablestart = WApplication::stringToTime($product->availablestart) ;
				}
				if (empty($product->availableend)){
					$product->availableend = time() + 200000 ;
				} else {
					if ( is_int($product->availableend) ) $product->availableend = $product->availableend;
					else $product->availableend = WApplication::stringToTime($product->availableend) ;
				}
				if (empty($product->publishstart)){
					$product->publishstart = time() ;
				} else {
					if ( is_int($product->publishstart) ) $product->publishstart = $product->publishstart;
					else $product->publishstart = WApplication::stringToTime($product->publishstart) ;
				}
				if (empty($product->publishend)){
					$product->publishend = time() + 200000 ;
				} else {
					if ( is_int($product->publishend) ) $product->publishend = $product->publishend;
					else $product->publishend = WApplication::stringToTime($product->publishend) ;
				}			}
			if ( empty($product->type) ) $product->type = $itemType;


						static $itemInsertC = null;
			if ( !isset($itemInsertC) ) $itemInsertC = WClass::get( 'item.insert' );
			$import = $itemInsertC->insertItem( $product, false, 'csv', $product->type, $params->allowupdate, 1, $vendid );

												if ( ($import != 0) && !empty( $product->category ) ) {
							$insertCatProd = $itemInsertC->insertCategoryItems( $product->category, $product->namekey );
			}
		}
		return true;
	}

}