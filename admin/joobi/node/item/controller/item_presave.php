<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_presave_controller extends WController {


	function presave($skipRedirect=false) {



		$this->save();

		$eid = $this->getElement();

		WGlobals::setEID( $eid );



		if ( empty($this->_model->prodtypid) ) {

			$message = WMessage::get();

			$message->historyE('1298350856KAZQ');

		}


		
		$productM = WModel::get('product.type');



		
		$model = $this->getModel();

		$productM->whereE( 'prodtypid', $model->prodtypid );

		$productDegination = $productM->load( 'lr', 'type');


		$updateDefaultCurrency = false;


		
		switch ( $productDegination ) {

			case '5':	
				$updateDefaultCurrency = true;

				$otherProductM = WModel::get( 'subscription.infos' );

				$otherProductM->setVal( 'pid', $eid );

				$otherProductM->insert();
				break;

			case '11':	
				$updateDefaultCurrency = true;

				$otherProductM = WModel::get( 'auction.infos' );

				$otherProductM->setVal( 'pid', $eid );

				$otherProductM->insert();


				
				$ProductM = WModel::get( 'product' );

				$ProductM->whereE( 'pid', $eid );

				$ProductM->setVal( 'stock', 1);

				$ProductM->update();

				break;

			case '17':	
				$updateDefaultCurrency = true;




				break;

			case '1':					$updateDefaultCurrency = true;
			default:

				
				break;

		}

		$defaultCurrency = WPref::load( 'PCURRENCY_NODE_PREMIUM' );
		if ( $updateDefaultCurrency && ! $defaultCurrency ) {
								$ProductM = WModel::get( 'product' );
				$ProductM->whereE( 'pid', $eid );
				$ProductM->setVal( 'curid', $defaultCurrency );
				$ProductM->update();
		}
		




			
			$controller = WGlobals::get( 'controller' );

			WPages::redirect( 'controller=' . $controller . '&task=edit&eid='. $eid );




	return true;


}
}