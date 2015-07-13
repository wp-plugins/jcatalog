<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Currency_toggle_controller extends WController {

function toggle() {



	WPref::load( 'PCURRENCY_NODE_MULTICUR' );

	if ( PCURRENCY_NODE_MULTICUR ) {


		if ( WGlobals::checkCandy(50) ) {


			static $currencyM=null;

			static $messageC=null;


			$curid = WGlobals::getEID();


			$action = $this->getToggleValue( 'map' );
			$value = $this->getToggleValue( 'value' );





			
			$wid = WExtension::get( 'jstore.application', 'wid' );

			$myAdmins = WUser::getRoleUsers('manager', array('uid') );



			
			$message = WMessage::get();

			$msg = '';



			$reOrder = false;

			$count = 0;

			$reCheck = false;

			if ( !isset( $currencyM ) ) $currencyM = WModel::get( 'currency' );



			
			if ( $action == 'accepted' ) {



				
				$currencyM->whereE( 'accepted', 1);

				$currencyM->whereE( 'publish', 1 );

				$currency = $currencyM->load( 'ol' );



				if ( !empty( $currency ) )

				{

					$count = sizeof( $currency ) + 1;

				}

				else

				{

					$count = 1;

				}


				
				$currencyM->whereE( 'curid', $curid );

				$currencyM->whereE( 'publish', 1 );

				$currencies = $currencyM->load( 'o' );



				if ( !empty( $currencies ) )

				{

					if ( $currencies->accepted == 0 )

					{

						$currencyM->setVal( 'accepted', 1 );

						$currencyM->setVal( 'ordering', $count );

						$reCheck = true;

					}

					else

					{

						
						if ( (sizeof( $currency ) == 1) || ( $count == 1 ) )

						{

							$message->userN('1246699627QZRH');



							return true;

						}


						$currencyM->setVal( 'accepted', 0 );

						$currencyM->setVal( 'ordering', 0 );

						$reOrder = true;

					}


					$currencyM->whereE( 'curid', $curid );

					$currencyM->whereE( 'publish', 1 );

					$currencyM->update();

				}

				else

				{

					$message->userN('1235463799PSWK');

				}


			}

			else 
			{

				$currencyM->whereE( 'curid', $curid );

				$currencyM->whereE( 'publish', 1 );

				$currency = $currencyM->load( 'ol' );



				if ( !empty( $currency ) )

				{

					
					$currencyM->setVal( 'ordering', 0 );

					$currencyM->setVal( 'accepted', 0 );

					$currencyM->setVal( 'publish', 0 );

					$currencyM->whereE( 'curid', $curid );

					$currencyM->update();

					$reOrder = true;

				}

				else

				{

					parent::toggle();

					$reCheck = true;

				}
			}


			if ( $reCheck )

			{

				static $currencyCheckM=null;

				static $curConversionM=null;



				if ( !isset( $currencyCheckM ) ) $currencyCheckM = WModel::get( 'currency' );

				$currencyCheckM->select( 'curid' );


				$currencyCheckM->whereE( 'publish', 1 );

				$currencyCheck = $currencyCheckM->load( 'lra' );



				$curConversion = array();

				$result = array();



				
				if ( !isset( $curConversionM ) ) $curConversionM = WModel::get( 'currency.conversion' );



				if ( !empty( $curConversionM ) )

				{

					$curConversionM->select( 'curid_ref');

					$curConversionM->whereE( 'curid', $curid);

					$curConversion[$curid] = $curConversionM->load( 'lra' );

				}


				
				if ( !empty( $curConversion ) && !empty( $curConversion ) )

				{

					foreach( $curConversion as $key=>$curConversions )

					{

						$index = $key;

						if ( isset( $currencyCheck ) && !empty( $currencyCheck ) )

						{

							foreach( $currencyCheck as $currencies )

							{

								if ( $key == $currencies )

								{

									$found = 1;

								}

								else

								{

									$found = array_search($currencies, $curConversion[$index]);

								}


								if ( $found === false )

								{

									$result[$index][] = $currencies;

								}
							}
						}
					}
				}


				
				$textConversionNotFound = WText::t('1235463799PSWL');

				$msg = $textConversionNotFound .' :';

				$defaultfee = PCURRENCY_NODE_MULTICUR;

				if ( isset( $result ) && !empty( $result ) )

				{

					foreach( $result as $resultCurID=> $results )

					{



						$currencyCheckM->select( 'title' );

						$currencyCheckM->whereE( 'curid', $curid );

						$currencyID = $currencyCheckM->load('lr');



						if ( !empty( $results ) )

						{



							foreach( $results as $resultCurRef )

							{

								$currencyCheckM->select( 'title' );

								$currencyCheckM->whereE( 'curid', $resultCurRef );

								$currencyRef = $currencyCheckM->load('lr');



								$alias = $currencyID .' => '. $currencyRef;

								$msg .=  $alias .'<br>';



								$curConversionM->setVal( 'curid', $curid );

								$curConversionM->setVal( 'curid_ref', $resultCurRef );

								$curConversionM->setVal( 'name', $alias );

								$curConversionM->setVal( 'alias', $alias );

								$curConversionM->setVal( 'fee', $defaultfee );

								$curConversionM->setVal( 'modified', time() );

								$curConversionM->setVal( 'publish', 0 );

								$curConversionM->insert();

							}
						}


					}


					$message->userW( $msg );


					$message->persistantM( $msg, $myAdmins );



				}
			}


			
			if ( $reOrder )

			{

				$count = 0;

				$currencyM->whereE( 'accepted', 1 );

				$currencyM->whereE( 'publish', 1 );

				$currencyM->orderBy( 'ordering' );

				$currency = $currencyM->load( 'ol' );



				if ( isset( $currency ) && !empty( $currency ) )

				{

					foreach( $currency as $index=> $currencies )

					{

						$count += 1;



						$currencyM->setVal( 'ordering', $count );

						$currencyM->whereE( 'accepted', 1 );

						$currencyM->whereE( 'publish', 1 );

						$currencyM->whereE( 'curid', $currencies->curid );

						$currencyM->update();

					}
				}
			}
		}

	}

	return parent::toggle();



}























}