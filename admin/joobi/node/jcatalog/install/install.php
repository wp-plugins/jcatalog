<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Jcatalog_Application_install {




	public function install(&$object) {


		if ( !empty( $this->newInstall ) || ( property_exists( $object, 'newInstall') && $object->newInstall ) ) {
									$link = 'controller=catalog';
			WApplication::createMenu( 'Catalog', 'mainmenu', $link, 'jcatalog', 0, 1, 1, '0', 'frontmenu' );
			WApplication::createMenu( 'Catalog', 'top', $link, 'jcatalog', 0, 1, 1, '0', 'frontmenu' );

						$link = 'controller=wishlist-my';
			WApplication::createMenu( 'My Lists', 'usermenu', $link, 'jcatalog', 0, 1, 1, '0', 'frontmenu' );
			$link = 'controller=vendor-inbox';
			WApplication::createMenu( 'My Inbox', 'usermenu', $link, 'jcatalog', 0, 1, 1, '0', 'frontmenu' );


			$this->_makeNewType( 'item_vehicle', 'Cars & Vehicles', 'Directory of vehicles' );

			$this->_makeNewType( 'item_realestate', 'Real Estate', 'Directory of real estate & properties' );

			$this->_makeNewType( 'item_restaurant', 'Restaurant', 'Directory of restaurants' );

			$this->_makeNewType( 'item_job', 'Jobs', "Directory of job's offers" );

						$itemTypeM = WModel::get( 'item.type' );
			$itemTypeM->whereE( 'namekey', 'catalog' );
			$itemTypeM->setVal( 'publish', 1 );
			$itemTypeM->update();
		}

	}






	private function _makeNewType($namekey,$name,$description) {


		$listOfTypeA  = array();
				$typeO = new stdClass;
		$typeO->name = $name;
		$typeO->description = $description;
		$typeO->namekey = $namekey;
		$typeO->rolid_edit = WRole::getRole( 'vendor' );
		$typeO->type = 100;
		$typeO->publish = 1;
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
pageprdshowmap=2
pageprdshowmapstreet=2
termslicense=general
termsshowlicense=2
termsrefundallowed=2
termsrefund=general
termsshowrefund=2
termsshowrefundperiod=2
requiretermsatcheckout=2
pageprdshowmap=2
pageprdshowmapstreet=2
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
allowsyndication=0
';

		$listOfTypeA[] = $typeO;

		$prodTypeM = WModel::get( 'item.type' );

		foreach( $listOfTypeA as $oneType ) {

			$prodTypeM->whereE( 'namekey', $oneType->namekey );
			$exist = $prodTypeM->exist();
			if ( $exist ) continue;


			$prodTypeM->prodtypid = null;
						$prodTypeM->setChild( 'item.typetrans', 'name', $oneType->name );
			$prodTypeM->setChild( 'item.typetrans', 'description', $oneType->description );
			$prodTypeM->namekey = $oneType->namekey;
			$prodTypeM->type = $oneType->type;
			$prodTypeM->publish = $oneType->publish;
			$prodTypeM->params = $oneType->params;
			$prodTypeM->core = 0;
			$prodTypeM->vendid = 0;
			$prodTypeM->save();

		}		return true;



	}


}