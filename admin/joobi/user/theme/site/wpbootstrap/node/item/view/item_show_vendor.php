<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<table style="width:100%;">

<tr>

<td style="width:25%;" valign="top"> <?php echo $this->getContent( 'image' ); ?> </td>

<td style="width:30%;" valign="top"> <?php echo $this->getContent( 'info' ); ?> </td>

<td style="width:45%;" valign="top"> <?php echo $this->getContent( 'status' ); ?> </td>

</tr>

<tr>

<td colspan="2" style="width:50%;"> <?php echo $this->getContent( 'description' ); ?> </td>

<td style="width:50%;"> <?php echo $this->getContent( 'tab' ); ?> </td>

</tr>

<tr>

<td colspan="3"> <?php echo $this->getContent( 'comment' ); ?> </td>

</tr>

</table>