<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Mailbox_plugin_assign_controller extends WController {








	function assign() {





		$inbid = WGlobals::get('inbid'); 
		$wid = WGlobals::get('wid' );   
		$titleheader = WGlobals::get( 'titleheader' );


		if ( empty($inbid) || empty($wid) ) return false;



		$widgetM = WModel::get( 'mailbox.email' );
		$widgetM->rememberQuery( true, 'Mailbox_node' );

		$widgetM->select( array( 'inbid', 'wid' ) );

	    $widgetM->whereE( 'inbid', $inbid );

		$widgetM->whereE( 'wid', $wid );

		$widget = $widgetM->load( 'o' );




	       if ( empty($widget) ) {

			$widgetM->setVal('inbid',$inbid);

			$widgetM->setVal('wid',$wid);

		 	$status = $widgetM->insert();          
	       } else {

	 		$widgetM->whereE('inbid',$inbid);

			$widgetM->whereE('wid',$wid);

			$status = $widgetM->delete();        
	       }

	       WPages::redirect( 'controller=mailbox-plugin&task=listing&inbid=' . $inbid. '&titleheader=' . $titleheader );

	       return true;



	}}