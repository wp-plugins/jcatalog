<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Comment_CorePrivacy_cmt_listing extends WListings_default{




function create() {

	$private = $this->getValue( 'private' );



	if ($private )

	        $value='<span style="color:green; font-weight:bold;">'. WText::t('1219769905FKPR').'</span>';

	    else

	        $value='<span style="color:red; font-weight:bold;">'. WText::t('1224166212FTLB').'</span>';



	    $this->content=$value;

	    $this->content .= '<br/><br/>';

	return true;

}}