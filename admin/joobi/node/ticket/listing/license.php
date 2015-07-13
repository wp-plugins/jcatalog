<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreLicense_listing extends WListings_default{


	function create() {


		if ( empty($this->value) ) return false;

				$licenseM = WModel::get( 'license' );
		$licenseM->makeLJ( 'license.sites', 'lcid' );
		$licenseM->whereE( 'stid', $this->value, 1 );
		$licenseM->whereE( 'premium', 1, 1 );
		$licenseM->select( '*', 0 );
		$licenseO = $licenseM->load( 'o' );

		if ( empty($licenseO) ) return false;

		$color = ( strtotime($licenseO->maintenance) < time() ? 'green' : 'red' );

		$clubsubtypeT = WType::get( 'license.clubsubtype' );

		$this->content = '<span style="font-weight:bold;">';
		$this->content .= WText::t('1389879775LPOL') . ': ';
		$this->content .= $clubsubtypeT->getName( $licenseO->subtype );
		$this->content .= '</span>';
		$this->content .= '<span style="color:' . $color . ';">';

		$this->content .= '<br />' . WText::t('1231158811CQTV') . ': ';
		$this->content .= WApplication::date( WTools::dateFormat( 'date' ), $licenseO->maintenance );
		$this->content .= '</span>';
		$this->content .= '<br />' . WText::t('1391514079NAKA') . ': ';
		$this->content .= WPage::createPopUpLink( WPage::link( 'controller=license&task=listing&search=' . $licenseO->token ), $licenseO->token, '90%', '90%' );


		return true;



	}
}