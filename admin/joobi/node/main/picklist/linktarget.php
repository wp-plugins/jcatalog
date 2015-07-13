<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Linktarget_picklist extends WPicklist {
function create() {



$this->addElement( '', WText::t('1356733766RKBF') );	
$this->addElement( '_blank', WText::t('1356733767TFPZ') );

$this->addElement( '_parent', WText::t('1356733767TFQA') );

$this->addElement( '_self', WText::t('1356733767TFQB') );



return true;



}}