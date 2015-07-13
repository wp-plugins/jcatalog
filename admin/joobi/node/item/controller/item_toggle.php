<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_toggle_controller extends WController {

	function toggle() {

				$pid = WGlobals::getEID();


		$property = $this->getToggleValue( 'map' );
		$value = $this->getToggleValue( 'value' );

		$allowOnlyPublish = false;
		if ( WRoles::isNotAdmin( 'storemanager' ) && WExtension::exist( 'vendors.node' ) ) {
						$roleHelper = WRole::get();
			$storeManagerRole = WRole::hasRole( 'storemanager' );
			if ( !$storeManagerRole ) {
										$roleHelper = WRole::get();
					if ( WRole::hasRole( 'vendor' ) ) {
						$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
						$uid = WUser::get('uid');
						$this->_vendid = $vendorHelperC->getVendorID( $uid );

						if ( !empty($this->_vendid) ) {
							$allowOnlyPublish = true;
														$itemM = WModel::get( 'item' );
							$itemM->whereE( 'pid', $pid );
							$itemM->whereE( 'vendid', $this->_vendid );
							if ( !$itemM->exist() ) {
								return false;
							}						} else {
							return false;
						}					} else {
						return false;
					}
					
			}
		} else {
			$allowOnlyPublish = false;
		}

		
		if ( $allowOnlyPublish ) {



			if ( $property == 'featured' ) {
				$status = $this->_vendorFeatured( $pid, $value );
				if ( empty($status) ) return true;
			} elseif ( $property == 'publish' ) {


											
					if ( ! WPref::load( 'PVENDORS_NODE_PRODNOBLOCK' )  ) {

						$unpublishApprove = WPref::load( 'PVENDORS_NODE_UNPUBLISHAPPROVE' );
						$publishApprove = WPref::load( 'PVENDORS_NODE_PUBLISHAPPROVE' );


						if ( $value == 0 && $unpublishApprove ) {
														$message = WMessage::get();
							$message->userN('1342574026QQWP');
							$itemApprovalC = WClass::get( 'item.approval' );
							$itemApprovalC->emailRequestApproval( $pid, 'admin_unpublish_approval' );
							$controller = WGlobals::get( 'controller' );
							WPages::redirect( 'controller=' . $controller );
							return true;
						}
						if ( $value == 1 && $publishApprove ) {
														$message = WMessage::get();
							$message->userN('1342574026QQWP');
							$itemApprovalC = WClass::get( 'item.approval' );
							$itemApprovalC->emailRequestApproval( $pid, 'admin_publish_approval' );
							$controller = WGlobals::get( 'controller' );
							WPages::redirect( 'controller=' . $controller );
							return true;
						}
					}


					} else {
				return false;
			}

		}

		$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );

				if ( $integrate && WExtension::exist( 'subscription.node' ) ) {
			$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );
			if ( $value == 0) $subscriptionCatalogrestrictionC->itemUnPublished();
			else if ( $value == 1) $subscriptionCatalogrestrictionC->itemPublished();
		}


		return parent::toggle();



	}






	private function _vendorFeatured($pid,$value) {


		if ( ( WRoles::isAdmin( 'storemanager' ) ) || $value == 0 ) return true;

		$roleHelper = WRole::get();
		$storeManagerRole = WRole::hasRole( 'storemanager' );
		if ( $storeManagerRole ) return true;

		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
		$uid = WUser::get('uid');
		$this->_vendid = $vendorHelperC->getVendorID( $uid );

				$itemM = WModel::get( 'item' );
		$itemM->whereE( 'featured', 1 );
		$itemM->whereE( 'vendid', $this->_vendid );
		$total = $itemM->total();

		$MAXNUMBER = WPref::load( 'PVENDORS_NODE_FEATUREDMAX' );
		if ( $total >= $MAXNUMBER ) {
			$message = WMessage::get();
			$message->userW('1385002290HBQV',array('$MAXNUMBER'=>$MAXNUMBER));
			return false;
		}
		$itemM = WModel::get( 'item' );
		$itemM->whereE( 'vendid', $this->_vendid );
		$itemM->whereE( 'pid', $pid );
		$itemM->setVal( 'featuredate', time() );
		$itemM->update();

		return true;
	}
}