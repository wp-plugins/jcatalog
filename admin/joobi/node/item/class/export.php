<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Item_Export_class extends WClasses {









	public function exportItems($itemType,$columnsA,$lgid=1,$vendid=0) {


		$allItemsA = $this->getItems( $columnsA , $lgid, '', $itemType, $vendid );


		if ( !empty($allItemsA) ) {

			$processedLines = $this->processItemsForExport( $allItemsA, $columnsA, $itemType );

			return $processedLines;
		} else {

			return false;

		}
	}







	function processItemsForExport($items,$columns,$itemType='item') {

		$values = array();
		$lines = array();
		$foldername = 'exported_' . $itemType . '_' . date("Y.d.m_H.i.s");
		$counter = 1;
		if ( empty($items) ) return '';

		foreach( $items as $key => $item ) {
						if (isset($item->imagename) && isset($item->imagetype) ) $item->imageFile = $item->imagename.'.'.$item->imagetype;
						if (isset($item->previewid_name) && isset($item->previewid_type)) $item->previewFile = $item->previewid_name.'.'.$item->previewid_type;
						if (isset($item->productid_name) && isset($item->productid_type)) $item->itemFile = $item->productid_name.'.'.$item->productid_type;

			if (in_array('imageFile', $columns)){
				if (empty($item->imagename) && empty($item->imagetype)) $item->imageFile = '';
			}
			if (in_array('previewFile', $columns)){
				if (empty($item->previewid_name) && empty($item->previewid_type)) $item->previewFile = '';
			}
			if (in_array('itemFile', $columns)){
				if (empty($item->productid_name) && empty($item->productid_type)) $item->itemFile = '';
			}

						if (isset($item->imagename) OR empty($item->imagename)) unset($item->imagename);
			if (isset($item->imagetype) OR empty($item->imagetype)) unset($item->imagetype);
			if (isset($item->filid) OR empty($item->filid)) unset($item->filid);

						if (isset($item->previewid_name) OR empty($item->previewid_name)) unset($item->previewid_name);
			if (isset($item->previewid_type) OR empty($item->previewid_type)) unset($item->previewid_type);
			if (isset($item->previewid) OR empty($item->previewid)) unset($item->previewid);

						if (isset($item->productid_name) OR empty($item->productid_name)) unset($item->productid_name);
			if (isset($item->productid_type) OR empty($item->productid_type)) unset($item->productid_type);
			if (isset($item->productid) OR empty($item->productid)) unset($item->productid);

			foreach($item as $property => $value){
				if ($key == 0){
					$headings[$property] = $property;
				}
				if (in_array($property, array('created', 'modified', 'publishstart', 'publishend'))){
					if ($value == 0) $value = $value;
					else $value = date('Y-m-d', $value);
				}
				$value = str_replace(array("\r\n","\r","\n","\n\r"),"<br />",$value);

								if (in_array($property, array('description', 'introduction'))){
					$tagC = WClass::get('output.process');
					$tagC->replaceTags( $value );
										$value = str_replace("|",",,", $value);
				}
				$values[$counter][$property] = $value;
			}			if ($key == 0){
				$lines[0] = implode('|',$headings); 			}				$lines[$counter] = implode('|', $values[$counter]);			
			$counter = $counter + 1;
		}
		return $lines;

	}





	function downloadFile($data,$filename){
		if (empty( $data ) ) return false;

		$browser = WPage::browser( 'namekey' );

 		if ( ! ini_get('safe_mode') ) { 			@set_time_limit( 0 );
        }

		$mime_type = (strtolower($browser) == strtolower('IE') || strtolower($browser) == strtolower('Opera')) ? 'application/octetstream' : 'application/octet-stream';
		if ( empty($filename) ) $filename = "products_" . date("Y.d.m_H.i.s");

		ob_end_clean();
		ob_start();

		$export = '';
		foreach( $data as $oneLineData ) {
			$export .= $oneLineData;
			$export .= "\r\n" ;
		}
		header('Content-Type: ' . $mime_type );
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT' );

		if (strtoupper($browser) == 'IE' ) {
			header( 'Content-Disposition: inline; filename="' . $filename . '.csv"' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header( 'Pragma: public');
		} else {
			header( 'Content-Disposition: attachment; filename="' . $filename . '.csv"' );
			header( 'Pragma: no-cache');
		}
		print $export;
		exit();

		return true;

	}





	function copydownloadImageFile($products,$foldername){
		if (empty($products)) return true;
		if (empty($foldername)) $foldername = "export_products_" .  date("Y.d.m_H.i.s");

		$systemFolderC = WGet::folder();				$fileClass = WGet::file();		

		foreach($products as $product){
			foreach($product as $key=>$value){
				$fileCopyDest = '';
				$fileSource = '';

				if ( $key == 'imageFile' ) {
					$fileCopyDest = JOOBI_DS_EXPORT . $foldername.DS. 'images'.DS.$product->imageFile; 					$fileSource = JOOBI_DS_MEDIA.'images' . DS . 'products'.DS.$product->imageFile;
				}
				if ( $key == 'itemFile' ) {
					$fileCopyDest = JOOBI_DS_EXPORT . $foldername.DS. 'files'.DS.$product->itemFile; 					$fileSource = JOOBI_DS_USER.'safe' . DS . 'products'.DS.$product->itemFile;
				}
				if ( $key == 'previewFile' ) {
					$fileCopyDest = JOOBI_DS_EXPORT . $foldername.DS. 'preview'.DS.$product->previewFile; 					$fileSource = JOOBI_DS_MEDIA.'products' . DS . 'preview'.DS.$product->previewFile;
				}
								if ( !empty($fileSource) ) {
						if ( $fileClass->exist($fileSource) ) {
							$fileClass->copy( $fileSource, $fileCopyDest );
						}				}
			}


		}

		return true;
	}










	function getItems($columns,$lgid=1,$filter='',$producttype='item',$vendid=0) {

		if ( empty($columns) ) $columns = array( 'pid', 'name', 'introduction', 'description' );

		$itemC = WClass::get('item.insert');

		if ( $producttype == 'catalog' ) $producttype = 'item';

		$prodTypid = $itemC->getProdTypeId( $producttype, false );

		$productM = WModel::get( $producttype );
		$categoryName = false;
		$productM->select( 'name', 1 );

		$specialColumnsA = array( 'name', 'introduction', 'description', 'currency', 'itemType', 'priceType', 'category', 'categoryName', 'imageFile', 'previewFile', 'itemFile' );
		foreach( $columns as $oneColumn ) {
			if ( in_array($oneColumn, $specialColumnsA ) ) {				if ( $oneColumn == 'name' ) $productM->select( 'name', 1 );
				if ( $oneColumn == 'introduction' ) $productM->select( 'introduction', 1 );
				if ( $oneColumn == 'description' ) $productM->select( 'description', 1 );
				if ( $oneColumn == 'currency' ) $productM->select('code', 4, 'currency');

				if ( $oneColumn == 'itemType' ) $productM->select('namekey', 2, 'itemType');
				if ( $oneColumn == 'priceType' ) $productM->select('namekey', 3, 'priceType');
				if ( $oneColumn == 'category' ) $productM->select('namekey', 6, 'category');
				if ( $oneColumn == 'categoryName' ) {
					$productM->select( 'name', 9, 'categoryName' );
					$categoryName = true;
				}
				if ( $oneColumn == 'imageFile' ) {
					$productM->select('filid', 7, 'filid');
					$productM->select('name', 8, 'imagename');
					$productM->select('type', 8, 'imagetype');
				}				if ( $oneColumn == 'previewFile' ){
					$productM->select('previewid');
				}				if ( $oneColumn == 'itemFile' ){
					$productM->select('filid',0, 'productid');
				}
			} else { 				$productM->select( $oneColumn );
			}

		}
		$productM->makeLJ('producttrans','pid','pid', 0, 1);
		$productM->makeLJ('product.type','prodtypid','prodtypid', 0, 2);
		$productM->makeLJ('product.price','priceid','priceid', 0, 3);
		$productM->makeLJ('currency','curid','curid', 0, 4);

		$productM->makeLJ('product.categoryproduct','pid','pid', 0, 5);
		$productM->orderBy( 'premium', 'DESC', 5 );

		$productM->makeLJ('product.category','catid','catid', 5, 6);
		$productM->makeLJ('product.images','pid','pid', 0, 7);
		$productM->whereOn( 'premium', '=', 1, 7 );

		$productM->makeLJ('files','filid','filid', 7, 8 );

		if ( $categoryName ) {
			$productM->makeLJ('product.categorytrans','catid','catid', 6, 9 );
			$productM->whereLanguage( 9, $lgid );
		}
		$productM->whereLanguage( 1, $lgid );
		$productM->whereE('publish', 1);
		$productM->whereE('blocked', 0 );

		if ( WRoles::isNotAdmin( 'storemanager' ) ) {
			if ( empty($vendid) ) {
				$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
				$vendid = $vendorHelperC->getVendorID();
			}			$productM->whereE( 'vendid', $vendid );
		}
		$productM->whereIn( 'prodtypid', $prodTypid );
		$productM->groupBy('pid');

		if ( $filter == 'google' ) {
						$productM->select( 'pid' );
			$productM->select( 'curid' );
			$productM->select( 'catid', 6 );
			$productM->select( 'namekey', 0, 'sku' );

						$productM->select( 'stock' );
			$productM->select( 'electronic' );

						$productM->select( 'name', 11, 'vendorName' );
			$productM->makeLJ( 'vendor', 'vendid', 'vendid', 0, 11 );

						$productM->select( array( 'publishend', 'availableend' ) );
			$productM->where( 'availablestart', '<=', time() );
			$productM->where( 'availableend', '>=', time(), 0, null, 1, 0, 1 ); 			$productM->where( 'availableend', '=', 0, 0, null, 0, 1 );
			$productM->where( 'publishstart', '<=', time() ); 			$productM->where( 'publishend', '=', 0, 0, null, 1, 0, 0  );
			$productM->where( 'publishend', '>=', time(), 0, null, 0, 1, 1  );

  			  			$allusers = WRole::getRole( 'allusers' );
  			$productM->whereE( 'rolid', $allusers );

  			  			$productM->select( 'name', 8, 'imageName' );
  			$productM->select( 'type', 8, 'imageType' );
  			$productM->select( 'path', 8, 'imagePath' );

  			  			$productM->select( 'weight' );
  			$productM->select( 'symbol', 13, 'weightCode' );
  			$productM->makeLJ( 'unit', 'unitid', 'unitid', 0, 13 );

  			  			$productM->select( array( 'score', 'votes', 'nbreviews' ) );

		}

		$productM->setLimit( 10000 );
		$products = $productM->load('ol');

				if ( !empty($products) ) {
			if (in_array('previewFile', $columns) || in_array('itemFile', $columns)){
				foreach($products as $product){
					foreach($product as $key=>$value){
						$file->previewid_name = '';
						$file->previewid_type = '';
						$file->productid_name = '';
						$file->productid_type = '';

												if ($key == 'previewid' OR $key == 'productid'){
							$fileM = WModel::get('files');
							$fileM->select('name', 0, $key.'_name');
							$fileM->select('type', 0, $key.'_type');
							$fileM->whereE('filid', $value);

							$file = $fileM->load('o');
							if (!empty($file)){
								if ($key == 'previewid'){
									$product->previewid_name = $file->previewid_name;
									$product->previewid_type = $file->previewid_type;
								}
								if ($key == 'productid'){
									$product->productid_name = $file->productid_name;
									$product->productid_type = $file->productid_type;
								}							}						}					}				}			}		}
		return $products;
	}


}