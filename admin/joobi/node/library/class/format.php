<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















abstract class Library_Format_class {




















	public static function format($value,$format='decimal',$unit=null,$decimal=null,$useStyle=false,$className=''){
		static $locale=array();
		static $localCurrency=null;	
		$lgid=WUser::get('lgid');
				if( !isset($locale[$lgid])){
			$localeconv=WLanguage::get( $lgid, 'localeconv' );
			$locale[$lgid]=unserialize( $localeconv );
		}
		$object=$locale[$lgid];


		if( $format=='decimal' && empty( $unit )){
						if( !isset($decimal)) $decimal=2;				return number_format( round($value, $decimal), $decimal, $object->dp, $object->ts );
		}elseif( $format=='decimal' &&  !empty( $unit )){
			
						$currencyC=WClass::get( 'currency.format', null, 'class', false );
			if( empty($currencyC)) return '';
			$data=$currencyC->load( $unit );

			if( !empty($data)){
				if( !isset($decimal)) $decimal=2;

				$value=str_replace( $data->symbol, '', $value );
				$value=str_replace( $data->code, '', $value );
				$value=str_replace( $object->dp, '.', $value );
				$value=str_replace( $object->ts, '', $value );
				return round( $value, $decimal );
			} else return $value;

		}else{

									if( in_array( $format , array( 'currency', 'symbol', 'code', 'money', 'moneyCode', 'price', 'currencySymbol','currencyCode', 'priceDecimal', 'moneyNoSymbol' ))){

				if( empty($unit)){
					if( !isset($localCurrency )){
						if( !defined('CURRENCY_USED')){
							$currencyFormatC=WClass::get( 'currency.format', null, 'class', false );
							if( empty($currencyFormatC)){
								return '';
							}							$currencyFormatC->set();
						}						$localCurrency=CURRENCY_USED;
					}					$unit=$localCurrency;

				}

								$currencyC=WClass::get( 'currency.format', null, 'class', false );
				if( empty($currencyC)) return '';
				$data=$currencyC->load( $unit );
				$mtVal=$object->mt;
				$mdVal=$object->md;
				$ppvVal=$object->ppv;
				$npvVal=$object->npv;

								if( 'currency'==$format){
					$format=WPref::load( 'PCURRENCY_NODE_CODESYMBOL' );
					if( empty( $format )) $format='moneyCode';
				}
								if( 'symbol'==$format){
										$format='money';
				}elseif( 'code'==$format){
										$format='moneyNoSymbol';
				}
				if( !empty($data)){

					if( $format=='currencySymbol' ) return $data->symbol;
					if( $format=='currencyCode' ) return $data->code;
					$symbol=($format=='money' || $format=='moneyCode' ) ? $data->symbol : '';
										if( !isset($decimal)) $decimal=( $data->basic !=0 && $data->basic !=5 ) ? log10($data->basic) : 0;

					if( 'priceDecimal'==$format){							$mtVal='';
						$mdVal='.';
					}
					if( $format=='moneyCode' && !$ppvVal && !$npvVal){
						$ppvVal=1;
						$npvVal=1;
					}				}else{
					$symbol='';
					if( !isset($decimal)) $decimal=2;
				}
				$amount=number_format( @round($value, $decimal), $decimal, $mdVal, $mtVal );

							}else{
				$useStyle=false; 					if( !isset($decimal)) $decimal=2;
				$symbol=isset($unit) ? $unit : '';
				$amount=number_format( round($value, $decimal), $decimal, $object->dp, $object->ts );
			}
			if( $useStyle){
				$class2use='price';
				if( !empty($className)) $class2use .=' ' . $className;
				$symbol='<span class="symbol">' . $symbol . '</span>';
				$amount='<span class="amount">' . $amount . '</span>';
			}
						if( $amount>=0){
				$string=$object->ps;
				$space=( !empty($object->pss)) ? ' ': '';
				$string .=( $ppvVal ) ? $symbol . $space . $amount :  $amount . $space . $symbol;
			}else{
				if( $amount[0]=='-' ) $amount=substr($amount, 1);
				$negativeSign=$object->ns;
				$space=($object->nss) ? ' ': '';
				$string=( $npvVal ) ? $symbol . $space . $negativeSign . $amount : $negativeSign . $amount . $space . $symbol;
			}
			if(( $format=='moneyCode' || $format=='moneyNoSymbol' )  && !empty($data->code)){
				if( $useStyle ) $data->code='<span class="code">' . $data->code . '</span>';
				$string .=' ' . $data->code;
				$string=str_replace( '  ', ' ', $string );
			}
			if( $useStyle ) $string='<div class="' . $class2use . '">' . $string . '</div>';
			return $string;

		}
		









































	}

}