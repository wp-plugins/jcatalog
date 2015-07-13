<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Translation_Source_picklist extends WPicklist {








function create(){



$translationM=WModel::get('translation.source');

$translationM->select('name');
$translationM->setLimit( 500 );


$translation=$translationM->load('ol',array('srtrid','name'));

$this->addElement('0','- - please select a source - -');


if(empty($translation)) return true;



foreach($translation as $source)

{

$this->addElement($source->srtrid,$source->name);

}





return true;



}



































}