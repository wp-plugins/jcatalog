<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<div>

	<div style="float:left;width:49%;">

		<div style="clear:both;padding-bottom:20px;">

			<?php echo $this->getContent( 'image' ); ?>

		</div>

		

		<div style="clear:both;padding-top: 40px;">

			<?php echo $this->getContent( 'tab' ); ?>

		</div>

	</div>

	

	<div style="float:right;width:49%;">

		<div style="clear:both;">

			<?php echo $this->getContent( 'status' ); ?>

		</div>

		

		<div style="clear:both;">

			<?php echo $this->getContent( 'info' ); ?>

		</div>

	</div>

</div>