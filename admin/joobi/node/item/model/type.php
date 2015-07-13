<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Type_model extends WModel {


	public $_fileInfo = array();











	function __construct() {



		$previewid= new stdClass;

		$previewid->fileType = 'medias';

		$previewid->folder = 'media';

		$previewid->path = 'itemtype';

		$previewid->secure = false;

		$previewid->format = 'jpeg,png,jpg,gif';

		$previewid->maxSize = 500 * 1028;	


		
		$previewid->thumbnail = 1;	
		$previewid->maxHeight = 50;

		$previewid->maxWidth = 50;

		$previewid->maxTHeight = array( 25 );

		$previewid->maxTWidth = array( 25 );

		$previewid->watermark = false;




		$this->_fileInfo['filid'] = $previewid;



		
		parent::__construct();



	}




	function addValidate() {







		return true;



	}




	function validate() {



		
		if ( !empty($this->namekey) ) {

			
			$typeM = WModel::get( 'item.type' );

			$typeM->whereE( 'namekey', $this->namekey );

			if ( !empty($this->prodtypid) ) $typeM->where( 'prodtypid', '!=', $this->prodtypid );

			$exit = $typeM->exist();



			
			if ( $exit ) {

				$this->namekey = $this->genNamekey( '', 64, $this->namekey );

			}
		}




		
		$topicTypeC = WClass::get( 'item.type' );

		$topicTypeC->resetCacheDesignation();



		return true;



	}




















	public function secureTranslation($sid,$eid) {



		$translationC = WClass::get( 'item.translation', null, 'class', false );

		if ( empty($translationC) ) return false;



		
		if ( !$translationC->secureTranslation( $this, $sid, $eid ) ) return false;

		return true;



	}}