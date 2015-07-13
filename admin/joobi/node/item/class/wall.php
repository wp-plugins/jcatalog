<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Item_Wall_class extends WClasses {


	private $instance = null;

	private $installed = false;






	function __construct() {

		$social = WPref::load( 'PCATALOG_NODE_SOCIALECOMMERCE' );
		if ( empty($social) ) return false;


				$this->instance = WClass::get( $social . 'wall', null, 'class', false );

				if ( !empty( $this->instance ) ) $this->installed = $this->instance->checkInstalled();

	}




	public function available() {
		return $this->installed;
	}










	public function postWall($post=null) {

		if ( ! $this->installed || empty($this->instance) ) return false;

				if ( !empty($post->callingFunction) ) {
			$pref = 'PCATALOG_NODE_' . strtoupper( $post->callingFunction );

			$val = WPref::load( $pref );
			if ( empty($val) ) return false;

		}


		return $this->instance->postWall( $post );

	}


}