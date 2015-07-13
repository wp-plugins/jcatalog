<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

if ( !function_exists( 'WLoadFile' ) ) {
	function WLoadFile($filePath,$base=null,$expand=true,$showMessage=true) {
		return wimport( $filePath, $base, $expand, $showMessage );
	}}
WLoadFile( 'install.addon.joomla16.joomla16', JOOBI_DS_NODE );
class Install_Joomla30_addon extends Install_Joomla16_addon {

	public $apiVersion = 'joomla30';

		public $client = 0;
	public $position = 'position-7';
	public $publish = 0;
	public $access = 1;








	function addMenu($vars=null,$parent=1,$option=null) {

		if ( !isset($option) ) $option = JOOBI_MAIN_APP;

		$e = new Exception;
		if ( empty($this->parent) ) $this->parent = $parent;

		$menuM = WModel::get('joomla.menu');
		if ( $parent==1 ) {
			$menuM->returnId( true );
		}
		foreach( $vars as $k => $v ) {
			$menuM->$k = $v;
		}
				unset( $menuM->ordering );

		if ( empty($menuM->menutype) ) $menuM->menutype = 'menu';
		if ( empty($menuM->type) ) $menuM->type = 'component';
		$menuM->published = 1;
		if ( !isset($menuM->client_id) ) $menuM->client_id = 1;
		$menuM->parent_id = $this->parent;



		if ( empty($menuM->component_id) ) {
			$extensionM = WTable::get( '#__extensions', '', 'extension_id' );
			$extensionM->whereE( 'element', $menuM->title );
			$menuM->component_id = $extensionM->load( 'lr', 'extension_id' );
		}

		$menuM->img = ( empty($menuM->img) ? 'js/ThemeOffice/component.png' : $menuM->img );
		$menuM->language = '*';



				$menuCheckM = WModel::get('joomla.menu');
		$menuCheckM->whereE( 'client_id', $menuM->client_id );
		$menuCheckM->whereE( 'parent_id', $menuM->parent_id );
		$menuCheckM->whereE( 'language', $menuM->language );
		$menuCheckM->whereE( 'alias', $menuM->alias );
		$id = $menuCheckM->load( 'lr' , 'id' );

		if ( empty($id) ) {
						$status = $menuM->save();
		} else {
			$status = true;
			$menuM->id = $id;
		}

		if ( $parent ) {
			return $menuM->id;
		}
		return $status;
	}
}