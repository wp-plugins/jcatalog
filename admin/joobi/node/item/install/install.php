<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Node_install extends WInstall {

	public function install(&$object) {



				$this->_checkInstallCategory();

				if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {


									$this->_defaultimage();

			$this->_insertDefProdType();

			WText::load( 'item.node' );

			$file = JOOBI_DS_NODE . 'item' . DS . 'install' . DS . 'item.sql';
						$dbHandler = WClass::get( 'install.database' );
			$dbHandler->setResaveItemMoveFile();
			$status = $dbHandler->importFile( $file );


			$schedulerInstallC = WClass::get( 'scheduler.install' );
			$schedulerInstallC->newScheduler(
			  'item.featured.scheduler'
			, WText::t('1304253971PIKJ')
			, WText::t('1384994485EHTI')
			, 10				, 43200				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'item.unpublish.scheduler'
			, WText::t('1384994485EHTH')
			, WText::t('1384994485EHTJ')
			, 10				, 43200				, 60				, 1					);


			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'item.item'
			  , "Item's widget"
			  , WText::t('1233642085PNTA')
			, WText::t('1433381763MNWF')
			, 27				);

			$installWidgetsC->installWidgetType(
			  'item.itemcat'
			  , "Item category widget"
			  , WText::t('1380567318QTUD')
			, WText::t('1377041362DLCG')
			, 27				);


		}


		return true;


	}








	public function addExtensions() {

		$extension = new stdClass;
		$extension->namekey = 'item.search.plugin';
		$extension->name = "Joobi - Items search";
		$extension->folder = 'search';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|item|plugin';
		$extension->core = 1;
		$extension->params = 'publish=1';
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );



				$extension = new stdClass;
		$extension->namekey = 'item.item.module';
		$extension->name = "Joobi - Items";
		$extension->folder = 'item';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|item|module';
		$extension->core = 1;
		$extension->params = "publish=0\nwidgetView=item_item_module";
		$extension->description = '';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );




				$extension = new stdClass;
		$extension->namekey = 'item.itemcat.module';
		$extension->name = "Joobi - Items' categories";
		$extension->folder = 'itemcat';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|item|module';
		$extension->core = 1;
		$extension->params = "publish=0\nwidgetView=item_itemcat_module";
		$extension->description = '';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );



				$extension = new stdClass;
		$extension->namekey = 'item.dashboard.module';
		$extension->name = 'Joobi - Items';
		$extension->folder = 'item';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|item|module';
		$extension->core = 1;
		$extension->params = "position=cpanel\npublish=1\naccess=1\nclient=1\nordering=1";
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


	}





	private function _defaultimage() {

				$imageM = WModel::get( 'files' );
		$imageM->whereE( 'name', 'productx' );
		$imageID = $imageM->load( 'lr', 'filid' );

		if ( empty($imageID) ) {
						$productM = WModel::get('item.images');
			$fileLocation = JOOBI_DS_NODE .'item' . DS . 'install' . DS . 'images'.DS. 'productx.png';
			$status = $productM->saveItemMoveFile( $fileLocation, '', true, 'filid' );

			$productCatM = WModel::get('item.category');
			$productCatM->saveItemMoveFile( JOOBI_DS_NODE .'item' . DS . 'install' . DS . 'images'.DS. 'categoryx.png', '', true, 'filid' );

			$imageM->whereIn( 'name', array( 'productx', 'categoryx' ) );
			$imageM->setVal( 'core', 1 );
			$imageM->update();

		}
		return true;

	}





	private function _checkInstallCategory() {
		$prodcatM = WModel::get( 'item.category');
		$prodcatM->whereIn( 'namekey', array( 'root', 'default', 'other_vendors' ) );
		$categoryA = $prodcatM->load( 'lra', 'namekey' );

				if ( empty( $categoryA ) || !in_array( 'root', $categoryA ) ) $this->_rootCategory();
		if ( empty( $categoryA ) || !in_array( 'default', $categoryA ) ) $this->_defaultCategory();
		if ( empty( $categoryA ) || !in_array( 'other_vendors', $categoryA ) ) $this->_otherVendor();
		return true;

	}






	private function _rootCategory() {


				$prodcatM = WModel::get( 'item.category' );
		$prodcatM->noValidate();
		$prodcatM->namekey = 'root';
		$prodcatM->alias = 'root';
		$prodcatM->setChild( 'item.categorytrans', 'name', 'Home' ); 		$prodcatM->setChild( 'item.categorytrans', 'description', 'Top: root category, do not remove it!' ); 		$prodcatM->setChild( 'item.categorytrans', 'lgid', 1); 		$prodcatM->publish=1;
		$prodcatM->rgt=2;
		$prodcatM->lft=1;
		$prodcatM->parent=0;
		$prodcatM->uid=0;
				$prodcatM->params='ctygeneral=1
catcrslsorting=featured
catcrsldisplay=standard
ctyitems=1
ctysorting=ordering
ctydisplay=standard
ctylayoutcol=4
ctyshowname=1
ctyshownbitm=1
ctyshowimage=1
itmsorting=ordering
itmdisplay=standard';
		$prodcatM->save();

		return true;

	}






	private function _defaultCategory() {

				$prodcatM = WModel::get( 'item.category');
		$prodcatM->namekey = 'default';
		$prodcatM->alias = 'Default';
		$prodcatM->setChild( 'item.categorytrans', 'name', 'Default' ); 		$prodcatM->setChild( 'item.categorytrans', 'description', 'Default category for items.' ); 		$prodcatM->setChild( 'item.categorytrans', 'lgid', 1); 		$prodcatM->publish=1;
		$prodcatM->parent=1;
		$prodcatM->rolid=1;
		$prodcatM->vendid=1;
		$prodcatM->depth=1;
		$prodcatM->uid=0;
		$prodcatM->created=time();
		$prodcatM->modified=time();
		$prodcatM->save();

		return true;
	}

	




	private function _otherVendor() {

				$prodcatM = WModel::get( 'item.category');
		$prodcatM->namekey='other_vendors';
		$prodcatM->alias='Vendors Category';
		$prodcatM->setChild( 'item.categorytrans', 'name', 'Vendors' ); 		$prodcatM->setChild( 'item.categorytrans', 'description', 'Category for vendors who applied to this store.' );
		$prodcatM->setChild( 'item.categorytrans', 'lgid', 1); 		$prodcatM->publish=0;		$prodcatM->parent=1;
		$prodcatM->rolid=1;
		$prodcatM->vendid=0;
		$prodcatM->depth=1;
		$prodcatM->uid=0;
		$prodcatM->created=time();
		$prodcatM->modified=time();
		$prodcatM->save();

		return true;
	}



	private function _insertDefProdType($extra='') {
		$listOfTypeA  = array();
				$typeO = new stdClass;
		$typeO->name = 'Catalog';
		$typeO->description = 'Catalog';
		$typeO->namekey = 'catalog' . $extra;
		$typeO->rolid_edit = WRole::getRole( 'vendor' );
		$typeO->type = 100;
		$typeO->publish = 0;
		$typeO->params = 'pageprdshowimage=2
pageprdshowdefimg=2
pageprdshowpreview=2
pageprdshowintro=2
pageprdshowpromo=2
pageprdshowdesc=2
pageprdshowrating=2
pageprdshowreview=2
pageprdallowreview=2
pageprdvendor=2
pageprdvendorating=2
pageprdaskquestion=2
pageprdshowviews=2
pageprdshowlike=2
pageprdshowtweet=2
pageprdshowbuzz=2
pageprdshowsharethis=2
pageprdshowemail=2
pageprdshowfavorite=2
pageprdshowwatch=2
pageprdshowwish=2
pageprdshowlikedislike=2
pageprdshowsharewall=2
pageprdshowprint=2
termslicense=general
termsshowlicense=2
termsrefundallowed=2
termsrefund=general
termsshowrefund=2
termsshowrefundperiod=2
requiretermsatcheckout=2
bdlsorting=featured
bdldisplay=standard
bdlnbdisplay=6
prditems=1
prdtitle=1
prdsorting=rated
prddisplay=horizontal
prdnbdisplay=4
prdlayoutcol=4
prdshowname=1
prdshowintro=1
prdclimit=100
prdshowpreview=1
prdshowfree=1
prdshowrating=1
prdfeedback=1
prdreadmore=1
prdshowimage=1
pageprdshowmap=2
pageprdshowmapstreet=2
allowsyndication=0
';

		$listOfTypeA[] = $typeO;
		$prodTypeM = WModel::get( 'item.type' );
		$typeImage = 'item';
		foreach( $listOfTypeA as $oneType ) {

			$prodTypeM->whereE( 'namekey', $oneType->namekey );
			$exist = $prodTypeM->exist();
			if ( $exist ) continue;

									$prodTypeM->setChild( 'item.typetrans', 'name', $oneType->name );
			$prodTypeM->setChild( 'item.typetrans', 'description', $oneType->description );
			$prodTypeM->namekey = $oneType->namekey;
			$prodTypeM->type = $oneType->type;
			$prodTypeM->publish = $oneType->publish;
			$prodTypeM->params = $oneType->params;
			$prodTypeM->core = 1;
			$prodTypeM->vendid = 0;
			$prodTypeM->saveItemMoveFile( JOOBI_DS_NODE . $typeImage .DS. 'install' .DS. 'images' .DS. $typeImage . 'typex.png' );

		}		return true;

	}


}