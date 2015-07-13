<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





































class Scheduler_Cronparser_class extends WClasses {


 	var $bits=array();  	var $lastRun; 		









 	function checkCron($cron,$display_messages=true){
 		$this->bits=@explode(" ", $cron);
 		$message=WMessage::get();

				if(count($this->bits) !=5){
			if($display_messages) $message->userW('1217586755TDUY');
			return false;
		}

				if($this->bits[2]!='*' && $this->bits[4]!='*'){
			if($display_messages) $message->userW('1217586755TDUZ');
			return false;
		}

				$types=array("minute", "hour", "day", "month", "weekday");
		$i=0;

				foreach($this->bits as $element){

			switch($this->getCase($element)){


								case 6:

					$number=$types[$i];
					$message->userW('1217587982LBWO',array('$number'=>$number));
					$message->userW('1217587982LBWP',array('$element'=>$element));
					return false;
					break;


								case 2:
					$exploded=explode("/", $element);
										if($exploded[0] !='*'){

						$number=$types[$i];
						$message->userW('1217587982LBWO',array('$number'=>$number));
						$message->userW('1217587982LBWQ');
						return false;
					}

															if(!is_numeric($exploded[1]) || $exploded[1] <=0){

						$number=$types[$i];
						$message->userW('1217587982LBWO',array('$number'=>$number));

						$number=$exploded[1];
						$message->userW('1217587982LBWR',array('$number'=>$number));
						return false;
					}

					break;


								case 3:
					$exploded=explode(",", $element);
					$type_array=$this->getTypeArray($types[$i]);
					$duplicates=array();

										foreach($exploded as $comma_element){

												if(strstr($comma_element,  "-")!=false){
							$exploded_range=explode("-", $comma_element);

														if($exploded_range[1] <=$exploded_range[0]){

								$number=$types[$i];
								$message->userW('1217587982LBWS',array('$number'=>$number));
								$message->userW('1217587982LBWT',array('$comma_element'=>$comma_element));
								return false;
							}

														foreach($exploded_range as $range_element){
								if(!is_numeric($range_element) || !in_array($range_element, $this->getTypeArray($types[$i]))){
									$number=$types[$i];

									$message->userW('1217587982LBWS',array('$number'=>$number));

									$start=$type_array[0];

									$end=end($type_array);
									$message->userW('1217587983MLGY',array('$range_element'=>$range_element,'$start'=>$start,'$end'=>$end));
									return false;
								}
							}
														for($j=$exploded_range[0]; $j<=$exploded_range[1]; $j++){
								$duplicates[]=$j;
							}

						}
												else {
							if(!is_numeric($comma_element) || !in_array($comma_element, $this->getTypeArray($types[$i]))){
								$number=$types[$i];

								$message->userW('1217587982LBWS',array('$number'=>$number));
								$start=$type_array[0];

								$end=end($type_array);

								$message->userW('1217587983MLGZ',array('$comma_element'=>$comma_element,'$start'=>$start,'$end'=>$end));
								return false;
							}

														$duplicates[]=$comma_element;


						}					}
										$modified_array=array_unique($duplicates);
										if($modified_array !=$duplicates){

							$number=$types[$i];
							$message->userW('1217587982LBWS',array('$number'=>$number));
							$message->userW('1217587983MLHA',array('$element'=>$element));
							return false;
					}

					break;


								case 4:
					$exploded=explode("-", $element);

										if($exploded[1] <=$exploded[0]){

						$number=$types[$i];
						$message->userW('1217587982LBWS',array('$number'=>$number));

						$start=$exploded[1];

						$end=$exploded[0];
						$message->userW('1217587983MLHB',array('$element'=>$element,'$start'=>$start,'$end'=>$end));
						return false;
					}
										$type_array=$this->getTypeArray($types[$i]);
					foreach($exploded as $range_element){
						if(!is_numeric($range_element) || !in_array($range_element, $type_array)){

							$number=$types[$i];
							$message->userW('1217587982LBWS',array('$number'=>$number));

							$start=$type_array[0];

							$end=end($type_array);
							$message->userW('1217587983MLGY',array('$range_element'=>$range_element,'$start'=>$start,'$end'=>$end));
							return false;
						}					}
					break;


								case 5:
										$type_array=$this->getTypeArray($types[$i]);

					if(!is_numeric($element) || !in_array($element, $type_array)){

						$number=$types[$i];
						$message->userW('1217587982LBWS',array('$number'=>$number));

						$start=$type_array[0];

						$end=end($type_array);
						$message->userW('1217587983MLHC',array('$element'=>$element,'$start'=>$start,'$end'=>$end));
						return false;
					}

					break;

			}
			$i++;
		}

		
		return true;

 	}





	function calcNextRun($cron){
				$this->bits=@explode(" ", $cron);

		

		
		if(count($this->bits) !=5) return $this->lastRun;

		   		$year_now=date("Y",$this->lastRun);   		$month_now=date("n",$this->lastRun);   		$day_now=date("j",$this->lastRun);   		$weekday_now=date("w",$this->lastRun);   		$hour_now=date("G",$this->lastRun);   		$minute_now=date("i",$this->lastRun);
   		   		$compute_minute=true;
   		$compute_hour=true;
   		$compute_day=true;
   		$compute_month=true;
   		$compute_weekday=true;
   		$increment_year=true;

   				if($this->bits[4] !='*') $compute_day=false;
				else $compute_weekday=false;

   		$year=$year_now;

				$array_months=$this->parseCronElement($this->bits[3], "month");
		$array_weekdays=$this->parseCronElement($this->bits[4], "weekday");
		$array_hours=$this->parseCronElement($this->bits[1], "hour");
		$array_minutes=$this->parseCronElement($this->bits[0], "minute");


		$check_sooner=$this->checkBefore();

				if($check_sooner=="year"){
						$month=$array_months[0]; 
						$compute_month=false;
			$compute_day=false;
			$compute_hour=false;
			$compute_minute=false;
				$year=$year_now + 1;
			$increment_year=false;

		}


				
				$month=$array_months[0];

		if($compute_month){
	   			   		if(count($array_months)===1 || ($month_now < $array_months[0]) || ($month_now > end($array_months))){
	   			$month=$array_months[0];
	   		}

	   			   					elseif($check_sooner=="month" || (!in_array($month_now, $array_months) && ($month_now >=$array_months[0] && $month_now <=end($array_months)))){
				$month=$this->getNextValue($array_months, $month_now);

								if($month < $month_now){
					$year=$year+1;
				}
				$compute_day=false;
				$compute_hour=false;
				$compute_minute=false;
			}

						elseif(in_array($month_now, $array_months)){
				$month=$month_now;
			}

		}



				
						$array_days=$this->parseCronElement($this->bits[2], "day", $this->daysInMonth($month, $year));

				$day=$array_days[0];

		if($compute_day){
	   			   		if(count($array_days)===1 || ($day_now < $array_days[0]) || ($day_now > end($array_days))){
	   			$day=$array_days[0];
	   		}

	   			   			   					elseif($check_sooner=="day" || (!in_array($day_now, $array_days) && ($day_now >=$array_days[0] && $day_now <=end($array_days)))){
				$day=$this->getNextValue($array_days, $day_now);

								if($day < $day_now){					if($month==end($array_months)){						$year=$year+1;
					}
					$month=$this->getNextValue($array_months, $month);
				}
				$compute_hour=false;
				$compute_minute=false;
			}

						elseif(in_array($day_now, $array_days)){
				$day=$day_now;
			}

		}



				
				$weekday=$array_weekdays[0];

		if($compute_weekday){
	   			   		if(count($array_weekdays)===1 || ($weekday_now < $array_weekdays[0]) || ($weekday_now > end($array_weekdays))){
	   			$weekday=$array_weekdays[0];
	   		}

	   			   					elseif($check_sooner=="day" || (!in_array($weekday_now, $array_weekdays) && ($weekday_now >=$array_weekdays[0] && $weekday_now <=end($array_weekdays)))){
				$weekday=$this->getNextValue($array_weekdays, $weekday_now);
			}

						elseif(in_array($weekday_now, $array_weekdays)){
				$weekday=$weekday_now;
			}

			 			$day=$day_now;

						if($weekday > $weekday_now){				$diff=$weekday - $weekday_now;			}
						else {				$array_diff=array(0,1,2,3,4,5,6);
				$diff_to_end=0;				for($i=$weekday_now; $i<end($array_diff); $i++){
					$diff_to_end++;
				}

				$diff_from_begining=1;				for($i=0; $i<$array_diff[$weekday]; $i++){
					$diff_from_begining++;
				}

								$diff=$diff_to_end + $diff_from_begining;
			}

						if($diff!=0){
				for($i=1; $i<=$diff;$i++){
					$day_before=$day;
					$day=$this->getNextValue($array_days, $day);
										if($day<$day_before){						if($month==end($array_months) && $increment_year==true){							$year=$year+1;
						}
						$month=$this->getNextValue($array_months, $month);
					}
				}								$compute_hour=false;
				$compute_minute=false;
			}

		}

						if(!in_array($day_now, $array_days)){
			$compute_hour=false;
			$compute_minute=false;
		}

				
		$hour=$array_hours[0];

		if($compute_hour){
	   			   		if(count($array_hours)===1 || ($hour_now < $array_hours[0]) || ($hour_now > end($array_hours))){
	   			$hour=$array_hours[0];
	   		}

	   			   					elseif($check_sooner=="hour" || (!in_array($hour_now, $array_hours) && ($hour_now >=$array_hours[0] && $hour_now <=end($array_hours)))){
				$hour=$this->getNextValue($array_hours, $hour_now);
				if($hour<$hour_now){					if($day==end($array_days)){						if($month==end($array_months)){							$year=$year+1;
						}
						$month=$this->getNextValue($array_months, $month);
					}
					$day=$this->getNextValue($array_days, $day);
				}
				$compute_minute=false;
			}

						elseif(in_array($hour_now, $array_hours)){
				$hour=$hour_now;
			}

		}


				
		$minute=$array_minutes[0];

		if($compute_minute){
	   			   		if(count($array_minutes)===1 || ($minute_now < $array_minutes[0]) || ($minute_now > end($array_minutes))){
	   			$minute=$array_minutes[0];
	   		}

	   					elseif($check_sooner=="minute" || (!in_array($minute_now, $array_minutes) && ($minute_now >=$array_minutes[0] && $minute_now <=end($array_minutes)))){
				$minute=$this->getNextValue($array_minutes, $minute_now);
								if($minute<$minute_now){
					if($hour==end($hour_now)){						if($day==end($array_days)){							if($month==end($array_months)){								$year=$year+1;
							}
							$month=$this->getNextValue($array_months, $month);
						}
					$day=$this->getNextValue($array_days, $day);
					}
				}
			}

						elseif(in_array($minute_now, $array_minutes)){
								$minute=$this->getNextValue($array_minutes,$minute_now);
			}

		}

				$timestamp=mktime($hour, $minute, 0, $month, $day, $year);
		return $timestamp;

	}

	







	function parseCronElement($str,$type,$nb_days=31){
				if($type=="day"){
			$array=array();
			for($i=1; $i<=$nb_days; $i++){
				$array[]=$i;
			}

		}
				else $array=$this->getTypeArray($type);

				if($str=='0'){
			return array(0); 		}

				$case=$this->getCase($str);
				switch ($case){
						case 1:
				$ret=$array;
				break;

						case 2:
								$explode=explode('/', $str);
				$step=$explode[1];
								for($i=0; $i<=count($array) - 1; $i=$i+$step) $ret[]=$array[$i];
				break;

						case 3:
				$values=explode(",", $str);
								$count=count($values);
								for($i=0;$i<$count;$i++){
										if(strstr($values[$i],  "-")){
						$range=explode("-", $values[$i]);
						for($j=$range[0];$j<=$range[1];$j++){
							$ret[]=$j;
						}
					}
										else {
						$ret[]=$values[$i];
					}
				}
				break;

						case 4:
				$range=explode("-", $str);
				for($i=$range[0];$i<=$range[1];$i++){
					$ret[]=$i;
				}
				break;

						case 5:
				$ret=array($str);
				break;

		}
		sort($ret);
		return $ret;

	}







	function getCase($str){
				if($str=='0'){
			return array(0);
		}

		switch ($str){
						case '*':
				return 1;
				break;
						case strstr($str,  "/")!=false:
				return 2;
				break;
						case strstr($str,  ",")!=false:
				return 3;
				break;
						case strstr($str,  "-")!=false :
				return 4;
				break;
						case is_numeric($str) && strlen($str)>=0:
				return 5;
				break;
						default:
				return 6;
				break;
		}
	}






	function getTypeArray($type){
		switch($type){
			case "month":
				$array=array(1,2,3,4,5,6,7,8,9,10,11,12);
				break;
						case "day":
				$array=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
				break;
			case "weekday":
				$array=array(0,1,2,3,4,5,6);
				break;
			case "hour":
				$array=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
				break;
			case "minute":
				$array=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59);
				break;
			default:
				$array=array();
				break;
		}
		return $array;

	}







	function checkBefore(){

		   		$year_now=date("Y",$this->lastRun);   		$month_now=date("n",$this->lastRun);   		$day_now=date("j",$this->lastRun);   		$weekday_now=date("w",$this->lastRun);   		$hour_now=date("G",$this->lastRun);   		$minute_now=date("i",$this->lastRun);
				$array_months=$this->parseCronElement($this->bits[3], "month");
		$array_days=$this->parseCronElement($this->bits[2], "day", $this->daysInMonth($month_now, $year_now));
		$array_weekdays=$this->parseCronElement($this->bits[4], "weekday");
		$array_hours=$this->parseCronElement($this->bits[1], "hour");
		$array_minutes=$this->parseCronElement($this->bits[0], "minute");

				if(end($array_months) < $month_now) return "year";

						elseif(in_array($month_now, $array_months) && end($array_days) < $day_now) return "month";

				elseif(in_array($month_now, $array_months) && in_array($day_now, $array_days) && end($array_hours) < $hour_now) return "day";

				elseif(in_array($month_now, $array_months) && in_array($day_now, $array_days) && in_array($hour_now, $array_hours) && end($array_minutes) < $minute_now) return "hour";

		return "";

	}







	function getNextValue($array,$value){
				if($array[0]==end($array)) return $array[0];

				if(end($array)<=$value) return $array[0];

				elseif(!in_array($value, $array)){
			foreach($array as $key=> $array_element){
								if($value < $array_element){
					return $this->getNextValue($array, $array[$key-1]);
					break;
				}
			}		}
				else {
			$key=array_search($value, $array);
			return $array[$key+1];
		}

	}








 	function daysInMonth($month,$year){
       if(checkdate($month, 31, $year)) return 31;
       if(checkdate($month, 30, $year)) return 30;
       if(checkdate($month, 29, $year)) return 29;
       if(checkdate($month, 28, $year)) return 28;
       return 0;    }

 }

