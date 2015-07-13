<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Project_CoreEstimatedtimeoverlay_listing extends WListings_default{




	function create() {

				$estimatedtime_map=$this->mapList['estimatedtime'];
		$estimatedtime=$this->data->$estimatedtime_map;

				$projectM=WModel::get('project');
		$children=$projectM->getChildNode($this->value); 
		$toultip=''; 
				if (!empty($children)) {
			foreach($children as $child) {
								$sql=WModel::get('project');
				$sql->makeLJ('projecttrans', 'pjid');
				$sql->select('name',1);
				$sql->select('estimatedtime',0);
				$sql->whereE('pjid', $child);
				$project=$sql->load('o');

								if ($project->estimatedtime <= 1) {
					$toultip.=$project->name.' : '.$project->estimatedtime.' '.WText::t('1215507788CYDE').'<br>';
				}
				else {
					$toultip.=$project->name.' : '.$project->estimatedtime.' '.WText::t('1215507788CYDF').'<br>';
				}

								$sql=WModel::get('task');
				$sql->select('name');
				$sql->select('estimatedtime', 0);
				$sql->whereE('pjid', $child);
				$tasks=$sql->load('ol');

				if (!empty($tasks)) {
					foreach($tasks as $task) {
						if ($task->estimatedtime <= 1) {
							$toultip.='&nbsp; L  '.$task->name.' : '.$task->estimatedtime.' '.WText::t('1215507788CYDE').'<br>';
						}
						else {
							$toultip.='&nbsp; L  '.$task->name.' : '.$task->estimatedtime.' '.WText::t('1215507788CYDF').'<br>';
						}
					}
				}

				$toultip.='<br>';

			}
			$this->toultip = $toultip;
			$this->title = 'Subprojects:';
			if ($estimatedtime <= 1) {
				$this->text='<font color="blue">'.$estimatedtime.' '.WText::t('1215507788CYDE').'</font>';
			}
			else {
				$this->text='<font color="blue">'.$estimatedtime.' '.WText::t('1215507788CYDF').'</font>';
			}

		}
				else {
			$this->toultip = '';
			$this->title = '';
			if ($estimatedtime == 0) {
				$this->text='-';
			}
			elseif ($estimatedtime == 1) {
				$this->text=$estimatedtime.' '.WText::t('1215507788CYDE');
			}
			else {
				$this->text=$estimatedtime.' '.WText::t('1215507788CYDF');
			}
		}

	return true;



	}}