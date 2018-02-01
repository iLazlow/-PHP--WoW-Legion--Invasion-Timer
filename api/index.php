<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$curDay = time();
if(strtoupper($_GET["realm"]) == "EU"){
	$startHardCoded = 1493173800;
}elseif(strtoupper($_GET["realm"]) == "US"){
	$startHardCoded = 1493202600;
}else{
	$startHardCoded = 1493202600;
}

$timeDifference = $curDay - $startHardCoded;

$i = 0;
$daysCountTotal = 1;
$lastEnd = 0;
$lastStart;

$dayCycles = 0;
$zoneCycles = 3;

function getZoneName($dayCycle, $zoneCycle){
	$zones = array(array("Val'sharah", "Sturmheim", "Azsuna", "Hochberg"), array("Sturmheim ", "Hochberg", "Val'sharah", "Azsuna"), array("Sturmheim", "Val'sharah", "Hochberg", "Azsuna"));
	
	return $zones[$dayCycle][$zoneCycle];
}

if($timeDifference >= (24 * 3600)){
	$daysBetween = round($timeDifference / (24 * 3600));
	$daysBetweenDifference = $daysBetween - 8;
	
	$lastStart = $startHardCoded;
	
	while($i <  1){
		if($lastStart == ""){
			$invasion[$weekCount]["startTime"] = $start;
		}else{
			$invasion[$weekCount]["startTime"] = $lastStart;
		}
		
		$lastStart = $invasion[$weekCount]["startTime"];
		$invasion[$weekCount]["endTime"] = $lastStart + (3600 * 6);
		$lastStart = $invasion[$weekCount]["endTime"] + (3600 * 12) + 1800;
		
		$lastEnd = $invasion[$weekCount]["endTime"];
		
		$nextStart = $lastEnd + (3600 * 18) + 1800;
		
		if($dayCycles <= 2){
			if($dayCycles == 2 and $zoneCycles == 3){
				$dayCycles = 0;
			}elseif($zoneCycles == 3){
				$dayCycles++;
			}
		}
		
		if($zoneCycles < 3){
			$zoneCycles++;
		}else{
			$zoneCycles = 0;
		}
		
		if($lastEnd <= $curDay and $nextStart >= $curDay){
			$i++;
		}
		
		$daysCountTotal++;
		
		if($i >=  1){
			break;
		}
	}
}


$invasion;
$lastEnd;
$lastDate;

$weekCount = 0;

$responses = array();

$nextWeek = $curDay + (3600 * 24 * 7);
while($weekCount <= 7){
	if($lastStart == ""){
		$invasion[$weekCount]["startTime"] = $startHardCoded;
	}else{
		$invasion[$weekCount]["startTime"] = $lastStart;
	}
	
	$lastStart = $invasion[$weekCount]["startTime"];
	$invasion[$weekCount]["endTime"] = $lastStart + (3600 * 6);
	$lastStart = $invasion[$weekCount]["endTime"] + (3600 * 12) + 1800;
	$lastEnd = $invasion[$weekCount]["endTime"];
	
	$dateDEBUG = date("d.m.Y", $lastEnd);
	$timeDEBUG = date("H:i", $lastEnd);

	$date = date("d.m.Y", $invasion[$weekCount]["startTime"]);
	$time = date("H:i", $invasion[$weekCount]["startTime"]);
	
	$dateEND = date("d.m.Y", $invasion[$weekCount]["endTime"]);
	$timeEND = date("H:i", $invasion[$weekCount]["endTime"]);
	
	if($curDay >= $invasion[$weekCount]["startTime"] and $curDay <= $invasion[$weekCount]["endTime"]){
		$active = true;
		$percent = ($curDay-$invasion[$weekCount]["startTime"]) / ($invasion[$weekCount]["endTime"]-$invasion[$weekCount]["startTime"]) * 100;
	}else{
		$active = false;
		$percent = 0;
	}
	
	$invasionZone = getZoneName($dayCycles, $zoneCycles);
		
	if($dayCycles <= 2){
		if($dayCycles == 2 and $zoneCycles == 3){
			$dayCycles = 0;
		}elseif($zoneCycles == 3){
			$dayCycles++;
		}
	}
	
	if($zoneCycles < 3){
		$zoneCycles++;
	}else{
		$zoneCycles = 0;
	}
	
	$response = array(
		'startDate' => $date,
		'startTime' => $time,
		'startTimestamp' => $invasion[$weekCount]["startTime"],
		'endDate' => $dateEND,
		'endTime' => $timeEND,
		'endTimestamp' => $invasion[$weekCount]["endTime"],
		'active' => $active,
		'percent' => $percent,
		'zone' => $invasionZone
	);
	
	if($active == true){
		if($curDay < $invasion[$weekCount]["endTime"]){
			$responses[] = $response;
		}
	}else{
		if($curDay > $invasion[$weekCount]["endTime"]){
		
		}else{
			$responses[] = $response;
		}
	}

	if($lastDate != $date){
		$weekCount++;
	}
	
	$lastDate = $date;
	
}

if(strtolower($_GET["token"]) == "true"){
	include("../config.php");

	$prices = array();

	//US
	$usTokenRefreshDate = date("d.m.Y", $usTokenAPI["last_updated"]);
	$usTokenRefreshTime = date("H:i", $usTokenAPI["last_updated"]);
	$usPrice = array(
		'token_zone' => "US",
		'last_updated' => $usTokenRefreshDate." ".$usTokenRefreshTime,
		'price' => strval(@(number_format($usTokenAPI["price"] / 100 / 100, 0, ',','.')))
	);
	$prices[] = $usPrice;

	//EU
	$euTokenRefreshDate = date("d.m.Y", $euTokenAPI["last_updated"]);
	$euTokenRefreshTime = date("H:i", $euTokenAPI["last_updated"]);
	$euPrice = array(
		'token_zone' => "EU",
		'last_updated' => $euTokenRefreshDate." ".$euTokenRefreshTime,
		'price' => strval(@(number_format($euTokenAPI["price"] / 100 / 100, 0, ',','.')))
	);
	$prices[] = $euPrice;

	//CN
	$cnTokenRefreshDate = date("d.m.Y", $cnTokenAPI["CN"]["timestamp"]);
	$cnTokenRefreshTime = date("H:i", $cnTokenAPI["CN"]["timestamp"]);
	$cnPrice = array(
		'token_zone' => "CN",
		'last_updated' => $cnTokenRefreshDate." ".$cnTokenRefreshTime,
		'price' => strval(@(number_format($cnTokenAPI["CN"]["raw"]["buy"], 0, ',','.')))
	);
	$prices[] = $cnPrice;

	//KR
	$krTokenRefreshDate = date("d.m.Y", $krTokenAPI["last_updated"]);
	$krTokenRefreshTime = date("H:i", $krTokenAPI["last_updated"]);
	$krPrice = array(
		'token_zone' => "KR",
		'last_updated' => $krTokenRefreshDate." ".$krTokenRefreshTime,
		'price' => strval(@(number_format($krTokenAPI["price"] / 100 / 100, 0, ',','.')))
	);
	$prices[] = $krPrice;

	//TW
	$twTokenRefreshDate = date("d.m.Y", $twTokenAPI["last_updated"]);
	$twTokenRefreshTime = date("H:i", $twTokenAPI["last_updated"]);
	$twPrice = array(
		'token_zone' => "TW",
		'last_updated' => $twTokenRefreshDate." ".$twTokenRefreshTime,
		'price' => strval(@(number_format($twTokenAPI["price"] / 100 / 100, 0, ',','.')))
	);
	$prices[] = $twPrice;
}else{
	$prices[] = array(
		'token_zone' => "NONE",
		'last_updated' => "00.00.0000 00:00",
		'price' => 0
	);
}

$arr = array("time" => time(), "invasions" => $responses, "token" => $prices);
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>