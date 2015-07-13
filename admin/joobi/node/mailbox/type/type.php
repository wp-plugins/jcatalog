<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_Type_type extends WTypes {
var $type = array(
1 =>'undefined',
2 =>'unknown',
5 =>'bounce',
10 =>'Autoreply',
15 =>'Require Confirmation',
20=>'Successfully Received',
25 =>'Replies',
30=>'Do Not Reply',
35 =>'Email Added To',
40 =>'Email Address Changed'
);
}