<?php 

* @link joobi.co
* @license GNU GPLv3 */


WView::includeElement( 'listing.textlink' );
class Design_Picklistaddedit_listing extends WListing_textlink {
function textLink() {



if ( $this->getValue( 'type' ) != 1 ) return false;

return WText::t('1357058833TGKT');

}}