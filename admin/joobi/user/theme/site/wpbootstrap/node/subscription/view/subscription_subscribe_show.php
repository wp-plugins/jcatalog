<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....'); ?>
<table class="joobiform">

	<tr>



		<td width="10%" valign="top">

			{widget:area|name="image"}

		</td>

		<td width="70%" valign="top">

            <table>

				<tr>

					<td style="font-size:20px;">{widget:area|name=general}</td>

				</tr>

				<tr>

					<td>{widget:area|name=options}</td>

				</tr>

            </table> 

		</td>

	</tr>

</table>