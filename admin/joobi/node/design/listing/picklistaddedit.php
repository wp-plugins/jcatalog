<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'listing.textlink' );
class Design_Picklistaddedit_listing extends WListing_textlink {
function textLink() {



if ( $this->getValue( 'type' ) != 1 ) return false;

return WText::t('1357058833TGKT');

}}