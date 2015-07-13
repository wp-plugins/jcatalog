<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Ticket_Search_plugin extends WPlugin {





	function onContentSearchAreas() {
		return $this->onSearchAreas();
	}





	function onContentSearch($text,$phrase='',$ordering='',$areas=null) {
		return $this->onSearch( $text, $phrase, $ordering, $areas );
	}


	





	function onSearchAreas() {

		static $areas = array();

		WText::load( 'item.node' );

		if (empty($areas)) $areas['tickets'] = WText::t('1206964235BPWJ');



		return $areas;

	}



	function onSearch($text,$phrase='',$ordering='',$areas=null) {


		if (is_array( $areas )) {

			if (!in_array('tickets' ,$areas )) {

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
				$order['field'] = 'created';
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



		
		$uid = WUser::get('uid');

		$ticketsnode=WModel::get('ticket');

		$ticketsnode->select('created');

		$ticketsnode->select('tkid');

		$ticketsnode->where('status','>',0);

		$ticketsnode->makeLJ('tickettrans','tkid');

		$ticketsnode->select('name',1,'title');

		$ticketsnode->select('description',1,'text');

		$ticketsnode->where('namekey','LIKE','%'.$text.'%',0, null, 1);
		$ticketsnode->where('name','LIKE','%'.$text.'%',1  ,null ,0 ,0 , 1 );
		$ticketsnode->where('description','LIKE ','%'.$text.'%',1 ,null, 0 ,1 ,1 );
		$ticketsnode->groupBy( 'tkid' );

		$ticketLevel = WExtension::get( 'jtickets.application', 'level');
		if ( $ticketLevel > 1) {
						$ticketsnode->whereE( 'private', 0, 0, null, 1, 0, 0 );
			$ticketsnode->whereE( 'authoruid', $uid, 0, null, 1, 0, 1 );
			$ticketsnode->whereE( 'private', 1, 0, null, 0, 2, 0 );
		}
		$ticketsnode->orderBy( $order['field'], $order['ordering'], $order['as'] );

		$ticketsnode->setLimit($limit);


		$rows = $ticketsnode->load('ol');



		$count = count( $rows );
		$alreadyUsed = array();

		for ( $i = 0; $i < $count; $i++ ) {

			$rows[$i]->created = WApplication::date( WTools::dateFormat( 'date-time-short' ), $rows[$i]->created + WUser::timezone() );
			$rows[$i]->section = 'jTickets';

			$rows[$i]->href = WPage::routeURL( 'controller=ticket-reply&tkid='. $rows[$i]->tkid, '', false, false, $itemId );
			$rows[$i]->browsernav=1;
			$alreadyUsed[] = $rows[$i]->tkid;

		}



		

		$ticketsreply = WModel::get('ticket.reply');

		$ticketsreply->select('tkid');

		$ticketsreply->select('modified',0,'created');

		$ticketsreply->makeLJ('ticket.replytrans','tkrid','tkrid');

		$ticketsreply->select('description',1,'text');

		$ticketsreply->where('description','LIKE','%'.$text.'%',1,null,null,null,1);

		$ticketsreply->makeLJ('ticket','tkid', 'tkid', 0, 3);
		$ticketsreply->makeLJ('tickettrans','tkid', 'tkid', 3, 4 );

		if ( $ticketLevel > 1) {
						$ticketsreply->whereE( 'private', 0, 3, null, 1, 0, 0 );
			$ticketsreply->whereE( 'authoruid', $uid, 3, null, 1, 0, 1 );
			$ticketsreply->whereE( 'private', 1, 3, null, 0, 2, 0 );
		}
				if ( !empty($alreadyUsed) ) $ticketsreply->whereIn( 'tkid', $alreadyUsed, 0, true );
		$ticketsreply->select('name',4,'title');

		$ticketsreply->setLimit($limit);
		$ticketsreply->groupBy( 'tkid', 3 );


		$ticketsreply->orderBy( $order['field'], $order['ordering'], $order['as']+3 );
		$rows2 = $ticketsreply->load('ol');



		$count = count( $rows2 );

		for ( $i = 0; $i < $count; $i++ ) {
						$rows2[$i]->created = WApplication::date( WTools::dateFormat( 'date-time-short' ), $rows2[$i]->created + WUser::timezone() );
			$rows2[$i]->section = 'jTickets reply';

			$rows2[$i]->href = WPage::routeURL( 'controller=ticket-reply&tkid='. $rows2[$i]->tkid, '', false, false, $itemId );
			$rows2[$i]->browsernav=1;

		}


		return array_merge($rows, $rows2);

	}


}