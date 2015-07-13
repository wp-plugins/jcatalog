<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Item_Search_plugin extends WPlugin {





	function onContentSearchAreas() {
		return $this->onSearchAreas();
	}





	function onContentSearch($text,$phrase='',$ordering='',$areas=null) {
		return $this->onSearch( $text, $phrase, $ordering, $areas );
	}




	function onSearchAreas() {
		static $areas = array();
		WText::load( 'item.node' );
		if (empty($areas)) $areas['items'] = WText::t('1233642085PNTA');

		return $areas;

	}










	function onSearch($text,$phrase='',$ordering='',$areas=null) {

		if (is_array( $areas )) {
			if (!in_array('items' ,$areas )) {
				return array();
			}
		}

		WText::load( 'item.node' );
				$limit = ( isset($this->search_limit) ) ? $this->search_limit : 10;

				$itemId = ( isset($this->itemid) ) ? (int)$this->itemid : 1;

		$text = trim( $text );
		if ( $text == '' ) return array();

		switch ( $ordering ) {
			case 'alpha':
				$order['field'] = 'name';
				$order['ordering'] = 'ASC';
				$order['as'] = '1';
				break;
			case 'newest':
				$order['field'] = 'modified';
				$order['ordering'] = 'DESC';
				$order['as'] = '0';
				break;
			case 'oldest':
				$order['field'] = 'created';
				$order['ordering'] = 'ASC';
				$order['as'] = '0';
				break;
			case 'category':
			case 'popular':
			default:
				$order['field'] = 'name';
				$order['ordering'] = 'DESC';
				$order['as'] = '1';
				break;
		}
		
		$itemM=WModel::get('item');
		$itemM->select('pid');
		$itemM->select('created');
		$itemM->whereE('publish','1');
		$itemM->makeLJ('itemtrans','pid');
		$itemM->select('name',1,'title');
		$itemM->select('description',1);
		$itemM->select('introduction',1);
		$itemM->where('name','LIKE','%'.$text.'%',1);
		$itemM->where('namekey', 'LIKE','%'.$text.'%', 0 ,null ,0 ,0 ,1 );
		$itemM->where('description','LIKE','%'.$text.'%',1 ,null ,0 ,0 ,1 );
		$itemM->where('introduction','LIKE','%'.$text.'%',1 ,null ,0 ,0 ,1 );
		$itemM->orderBy( $order['field'], $order['ordering'], $order['as'] );
		$itemM->groupBy( 'pid' );
		$itemM->setLimit($limit);

					$itemM->checkAccess();
		$rows = $itemM->load('ol');





		$myTagO = new stdClass;

		switch ( $ordering ) {
			case 'alpha':
				$myTagO->sorting = 'alphabetic';
				break;
			case 'newest':
				$myTagO->sorting = 'newest';
				break;
			case 'oldest':
				$myTagO->sorting = 'oldest';
				break;
			case 'popular':
				$myTagO->sorting = 'hits';
				break;
			case 'category':
			default:
				$myTagO->sorting = 'alphabetic';
				break;
		}
		$myTagO->nb = $limit;
		$myTagO->search = $text;
		$myTagO->showIntro = true;
		$myTagO->showDesc = true;

		$productLoadC = WClass::get( 'item.load' );
		$outputThemeC = WClass::get( 'output.theme' );
		$outputThemeC->nodeName = 'catalog';
		$outputThemeC->header = $productLoadC->setHeader();
		$productA = $productLoadC->get( $myTagO );
		$itemResultA = array();

				if ( !empty($productA) ) {

			$productLoadC->extraProcess( $productA, $myTagO );
			$outputThemeC->createLayout( $productA, $myTagO );


			foreach( $productA as $oneItem ) {

				$item = new stdClass;
				$item->title = $oneItem->name;
				$item->created = $oneItem->created;
				$item->slug = $oneItem->namekey;
				$item->image = $oneItem->thumbnailPath;

				$text = '';
				if ( !empty( $oneItem->introduction ) ) $text .= '<br>' . $oneItem->introduction;
				if ( !empty( $oneItem->description ) ) {
					if ( !empty( $oneItem->introduction ) ) $text .= '<br>';
					$text .= $oneItem->description;
				}
				$item->text = $text;

				$item->section = 'Items';
				$item->href = WPage::routeURL( 'controller=catalog&task=show&&eid='. $oneItem->pid, '', false, false, $itemId );
				$item->browsernav=1;

				$itemResultA[] = $item;
			}		}

		
		$itemCategoryM=WModel::get('item.category');
		$itemCategoryM->select('namekey');
		$itemCategoryM->makeLJ('item.categorytrans','catid');
		$itemCategoryM->select('name',1,'title');
		$itemCategoryM->select('description',1,'text');
		$itemCategoryM->select('created');
		$itemCategoryM->select('catid');
		$itemCategoryM->where('name','LIKE','%'.$text.'%',1);
		$itemCategoryM->where('description','LIKE','%'.$text.'%',1, null,0 ,0 ,1);
		$itemCategoryM->whereE('publish','1');
		$itemCategoryM->orderBy( $order['field'], $order['ordering'], $order['as'] );
		$itemCategoryM->groupBy( 'catid' );
		$itemCategoryM->setLimit($limit);

					$itemCategoryM->checkAccess();
			$rows2 = $itemCategoryM->load('ol');

		$count = count( $rows2 );
		for ( $i = 0; $i < $count; $i++ ) {
			$rows2[$i]->created = WApplication::date( WTools::dateFormat( 'date-time-short' ), $rows2[$i]->created + WUser::timezone() );
			$rows2[$i]->section = 'Categories';
			$rows2[$i]->href = WPage::routeURL( 'controller=item-category&task=show&catid='. $rows2[$i]->catid, '', false, false, $itemId );
			$rows2[$i]->browsernav=1;
			if ($rows2[$i]->namekey=='root') unset($rows2[$i]);
		}
		return array_merge( $itemResultA, $rows2 );

	}
}