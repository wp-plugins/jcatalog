<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Currency_Node_install extends WInstall {




	public function install(&$object) {

		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {

						$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installTable( 'currency', $this->_installValuesA() );
			$installWidgetsC->installTable( 'currency.country', $this->_installValues2A() );

						$currencyM = WModel::get( 'currency' );
			$currencyM->setVal( 'publish', 0 );
			$currencyM->setVal( 'accepted', 0 );
			$currencyM->update();

						$accceptedCodes = array( 'CAD', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'NZD' );
			$currencyM->setVal( 'publish', 1 );
			$currencyM->setVal( 'accepted', 1 );
			$currencyM->whereIn( 'code', $accceptedCodes );
			$currencyM->update();



			$siteURL = 'http://themoneyconverter.com/rss-feed/EUR/rss.xml';
						$currencyExSiteM = WModel::get( 'currency.exchangesite' );
			$currencyExSiteM->url = $siteURL;
			$currencyExSiteM->publish = 1;
			$currencyExSiteM->website = 'http://themoneyconverter.com';
			$currencyExSiteM->name = 'The Money Converter';
			$currencyExSiteM->save();


						if ( empty($curRateC) ) $curRateC = WClass::get( 'currency.rate' );
			$curRateC->updateExchangeRate( $siteURL, time() );


			$schedulerInstallC = WClass::get( 'scheduler.install' );
			$schedulerInstallC->newScheduler(
			  'currency.updateexchangerate.scheduler'
			, WText::t('1243943352MRGP')
			, WText::t('1244195372FKZZ')
			, 50				, 86400				, 60				, 1					);


			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'currency.price'
			  , 'Price widget'
			  , WText::t('1206961911NYAN')
			, WText::t('1433458263OCIB')
			, 27				);


		}
	}





	public function addExtensions() {

				$extension = new stdClass;
		$extension->namekey = 'currency.currency.module';
		$extension->name = "Joobi - Currency module";
		$extension->folder = 'currency';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|currency|module';
		$extension->core = 1;
		$extension->params = "publish=0\nwidgetView=currency_currency_module";
		$extension->description = '';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


	}





	private function _installValuesA() {

		return array(
  array('curid' => '1','title' => 'Euro','code' => 'EUR','number' => '978','symbol' => '€','position' => '1','cents' => 'Cent','basic' => '100','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '4','core' => '1'),
  array('curid' => '2','title' => 'United States dollar','code' => 'USD','number' => '840','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '1','rate' => '2.000000','accepted' => '1','ordering' => '1','core' => '1'),
  array('curid' => '3','title' => 'British pound','code' => 'GBP','number' => '826','symbol' => '£','position' => '0','cents' => 'Penny','basic' => '100','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '0','core' => '1'),
  array('curid' => '4','title' => 'Japanese yen','code' => 'JPY','number' => '392','symbol' => '¥','position' => '1','cents' => 'Sen','basic' => '0','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '4','core' => '1'),
  array('curid' => '7','title' => 'United Arab Emirates dirham','code' => 'AED','number' => '784','symbol' => 'د.إ','position' => '0','cents' => 'Fils','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '13','core' => '1'),
  array('curid' => '8','title' => 'Afghan afghani','code' => 'AFN','number' => '971','symbol' => '؋','position' => '0','cents' => 'Pul','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '7','core' => '1'),
  array('curid' => '9','title' => 'Albanian lek','code' => 'ALL','number' => '8','symbol' => 'Lek','position' => '0','cents' => 'Qintar','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '12','core' => '1'),
  array('curid' => '10','title' => 'Armenian dram','code' => 'AMD','number' => '51','symbol' => 'դր.','position' => '0','cents' => 'Luma','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '14','core' => '1'),
  array('curid' => '11','title' => 'Netherlands Antillean gulden','code' => 'ANG','number' => '532','symbol' => 'ƒ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '15','core' => '1'),
  array('curid' => '12','title' => 'Angolan kwanza','code' => 'AOA','number' => '973','symbol' => 'Kz ','position' => '0','cents' => 'Cêntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '1','core' => '1'),
  array('curid' => '13','title' => 'Argentine peso','code' => 'ARS','number' => '32','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '18','core' => '1'),
  array('curid' => '14','title' => 'Australian dollar','code' => 'AUD','number' => '36','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '1','core' => '1'),
  array('curid' => '15','title' => 'Aruban florin','code' => 'AWG','number' => '533','symbol' => 'ƒ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '1','core' => '1'),
  array('curid' => '16','title' => 'Azerbaijani manat','code' => 'AZN','number' => '944','symbol' => 'ман','position' => '0','cents' => 'Qəpik','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '7','core' => '1'),
  array('curid' => '17','title' => 'Bosnia and Herzegovina convert','code' => 'BAM','number' => '977','symbol' => 'KM','position' => '0','cents' => 'Fening','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '7','core' => '1'),
  array('curid' => '18','title' => 'Barbadian dollar','code' => 'BBD','number' => '52','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '7','core' => '1'),
  array('curid' => '19','title' => 'Bangladeshi taka','code' => 'BDT','number' => '50','symbol' => '৳','position' => '0','cents' => 'Paisa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '17','core' => '1'),
  array('curid' => '20','title' => 'Bulgarian lev','code' => 'BGN','number' => '975','symbol' => 'лв','position' => '0','cents' => 'Stotinka','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '16','core' => '1'),
  array('curid' => '21','title' => 'Bahraini dinar','code' => 'BHD','number' => '48','symbol' => 'ب.د','position' => '0','cents' => 'Fils','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '11','core' => '1'),
  array('curid' => '22','title' => 'Burundian franc','code' => 'BIF','number' => '108','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '10','core' => '1'),
  array('curid' => '23','title' => 'Bermudian dollar','code' => 'BMD','number' => '60','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '4','core' => '1'),
  array('curid' => '24','title' => 'Brunei dollar','code' => 'BND','number' => '96','symbol' => '$','position' => '0','cents' => 'Sen','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '3','core' => '1'),
  array('curid' => '25','title' => 'Bolivian boliviano','code' => 'BOB','number' => '68','symbol' => '$b','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '2','core' => '1'),
  array('curid' => '26','title' => 'Mvdol','code' => 'BOV','number' => '984','symbol' => 'BOV','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '1','core' => '1'),
  array('curid' => '27','title' => 'Brazilian real','code' => 'BRL','number' => '986','symbol' => 'R$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '1','core' => '1'),
  array('curid' => '28','title' => 'Bahamian dollar','code' => 'BSD','number' => '44','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '5','core' => '1'),
  array('curid' => '29','title' => 'Botswana pula','code' => 'BWP','number' => '72','symbol' => 'P','position' => '0','cents' => 'Thebe','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '6','core' => '1'),
  array('curid' => '30','title' => 'Belarusian ruble','code' => 'BYR','number' => '974','symbol' => 'p.','position' => '0','cents' => 'Kapyeyka','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '9','core' => '1'),
  array('curid' => '31','title' => 'Belize dollar','code' => 'BZD','number' => '84','symbol' => 'BZ$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '8','core' => '1'),
  array('curid' => '32','title' => 'Canadian dollar','code' => 'CAD','number' => '124','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '0','core' => '1'),
  array('curid' => '33','title' => 'Congolese franc','code' => 'CDF','number' => '976','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '7','core' => '1'),
  array('curid' => '34','title' => 'Swiss franc','code' => 'CHF','number' => '756','symbol' => 'CHF','position' => '0','cents' => 'Rappen','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '35','title' => 'WIR Franc','code' => 'CHW','number' => '948','symbol' => 'CHW','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '36','title' => 'WIR Euro','code' => 'CHE','number' => '947','symbol' => '€','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '37','title' => 'Chilean peso','code' => 'CLP','number' => '152','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '2','core' => '1'),
  array('curid' => '38','title' => 'Unidades de ','code' => 'CLF','number' => '990','symbol' => 'CLF','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '39','title' => 'Chinese renminbi yuan','code' => 'CNY','number' => '156','symbol' => '元','position' => '0','cents' => 'Jiao','basic' => '10','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '40','title' => 'Colombian peso','code' => 'COP','number' => '170','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '3','core' => '1'),
  array('curid' => '41','title' => 'Unidad de Va','code' => 'COU','number' => '970','symbol' => 'COU','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '42','title' => 'Costa Rican colón','code' => 'CRC','number' => '188','symbol' => '₡','position' => '0','cents' => 'Céntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '43','title' => 'Cuban peso','code' => 'CUP','number' => '192','symbol' => '₱','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '44','title' => 'Cape Verdean escudo','code' => 'CVE','number' => '132','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '45','title' => 'Czech koruna','code' => 'CZK','number' => '203','symbol' => 'Kč','position' => '0','cents' => 'Haléř','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '46','title' => 'Djiboutian franc','code' => 'DJF','number' => '262','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '47','title' => 'Danish krone','code' => 'DKK','number' => '208','symbol' => 'kr','position' => '0','cents' => 'Øre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '48','title' => 'Dominican peso','code' => 'DOP','number' => '214','symbol' => 'RD$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '49','title' => 'Algerian dinar','code' => 'DZD','number' => '12','symbol' => 'د.ج','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '50','title' => 'Estonian kroon','code' => 'EEK','number' => '233','symbol' => 'kr','position' => '0','cents' => 'Sent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '51','title' => 'Eritrean nakfa','code' => 'ERN','number' => '232','symbol' => 'Nfk ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '52','title' => 'Ethiopian birr','code' => 'ETB','number' => '230','symbol' => 'ETB','position' => '0','cents' => 'Santim','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '53','title' => 'Fijian dollar','code' => 'FJD','number' => '242','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '54','title' => 'Georgian lari','code' => 'GEL','number' => '981','symbol' => 'ლ','position' => '0','cents' => 'Tetri','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '55','title' => 'Ghanaian cedi','code' => 'GHS','number' => '936','symbol' => '₵','position' => '0','cents' => 'Pesewa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '56','title' => 'Gambian dalasi','code' => 'GMD','number' => '270','symbol' => 'D ','position' => '0','cents' => 'Butut','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '57','title' => 'Egyptian pound','code' => 'EGP','number' => '818','symbol' => '£','position' => '0','cents' => 'Piastre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '58','title' => 'Falkland pound','code' => 'FKP','number' => '238','symbol' => '£','position' => '0','cents' => 'Penny','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '59','title' => 'Gibraltar pound','code' => 'GIP','number' => '292','symbol' => '£','position' => '0','cents' => 'Penny','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '60','title' => 'Guinean franc','code' => 'GNF','number' => '324','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '61','title' => 'Guatemalan quetzal','code' => 'GTQ','number' => '320','symbol' => 'Q','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '62','title' => 'West African CFA franc','code' => 'XOF','number' => '952','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '63','title' => 'Guinea-Bissa','code' => 'GWP','number' => '624','symbol' => 'GWP','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '64','title' => 'Guyanese dollar','code' => 'GYD','number' => '328','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '65','title' => 'Hong Kong dollar','code' => 'HKD','number' => '344','symbol' => '元','position' => '0','cents' => 'Ho','basic' => '10','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '66','title' => 'Honduran lempira','code' => 'HNL','number' => '340','symbol' => 'L','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '67','title' => 'Croatian kuna','code' => 'HRK','number' => '191','symbol' => 'kn','position' => '0','cents' => 'Lipa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '68','title' => 'Haitian gourde','code' => 'HTG','number' => '332','symbol' => 'G ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '69','title' => 'Hungarian forint','code' => 'HUF','number' => '348','symbol' => 'Ft','position' => '0','cents' => 'Fillér','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '70','title' => 'Indonesian rupiah','code' => 'IDR','number' => '360','symbol' => 'Rp','position' => '0','cents' => 'Sen','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '71','title' => 'Israeli new sheqel','code' => 'ILS','number' => '376','symbol' => '₪','position' => '0','cents' => 'Agora','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '72','title' => 'Indian rupee','code' => 'INR','number' => '356','symbol' => '₨','position' => '0','cents' => 'Paisa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '73','title' => 'Bhutanese ngultrum','code' => 'BTN','number' => '64','symbol' => 'BTN','position' => '0','cents' => 'Chertrum','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '74','title' => 'Iraqi dinar','code' => 'IQD','number' => '368','symbol' => 'ع.د','position' => '0','cents' => 'Fils','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '75','title' => 'Iranian rial','code' => 'IRR','number' => '364','symbol' => '﷼','position' => '0','cents' => 'Dinar','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '76','title' => 'Icelandic króna','code' => 'ISK','number' => '352','symbol' => 'kr','position' => '0','cents' => 'Eyrir','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '77','title' => 'Jamaican dollar','code' => 'JMD','number' => '388','symbol' => 'J$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '78','title' => 'Jordanian dinar','code' => 'JOD','number' => '400','symbol' => 'د.ا','position' => '0','cents' => 'Piastre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '79','title' => 'Kenyan shilling','code' => 'KES','number' => '404','symbol' => 'Sh ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '80','title' => 'Kyrgyzstani som','code' => 'KGS','number' => '417','symbol' => 'лв','position' => '0','cents' => 'Tyiyn','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '81','title' => 'Cambodian riel','code' => 'KHR','number' => '116','symbol' => '៛','position' => '0','cents' => 'Sen','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '82','title' => 'Comorian franc','code' => 'KMF','number' => '174','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '83','title' => 'North Korean won','code' => 'KPW','number' => '408','symbol' => '₩','position' => '0','cents' => 'Chŏn','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '84','title' => 'South Korean won','code' => 'KRW','number' => '410','symbol' => '₩','position' => '0','cents' => 'Jeon','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '85','title' => 'Kuwaiti dinar','code' => 'KWD','number' => '414','symbol' => 'د.ك','position' => '0','cents' => 'Fils','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '86','title' => 'Cayman Islands dollar','code' => 'KYD','number' => '136','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '87','title' => 'Kazakhstani tenge','code' => 'KZT','number' => '398','symbol' => 'лв','position' => '0','cents' => 'Tiyn','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '88','title' => 'Lao kip','code' => 'LAK','number' => '418','symbol' => '₭','position' => '0','cents' => 'Att','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '89','title' => 'Lebanese pound','code' => 'LBP','number' => '422','symbol' => '£','position' => '0','cents' => 'Piastre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '90','title' => 'Sri Lankan rupee','code' => 'LKR','number' => '144','symbol' => '₨','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '91','title' => 'Liberian dollar','code' => 'LRD','number' => '430','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '92','title' => 'Lithuanian litas','code' => 'LTL','number' => '440','symbol' => 'Lt','position' => '0','cents' => 'Centas','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '93','title' => 'Latvian lats','code' => 'LVL','number' => '428','symbol' => 'Ls','position' => '0','cents' => 'Sant_ms','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '94','title' => 'Libyan dinar','code' => 'LYD','number' => '434','symbol' => 'ل.د','position' => '0','cents' => 'Dirham','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '95','title' => 'Moroccan dirham','code' => 'MAD','number' => '504','symbol' => 'د.م.','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '96','title' => 'Moldovan leu','code' => 'MDL','number' => '498','symbol' => 'L ','position' => '0','cents' => 'Ban','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '97','title' => 'Malagasy ariary','code' => 'MGA','number' => '969','symbol' => 'MGA','position' => '0','cents' => 'Iraimbilanja','basic' => '5','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '98','title' => 'Macedonian denar','code' => 'MKD','number' => '807','symbol' => 'ден','position' => '0','cents' => 'Deni','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '99','title' => 'Myanmar kyat','code' => 'MMK','number' => '104','symbol' => 'K ','position' => '0','cents' => 'Pya','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '100','title' => 'Mongolian tögrög','code' => 'MNT','number' => '496','symbol' => '₮','position' => '0','cents' => 'Möngö','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '101','title' => 'Macanese pataca','code' => 'MOP','number' => '446','symbol' => 'P ','position' => '0','cents' => 'Avo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '102','title' => 'Mauritanian ouguiya','code' => 'MRO','number' => '478','symbol' => 'UM ','position' => '0','cents' => 'Khoums','basic' => '5','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '103','title' => 'Mauritian rupee','code' => 'MUR','number' => '480','symbol' => '₨','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '104','title' => 'Maldivian rufiyaa','code' => 'MVR','number' => '462','symbol' => 'Rf','position' => '0','cents' => 'Laari','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '105','title' => 'Malawian kwacha','code' => 'MWK','number' => '454','symbol' => 'MK ','position' => '0','cents' => 'Tambala','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '106','title' => 'Mexican peso','code' => 'MXN','number' => '484','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '107','title' => 'Mexican Unid','code' => 'MXV','number' => '979','symbol' => 'MXV','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '108','title' => 'Malaysian ringgit','code' => 'MYR','number' => '458','symbol' => 'RM','position' => '0','cents' => 'Sen','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '109','title' => 'Mozambican metical','code' => 'MZN','number' => '943','symbol' => 'MT','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '110','title' => 'Nigerian naira','code' => 'NGN','number' => '566','symbol' => '₦','position' => '0','cents' => 'Kobo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '111','title' => 'Nicaraguan córdoba','code' => 'NIO','number' => '558','symbol' => 'C$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '112','title' => 'Norwegian krone','code' => 'NOK','number' => '578','symbol' => 'kr','position' => '0','cents' => 'Øre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '113','title' => 'Nepalese rupee','code' => 'NPR','number' => '524','symbol' => '₨','position' => '0','cents' => 'Paisa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '114','title' => 'New Zealand dollar','code' => 'NZD','number' => '554','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '1','rate' => '1.000000','accepted' => '1','ordering' => '0','core' => '1'),
  array('curid' => '115','title' => 'Omani rial','code' => 'OMR','number' => '512','symbol' => '﷼','position' => '0','cents' => 'Baisa','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '116','title' => 'Panamanian balboa','code' => 'PAB','number' => '590','symbol' => 'B/.','position' => '0','cents' => 'Centésimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '117','title' => 'Peruvian nuevo sol','code' => 'PEN','number' => '604','symbol' => 'S/.','position' => '0','cents' => 'Céntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '118','title' => 'Papua New Guinean kina','code' => 'PGK','number' => '598','symbol' => 'K ','position' => '0','cents' => 'Toea','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '119','title' => 'Philippine peso','code' => 'PHP','number' => '608','symbol' => '₱','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '120','title' => 'Pakistani rupee','code' => 'PKR','number' => '586','symbol' => '₨','position' => '0','cents' => 'Paisa','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '121','title' => 'Polish Złoty','code' => 'PLN','number' => '985','symbol' => 'zł','position' => '0','cents' => 'Grosz','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '122','title' => 'Paraguayan guaraní','code' => 'PYG','number' => '600','symbol' => '₲','position' => '0','cents' => 'Céntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '123','title' => 'Qatari riyal','code' => 'QAR','number' => '634','symbol' => '﷼','position' => '0','cents' => 'Dirham','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '124','title' => 'Romanian leu','code' => 'RON','number' => '946','symbol' => 'lei','position' => '0','cents' => 'Ban','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '125','title' => 'Serbian dinar','code' => 'RSD','number' => '941','symbol' => 'Дин.','position' => '0','cents' => 'Para','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '126','title' => 'Russian ruble','code' => 'RUB','number' => '643','symbol' => 'руб','position' => '0','cents' => 'Kopek','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '127','title' => 'Rwandan franc','code' => 'RWF','number' => '646','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '128','title' => 'Saudi riyal','code' => 'SAR','number' => '682','symbol' => '﷼','position' => '0','cents' => 'Hallallah','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '129','title' => 'Solomon Islands dollar','code' => 'SBD','number' => '90','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '130','title' => 'Seychellois rupee','code' => 'SCR','number' => '690','symbol' => '₨','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '131','title' => 'Sudanese pound','code' => 'SDG','number' => '938','symbol' => '£ ','position' => '0','cents' => 'Piastre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '132','title' => 'Swedish krona','code' => 'SEK','number' => '752','symbol' => 'kr','position' => '0','cents' => 'Öre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '133','title' => 'Singapore dollar','code' => 'SGD','number' => '702','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '134','title' => 'Saint Helenian pound','code' => 'SHP','number' => '654','symbol' => '£','position' => '0','cents' => 'Penny','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '135','title' => 'Slovak koruna','code' => 'SKK','number' => '703','symbol' => 'Sk ','position' => '0','cents' => 'Halier','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '136','title' => 'Sierra Leonean leone','code' => 'SLL','number' => '694','symbol' => 'Le ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '137','title' => 'Somali shilling','code' => 'SOS','number' => '706','symbol' => 'S','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '138','title' => 'Surinamese dollar','code' => 'SRD','number' => '968','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '139','title' => 'São Tomé and Príncipe dobra','code' => 'STD','number' => '678','symbol' => 'Db ','position' => '0','cents' => 'Cêntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '140','title' => 'Salvadoran colón','code' => 'SVC','number' => '222','symbol' => '$','position' => '0','cents' => 'Centavo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '141','title' => 'Syrian pound','code' => 'SYP','number' => '760','symbol' => '£','position' => '0','cents' => 'Piastre','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '142','title' => 'Swazi lilangeni','code' => 'SZL','number' => '748','symbol' => 'L ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '143','title' => 'Thai baht','code' => 'THB','number' => '764','symbol' => '฿','position' => '0','cents' => 'Satang','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '144','title' => 'Tajikistani somoni','code' => 'TJS','number' => '972','symbol' => 'ЅМ','position' => '0','cents' => 'Diram','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '145','title' => 'Turkmenistani manat','code' => 'TMM','number' => '795','symbol' => 'm ','position' => '0','cents' => 'Tennesi','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '146','title' => 'Tunisian dinar','code' => 'TND','number' => '788','symbol' => 'د.ت','position' => '0','cents' => 'Millime','basic' => '1000','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '147','title' => 'Tongan paʻanga','code' => 'TOP','number' => '776','symbol' => 'T$ ','position' => '0','cents' => 'Seniti','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '148','title' => 'Turkish new lira','code' => 'TRY','number' => '949','symbol' => 'YTL','position' => '0','cents' => 'New kuruş','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '149','title' => 'Trinidad and Tobago dollar','code' => 'TTD','number' => '780','symbol' => 'TT$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '150','title' => 'New Taiwan dollar','code' => 'TWD','number' => '901','symbol' => 'NT$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '151','title' => 'Tanzanian shilling','code' => 'TZS','number' => '834','symbol' => 'Sh ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '152','title' => 'Ukrainian hryvnia','code' => 'UAH','number' => '980','symbol' => '₴','position' => '0','cents' => 'Kopiyka','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '153','title' => 'Ugandan shilling','code' => 'UGX','number' => '800','symbol' => 'Sh ','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '156','title' => 'Uruguayan peso','code' => 'UYU','number' => '858','symbol' => '$','position' => '0','cents' => 'Centésimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '157','title' => 'Uruguay Peso','code' => 'UYI','number' => '940','symbol' => 'UYI','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '158','title' => 'Uzbekistani som','code' => 'UZS','number' => '860','symbol' => 'лв','position' => '0','cents' => 'Tiyin','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '159','title' => 'Venezuelan bolívar','code' => 'VEF','number' => '937','symbol' => 'Bs','position' => '0','cents' => 'Céntimo','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '160','title' => 'Vietnamese Dong','code' => 'VND','number' => '704','symbol' => '₫','position' => '0','cents' => 'Hào','basic' => '10','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '161','title' => 'Vanuatu vatu','code' => 'VUV','number' => '548','symbol' => 'Vt ','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '162','title' => 'Samoan tala','code' => 'WST','number' => '882','symbol' => 'T ','position' => '0','cents' => 'Sene','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '163','title' => 'Central African CFA franc','code' => 'XAF','number' => '950','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '164','title' => 'Silver','code' => 'XAG','number' => '961','symbol' => 'XAG','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '165','title' => 'Gold','code' => 'XAU','number' => '959','symbol' => 'Gold','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '166','title' => 'Bond Markets','code' => 'XBA','number' => '955','symbol' => 'XBA','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '167','title' => 'European Mon','code' => 'XBB','number' => '956','symbol' => 'XBB','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '168','title' => 'European Uni','code' => 'XBC','number' => '957','symbol' => 'XBC','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '169','title' => 'European Uni','code' => 'XBD','number' => '958','symbol' => 'XBD','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '170','title' => 'East Caribbean dollar','code' => 'XCD','number' => '951','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '171','title' => 'SDR','code' => 'XDR','number' => '960','symbol' => 'XDR','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '172','title' => 'UIC-Franc','code' => 'XFU','number' => '0','symbol' => 'XFU','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '173','title' => 'Palladium','code' => 'XPD','number' => '964','symbol' => 'XPD','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '174','title' => 'CFP franc','code' => 'XPF','number' => '953','symbol' => 'Fr ','position' => '0','cents' => 'Centime','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '175','title' => 'Platinum','code' => 'XPT','number' => '962','symbol' => 'XPT','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '176','title' => 'Codes specif','code' => 'XTS','number' => '963','symbol' => 'XTS','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '177','title' => 'The codes as','code' => 'XXX','number' => '999','symbol' => 'XXX','position' => '0','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '178','title' => 'Yemeni rial','code' => 'YER','number' => '886','symbol' => '﷼','position' => '0','cents' => 'Fils','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '179','title' => 'South African rand','code' => 'ZAR','number' => '710','symbol' => 'R','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '180','title' => 'Lesotho loti','code' => 'LSL','number' => '426','symbol' => 'L ','position' => '0','cents' => 'Sente','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '181','title' => 'Namibian dollar','code' => 'NAD','number' => '516','symbol' => '$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '182','title' => 'Zambian kwacha','code' => 'ZMK','number' => '894','symbol' => 'ZK ','position' => '0','cents' => 'Ngwee','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '183','title' => 'Zimbabwean dollar','code' => 'ZWD','number' => '716','symbol' => 'Z$','position' => '0','cents' => 'Cent','basic' => '100','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '0','core' => '1'),
  array('curid' => '185','title' => 'Points','code' => 'POINTS','number' => '0','symbol' => 'Pts','position' => '1','cents' => '','basic' => '0','publish' => '0','rate' => '1.000000','accepted' => '0','ordering' => '1','core' => '1')
);

	}





	private function _installValues2A() {
		return array(
  array('curid' => '1','ctyid' => '5','ordering' => '1'),
  array('curid' => '1','ctyid' => '14','ordering' => '1'),
  array('curid' => '1','ctyid' => '21','ordering' => '1'),
  array('curid' => '1','ctyid' => '56','ordering' => '1'),
  array('curid' => '1','ctyid' => '72','ordering' => '0'),
  array('curid' => '1','ctyid' => '73','ordering' => '1'),
  array('curid' => '1','ctyid' => '74','ordering' => '1'),
  array('curid' => '1','ctyid' => '80','ordering' => '1'),
  array('curid' => '1','ctyid' => '83','ordering' => '1'),
  array('curid' => '1','ctyid' => '86','ordering' => '1'),
  array('curid' => '1','ctyid' => '94','ordering' => '1'),
  array('curid' => '1','ctyid' => '103','ordering' => '1'),
  array('curid' => '1','ctyid' => '105','ordering' => '1'),
  array('curid' => '1','ctyid' => '124','ordering' => '1'),
  array('curid' => '1','ctyid' => '134','ordering' => '1'),
  array('curid' => '1','ctyid' => '137','ordering' => '1'),
  array('curid' => '1','ctyid' => '141','ordering' => '1'),
  array('curid' => '1','ctyid' => '150','ordering' => '1'),
  array('curid' => '1','ctyid' => '172','ordering' => '1'),
  array('curid' => '1','ctyid' => '175','ordering' => '1'),
  array('curid' => '1','ctyid' => '182','ordering' => '1'),
  array('curid' => '1','ctyid' => '185','ordering' => '1'),
  array('curid' => '1','ctyid' => '186','ordering' => '1'),
  array('curid' => '1','ctyid' => '193','ordering' => '1'),
  array('curid' => '1','ctyid' => '194','ordering' => '1'),
  array('curid' => '1','ctyid' => '199','ordering' => '1'),
  array('curid' => '2','ctyid' => '4','ordering' => '1'),
  array('curid' => '2','ctyid' => '8','ordering' => '1'),
  array('curid' => '2','ctyid' => '31','ordering' => '1'),
  array('curid' => '2','ctyid' => '62','ordering' => '1'),
  array('curid' => '2','ctyid' => '87','ordering' => '1'),
  array('curid' => '2','ctyid' => '92','ordering' => '2'),
  array('curid' => '2','ctyid' => '132','ordering' => '1'),
  array('curid' => '2','ctyid' => '133','ordering' => '1'),
  array('curid' => '2','ctyid' => '139','ordering' => '1'),
  array('curid' => '2','ctyid' => '159','ordering' => '1'),
  array('curid' => '2','ctyid' => '163','ordering' => '1'),
  array('curid' => '2','ctyid' => '165','ordering' => '1'),
  array('curid' => '2','ctyid' => '169','ordering' => '2'),
  array('curid' => '2','ctyid' => '173','ordering' => '1'),
  array('curid' => '2','ctyid' => '220','ordering' => '1'),
  array('curid' => '2','ctyid' => '226','ordering' => '1'),
  array('curid' => '2','ctyid' => '227','ordering' => '1'),
  array('curid' => '2','ctyid' => '233','ordering' => '1'),
  array('curid' => '2','ctyid' => '234','ordering' => '1'),
  array('curid' => '3','ctyid' => '198','ordering' => '1'),
  array('curid' => '3','ctyid' => '225','ordering' => '1'),
  array('curid' => '4','ctyid' => '107','ordering' => '1'),
  array('curid' => '7','ctyid' => '224','ordering' => '1'),
  array('curid' => '8','ctyid' => '1','ordering' => '1'),
  array('curid' => '9','ctyid' => '2','ordering' => '1'),
  array('curid' => '10','ctyid' => '11','ordering' => '1'),
  array('curid' => '11','ctyid' => '151','ordering' => '1'),
  array('curid' => '12','ctyid' => '6','ordering' => '1'),
  array('curid' => '13','ctyid' => '10','ordering' => '1'),
  array('curid' => '14','ctyid' => '13','ordering' => '1'),
  array('curid' => '14','ctyid' => '45','ordering' => '1'),
  array('curid' => '14','ctyid' => '46','ordering' => '1'),
  array('curid' => '14','ctyid' => '93','ordering' => '1'),
  array('curid' => '14','ctyid' => '111','ordering' => '1'),
  array('curid' => '14','ctyid' => '148','ordering' => '1'),
  array('curid' => '14','ctyid' => '158','ordering' => '1'),
  array('curid' => '15','ctyid' => '12','ordering' => '1'),
  array('curid' => '16','ctyid' => '15','ordering' => '1'),
  array('curid' => '17','ctyid' => '27','ordering' => '1'),
  array('curid' => '18','ctyid' => '19','ordering' => '1'),
  array('curid' => '19','ctyid' => '18','ordering' => '1'),
  array('curid' => '20','ctyid' => '33','ordering' => '1'),
  array('curid' => '21','ctyid' => '17','ordering' => '1'),
  array('curid' => '22','ctyid' => '35','ordering' => '1'),
  array('curid' => '23','ctyid' => '24','ordering' => '1'),
  array('curid' => '24','ctyid' => '32','ordering' => '1'),
  array('curid' => '25','ctyid' => '26','ordering' => '1'),
  array('curid' => '27','ctyid' => '30','ordering' => '1'),
  array('curid' => '28','ctyid' => '16','ordering' => '1'),
  array('curid' => '29','ctyid' => '28','ordering' => '1'),
  array('curid' => '30','ctyid' => '20','ordering' => '1'),
  array('curid' => '31','ctyid' => '22','ordering' => '1'),
  array('curid' => '32','ctyid' => '38','ordering' => '1'),
  array('curid' => '33','ctyid' => '49','ordering' => '2'),
  array('curid' => '33','ctyid' => '50','ordering' => '1'),
  array('curid' => '34','ctyid' => '122','ordering' => '1'),
  array('curid' => '34','ctyid' => '206','ordering' => '1'),
  array('curid' => '37','ctyid' => '43','ordering' => '1'),
  array('curid' => '39','ctyid' => '44','ordering' => '1'),
  array('curid' => '40','ctyid' => '47','ordering' => '1'),
  array('curid' => '42','ctyid' => '52','ordering' => '1'),
  array('curid' => '43','ctyid' => '55','ordering' => '1'),
  array('curid' => '44','ctyid' => '39','ordering' => '1'),
  array('curid' => '45','ctyid' => '57','ordering' => '1'),
  array('curid' => '46','ctyid' => '59','ordering' => '1'),
  array('curid' => '47','ctyid' => '58','ordering' => '1'),
  array('curid' => '47','ctyid' => '70','ordering' => '1'),
  array('curid' => '47','ctyid' => '84','ordering' => '1'),
  array('curid' => '48','ctyid' => '61','ordering' => '1'),
  array('curid' => '49','ctyid' => '3','ordering' => '1'),
  array('curid' => '50','ctyid' => '67','ordering' => '1'),
  array('curid' => '51','ctyid' => '66','ordering' => '2'),
  array('curid' => '52','ctyid' => '66','ordering' => '1'),
  array('curid' => '52','ctyid' => '68','ordering' => '1'),
  array('curid' => '53','ctyid' => '71','ordering' => '1'),
  array('curid' => '54','ctyid' => '79','ordering' => '1'),
  array('curid' => '55','ctyid' => '81','ordering' => '1'),
  array('curid' => '56','ctyid' => '78','ordering' => '1'),
  array('curid' => '57','ctyid' => '63','ordering' => '1'),
  array('curid' => '58','ctyid' => '69','ordering' => '1'),
  array('curid' => '59','ctyid' => '82','ordering' => '1'),
  array('curid' => '60','ctyid' => '89','ordering' => '1'),
  array('curid' => '61','ctyid' => '88','ordering' => '1'),
  array('curid' => '62','ctyid' => '23','ordering' => '1'),
  array('curid' => '62','ctyid' => '34','ordering' => '1'),
  array('curid' => '62','ctyid' => '90','ordering' => '1'),
  array('curid' => '62','ctyid' => '131','ordering' => '1'),
  array('curid' => '62','ctyid' => '155','ordering' => '1'),
  array('curid' => '62','ctyid' => '188','ordering' => '1'),
  array('curid' => '62','ctyid' => '213','ordering' => '1'),
  array('curid' => '64','ctyid' => '91','ordering' => '1'),
  array('curid' => '65','ctyid' => '96','ordering' => '1'),
  array('curid' => '66','ctyid' => '95','ordering' => '1'),
  array('curid' => '67','ctyid' => '54','ordering' => '1'),
  array('curid' => '68','ctyid' => '92','ordering' => '1'),
  array('curid' => '69','ctyid' => '97','ordering' => '1'),
  array('curid' => '70','ctyid' => '100','ordering' => '1'),
  array('curid' => '70','ctyid' => '212','ordering' => '1'),
  array('curid' => '71','ctyid' => '104','ordering' => '1'),
  array('curid' => '72','ctyid' => '25','ordering' => '2'),
  array('curid' => '72','ctyid' => '99','ordering' => '1'),
  array('curid' => '73','ctyid' => '25','ordering' => '1'),
  array('curid' => '74','ctyid' => '102','ordering' => '1'),
  array('curid' => '75','ctyid' => '101','ordering' => '1'),
  array('curid' => '76','ctyid' => '98','ordering' => '1'),
  array('curid' => '77','ctyid' => '106','ordering' => '1'),
  array('curid' => '78','ctyid' => '108','ordering' => '1'),
  array('curid' => '78','ctyid' => '164','ordering' => '1'),
  array('curid' => '79','ctyid' => '110','ordering' => '1'),
  array('curid' => '80','ctyid' => '115','ordering' => '1'),
  array('curid' => '81','ctyid' => '36','ordering' => '1'),
  array('curid' => '82','ctyid' => '48','ordering' => '1'),
  array('curid' => '83','ctyid' => '112','ordering' => '1'),
  array('curid' => '84','ctyid' => '113','ordering' => '1'),
  array('curid' => '85','ctyid' => '114','ordering' => '1'),
  array('curid' => '86','ctyid' => '40','ordering' => '1'),
  array('curid' => '87','ctyid' => '109','ordering' => '1'),
  array('curid' => '88','ctyid' => '116','ordering' => '1'),
  array('curid' => '89','ctyid' => '118','ordering' => '1'),
  array('curid' => '90','ctyid' => '200','ordering' => '1'),
  array('curid' => '91','ctyid' => '120','ordering' => '1'),
  array('curid' => '92','ctyid' => '123','ordering' => '1'),
  array('curid' => '93','ctyid' => '117','ordering' => '1'),
  array('curid' => '94','ctyid' => '121','ordering' => '1'),
  array('curid' => '95','ctyid' => '144','ordering' => '1'),
  array('curid' => '95','ctyid' => '236','ordering' => '1'),
  array('curid' => '96','ctyid' => '140','ordering' => '1'),
  array('curid' => '97','ctyid' => '127','ordering' => '1'),
  array('curid' => '98','ctyid' => '126','ordering' => '1'),
  array('curid' => '99','ctyid' => '146','ordering' => '1'),
  array('curid' => '100','ctyid' => '142','ordering' => '1'),
  array('curid' => '101','ctyid' => '125','ordering' => '1'),
  array('curid' => '102','ctyid' => '135','ordering' => '1'),
  array('curid' => '103','ctyid' => '136','ordering' => '1'),
  array('curid' => '104','ctyid' => '130','ordering' => '1'),
  array('curid' => '105','ctyid' => '128','ordering' => '1'),
  array('curid' => '106','ctyid' => '138','ordering' => '1'),
  array('curid' => '108','ctyid' => '129','ordering' => '1'),
  array('curid' => '109','ctyid' => '145','ordering' => '1'),
  array('curid' => '110','ctyid' => '156','ordering' => '1'),
  array('curid' => '111','ctyid' => '154','ordering' => '1'),
  array('curid' => '112','ctyid' => '29','ordering' => '1'),
  array('curid' => '112','ctyid' => '160','ordering' => '1'),
  array('curid' => '112','ctyid' => '203','ordering' => '1'),
  array('curid' => '113','ctyid' => '149','ordering' => '1'),
  array('curid' => '114','ctyid' => '51','ordering' => '1'),
  array('curid' => '114','ctyid' => '153','ordering' => '1'),
  array('curid' => '114','ctyid' => '157','ordering' => '1'),
  array('curid' => '114','ctyid' => '170','ordering' => '1'),
  array('curid' => '114','ctyid' => '214','ordering' => '1'),
  array('curid' => '115','ctyid' => '161','ordering' => '1'),
  array('curid' => '117','ctyid' => '168','ordering' => '1'),
  array('curid' => '118','ctyid' => '166','ordering' => '1'),
  array('curid' => '119','ctyid' => '169','ordering' => '1'),
  array('curid' => '120','ctyid' => '162','ordering' => '1'),
  array('curid' => '121','ctyid' => '171','ordering' => '1'),
  array('curid' => '122','ctyid' => '167','ordering' => '1'),
  array('curid' => '123','ctyid' => '174','ordering' => '1'),
  array('curid' => '124','ctyid' => '176','ordering' => '1'),
  array('curid' => '125','ctyid' => '189','ordering' => '1'),
  array('curid' => '126','ctyid' => '177','ordering' => '1'),
  array('curid' => '126','ctyid' => '209','ordering' => '1'),
  array('curid' => '127','ctyid' => '178','ordering' => '1'),
  array('curid' => '128','ctyid' => '187','ordering' => '1'),
  array('curid' => '129','ctyid' => '195','ordering' => '1'),
  array('curid' => '130','ctyid' => '190','ordering' => '1'),
  array('curid' => '131','ctyid' => '201','ordering' => '1'),
  array('curid' => '132','ctyid' => '205','ordering' => '1'),
  array('curid' => '133','ctyid' => '192','ordering' => '1'),
  array('curid' => '134','ctyid' => '179','ordering' => '1'),
  array('curid' => '136','ctyid' => '191','ordering' => '1'),
  array('curid' => '137','ctyid' => '196','ordering' => '1'),
  array('curid' => '138','ctyid' => '202','ordering' => '2'),
  array('curid' => '140','ctyid' => '64','ordering' => '1'),
  array('curid' => '141','ctyid' => '207','ordering' => '1'),
  array('curid' => '142','ctyid' => '204','ordering' => '1'),
  array('curid' => '143','ctyid' => '211','ordering' => '1'),
  array('curid' => '145','ctyid' => '219','ordering' => '1'),
  array('curid' => '146','ctyid' => '217','ordering' => '1'),
  array('curid' => '147','ctyid' => '215','ordering' => '1'),
  array('curid' => '148','ctyid' => '218','ordering' => '1'),
  array('curid' => '149','ctyid' => '216','ordering' => '1'),
  array('curid' => '150','ctyid' => '208','ordering' => '1'),
  array('curid' => '150','ctyid' => '221','ordering' => '1'),
  array('curid' => '151','ctyid' => '210','ordering' => '1'),
  array('curid' => '152','ctyid' => '223','ordering' => '1'),
  array('curid' => '153','ctyid' => '222','ordering' => '1'),
  array('curid' => '156','ctyid' => '228','ordering' => '1'),
  array('curid' => '158','ctyid' => '229','ordering' => '1'),
  array('curid' => '159','ctyid' => '231','ordering' => '1'),
  array('curid' => '160','ctyid' => '232','ordering' => '1'),
  array('curid' => '161','ctyid' => '230','ordering' => '1'),
  array('curid' => '162','ctyid' => '184','ordering' => '1'),
  array('curid' => '163','ctyid' => '37','ordering' => '1'),
  array('curid' => '163','ctyid' => '41','ordering' => '1'),
  array('curid' => '163','ctyid' => '42','ordering' => '1'),
  array('curid' => '163','ctyid' => '49','ordering' => '1'),
  array('curid' => '163','ctyid' => '53','ordering' => '1'),
  array('curid' => '163','ctyid' => '65','ordering' => '1'),
  array('curid' => '163','ctyid' => '77','ordering' => '1'),
  array('curid' => '170','ctyid' => '7','ordering' => '1'),
  array('curid' => '170','ctyid' => '9','ordering' => '1'),
  array('curid' => '170','ctyid' => '60','ordering' => '1'),
  array('curid' => '170','ctyid' => '85','ordering' => '1'),
  array('curid' => '170','ctyid' => '143','ordering' => '1'),
  array('curid' => '170','ctyid' => '180','ordering' => '1'),
  array('curid' => '170','ctyid' => '181','ordering' => '1'),
  array('curid' => '174','ctyid' => '75','ordering' => '1'),
  array('curid' => '174','ctyid' => '76','ordering' => '1'),
  array('curid' => '174','ctyid' => '152','ordering' => '1'),
  array('curid' => '174','ctyid' => '235','ordering' => '1'),
  array('curid' => '178','ctyid' => '237','ordering' => '1'),
  array('curid' => '179','ctyid' => '147','ordering' => '1'),
  array('curid' => '179','ctyid' => '197','ordering' => '1'),
  array('curid' => '180','ctyid' => '119','ordering' => '1'),
  array('curid' => '182','ctyid' => '238','ordering' => '1'),
  array('curid' => '183','ctyid' => '239','ordering' => '1')
);

	}
}