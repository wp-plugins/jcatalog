<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Main_Linktarget_picklist extends WPicklist {
function create() {



$this->addElement( '', WText::t('1356733766RKBF') );	
$this->addElement( '_blank', WText::t('1356733767TFPZ') );

$this->addElement( '_parent', WText::t('1356733767TFQA') );

$this->addElement( '_self', WText::t('1356733767TFQB') );



return true;



}}