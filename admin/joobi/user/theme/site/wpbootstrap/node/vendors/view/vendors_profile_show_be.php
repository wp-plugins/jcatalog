<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<div class="profile-left" style="float:left;">

<?php echo $this->getContent( 'left' ); ?>

</div>

<div class="profile-right">

<?php echo $this->getContent( 'right' ); ?>

</div>

<div class="clr"></div>

<div class="profile-bottom" style="margin-top: 20px;">

<?php echo $this->getContent( 'middle' ); ?>

</div>

<div class="clr"></div>

<div class="profile-description">

<?php echo $this->getContent( 'description' ); ?>

</div>

<div class="clr"></div>

<div class="profile-bottom" style="margin-top: 20px;">

<?php echo $this->getContent( 'bottom' ); ?>

</div>

<div class="clr"></div>

<div class="profile-comment" style="margin-top: 20px;">

<?php echo $this->getContent( 'comment' ); ?>

</div>