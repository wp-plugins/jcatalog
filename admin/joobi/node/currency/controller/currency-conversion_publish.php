<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Currency_conversion_publish_controller extends WController {










	function publish(){

		$curid=WGlobals::get('curid');

		$curid_ref=WGlobals::get('curid_ref');

		$publish=WGlobals::get('publish');



		$publish=($publish) ? '0' : '1';



		static $model = null;

		static $msg = null;

		if ( !isset( $msg ) ) $msg = WMessage::get();

		if ( !isset( $model ) ) $model=WModel::get('currency.conversion');

		

		
		$model->whereE( 'curid', $curid );

		$model->whereE( 'curid_ref', $curid_ref );

		$rate = $model->load('lr','rate');



		if ($rate > '0')

		{

			
			$model->whereE('curid',$curid);

			$model->whereE('curid_ref',$curid_ref);

			$model->setVal('publish',$publish);

			$model->update();

		}

		else

		{

			$msg->userN('1235463799PSWJ');

		}




		return true;

	}







}