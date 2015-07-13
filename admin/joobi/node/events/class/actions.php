<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Events_Actions_class extends WClasses {














public function loadData($acttyid,$return='data'){

	static $typeInfoO=array();

	if( empty( $acttyid )) return null;



	if( !isset($typeInfoO[$acttyid])){


		$itemTypeM=WModel::get( 'events.actionstype' );




		if( is_numeric($acttyid)){

			$itemTypeM->whereE( 'acttyid', $acttyid );

		}else{

			$itemTypeM->whereE( 'namekey', $acttyid );

		}


		$result=$itemTypeM->load( 'o' );



		
		if( empty($result)) $typeInfoO[$acttyid]=false;

		else {

			$typeInfoO[$acttyid]=$result;

		}
	}

	if( $return=='data'){

		
		return $typeInfoO[$acttyid];



	}elseif( isset($typeInfoO[$acttyid]->$return)){

		return $typeInfoO[$acttyid]->$return;

	}else{

		return null;

	}


}}