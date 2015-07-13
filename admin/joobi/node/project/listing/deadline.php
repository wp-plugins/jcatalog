<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Project_CoreDeadline_listing extends WListings_default{




	function create() {

		$deadline_map=$this->mapList['enddate'];
		$deadline=$this->data->$deadline_map;

		$startdate_map=$this->mapList['startdate'];
		$startdate=$this->data->$startdate_map;

				if (!isset($deadline) || $deadline==0) {
			$this->content = '-';
			return true;
		}

				$red_date=$deadline - $startdate;
		$red_date=0.1 * $red_date; 
				$month = date("F", $deadline);
		
		$day=date("d", $deadline);
		$year=date("Y", $deadline);

				if ($deadline > time() && $deadline < time() + $red_date)
			$this->content =  '<blink><font color="red"> '.$day.' '.$month.' '.$year.'</font></blink>';

		else $this->content = $day.' '.$month.' '.$year;

	return true;

	}}