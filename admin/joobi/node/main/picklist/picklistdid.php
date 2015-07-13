<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Picklistdid_picklist extends WPicklist {

	function create() {



		$this->addElement( 0, ' - Select a Pick-list - ' );



		$picklistM = WModel::get( 'design.picklist' );
		$picklistM->makeLJ( 'design.picklisttrans' , 'did' );

		$picklistM->whereLanguage();

		$picklistM->select( 'name', 1 );


		$picklistM->orderBy( 'core', 0 );
		$picklistM->orderBy( 'name', 'ASC', 1 );

		$allPicklistA = $picklistM->load( 'ol', array( 'did', 'core' ) );



		if ( !empty( $allPicklistA ) ) {

			$core = 0;

			foreach( $allPicklistA as $onePciklist ) {

				if ( $onePciklist->core != $core ) {

					$this->addElement( '-a', ' - ' . WText::t('1360922681PNPQ') . ' - ' );

					$core = 1;

				}
				if ( !empty($onePciklist->name) ) $this->addElement( $onePciklist->did, $onePciklist->name );


			}
		}


		return true;



	}}