<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Currency_Accepted_picklist extends WPicklist {










function create() {



	$sql = WModel::get( 'currency');

	$sql->whereE('accepted', 1);

	$sql->whereE('publish', 1);

	$curNames = $sql->load('ol', array( 'curid', 'title', 'symbol' ) );

	

	if (!empty($curNames)) 

	{

		if ( !empty( $curNames ) )

		{

			foreach( $curNames as $curName )

			{

				$this->addElement( $curName->curid, $curName->title .' ('. $curName->symbol .')' );

			}
		}
	}


}









}