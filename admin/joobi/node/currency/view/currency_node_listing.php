<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Currency_Currency_node_listing_view extends Output_Listings_class {
function prepareView() {



		if ( ! WPref::load('PCURRENCY_NODE_MULTICUR') ) $this->removeElements( array( 'currencies_node_listing_rates', 'currencies_node_listing_accepted', 'currencies_node_listing_ordering' ) );



		return true;



	}}