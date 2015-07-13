<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_Translation_listing_lang_view extends Output_Listings_class {
function prepareQuery(){



		$lgid=WGlobals::get( 'lgid' );

		$sid=0;

		if( !empty($lgid)){



			if( $lgid !=1){



				$lang=substr( WLanguage::get( $lgid, 'code' ) , 0, 2 );

				$sid=WModel::getID( 'translation.' . $lang );

				if( !empty($sid)){

					WGlobals::setSession( 'translationSID', 'sid', $sid );

				}


			}else{

				
				WGlobals::setSession( 'translationSID', 'sid', 0 );

			}


		}


		if( empty($sid)) $sid=WGlobals::getSession( 'translationSID', 'sid', 0 );




		if( !empty($sid)){

			$this->sid=$sid;

			foreach( $this->elements as $key=> $val){

				if( !empty($this->elements[$key]->sid)) $this->elements[$key]->sid=$sid;

				if( $this->elements[$key]->map=='nbchars' ) unset($this->elements[$key]);

			}


		}





		
		$search=WGlobals::get( 'search' . $this->yid );



		if( substr( $search, 0, 2 )=='TR'){

			WGlobals::set( 'search' . $this->wyid, substr( $search, 2 ));

		}


		return true;



	}}