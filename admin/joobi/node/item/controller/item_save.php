<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Save_controller extends WController {

	function save() {

		$status = parent::save();

		if ( !$status ) return $status;

		if ( empty($this->_model->numcat) ) {

			$name = $this->_model->getChild( $this->_model->getModelNamekey() . 'trans', 'name' );

			$this->userN('1338404830HCNT');

			WPages::redirect( 'controller=item-category-assign&task=listing&pid=' . $this->_model->pid.'&prodtypid=' . $this->_model->prodtypid . '&titleheader='. $name );

		}
		return $status;

	}
}