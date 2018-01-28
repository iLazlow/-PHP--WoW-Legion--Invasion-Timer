<?php
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$apiLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/api";

//Get your api access token on https://dev.battle.net/
$EU_API_ACCESS_TOKEN = "YOUR_TOKEN";
$US_API_ACCESS_TOKEN = "YOUR_TOKEN";
$KR_API_ACCESS_TOKEN = "YOUR_TOKEN";
$TW_API_ACCESS_TOKEN = "YOUR_TOKEN";

$euTokenURL = "https://eu.api.battle.net/data/wow/token/?namespace=dynamic-eu&locale=de_DE&access_token=$EU_API_ACCESS_TOKEN";
$euTokenAPI = json_decode(file_get_contents($euTokenURL, false, stream_context_create($arrContextOptions)), true);

$usTokenURL = "https://us.api.battle.net/data/wow/token/?namespace=dynamic-us&locale=en_US&access_token=$US_API_ACCESS_TOKEN";
$usTokenAPI = json_decode(file_get_contents($usTokenURL, false, stream_context_create($arrContextOptions)), true);

//Ocean
$cnTokenURL = "https://data.wowtoken.info/snapshot.json";
$cnTokenAPI = json_decode(file_get_contents($cnTokenURL, false, stream_context_create($arrContextOptions)), true);

$krTokenURL = "https://kr.api.battle.net/data/wow/token/?namespace=dynamic-kr&locale=ko_KR&access_token=$KR_API_ACCESS_TOKEN";
$krTokenAPI = json_decode(file_get_contents($krTokenURL, false, stream_context_create($arrContextOptions)), true);

$twTokenURL = "https://tw.api.battle.net/data/wow/token/?namespace=dynamic-tw&locale=zh_TW&access_token=$TW_API_ACCESS_TOKEN";
$twTokenAPI = json_decode(file_get_contents($twTokenURL, false, stream_context_create($arrContextOptions)), true);

?>

<!DOCTYPE html>
<html lang="de-DE">
<head>
	<!-- Title -->
	<title>Legion Invasion Timer</title>
	
	<!-- Meta -->
    <meta content="Legion Invasion Timer" name="description">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta name="author" content="iLazlow">
	<meta name="publisher" content="iLazlow">
	<meta name="copyright" content="iLazlow">
	<meta name="page-topic" content="Dienstleistung">
	<meta name="page-type" content="Webseite">
	<meta name="audience" content="Alle">
	<meta http-equiv="content-language" content="de">
	<meta name="robots" content="index, follow">
	<meta name="theme-color" content="#C9003A">
	
	<!-- Facebook META -->
	<meta property="og:url" content="http://wow.iLazlow.de/" />
	<meta property="og:type" content="website" />
	<meta property="og:locale" content="de_DE" />
	<meta property="og:title" content="Legion Invasion Timer" />
	<meta property="og:description" content="Habe immer alle Legion Invasionen im Überblick." />

	<!-- CSS Styles -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="/css/style.css" rel="stylesheet">
	
	<!-- Javascript -->
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/script.js"></script>
	
<head>
<body>
	<div class="background"></div>
	<svg width="100%" height="500px" style="position: absolute; top: 0px; left: 0px;">
		<defs><linearGradient id="fade" x2="0" y2="1"><stop offset="0%" stop-opacity="0"></stop><stop offset="100%" stop-opacity=".9"></stop></linearGradient></defs>
		<rect fill="url(#fade)" x="0" y="0" width="100%" height="100%"></rect>
	</svg>
	
	<div style="width: 100%; height: 240px;"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-4 ml-md-auto">
				<div class="box">
					<div class="realm-bg">
						US Realms
					</div>
					
					<?php 
						$usTokenRefreshDate = date("d.m.Y", $usTokenAPI["last_updated"]);
						$usTokenRefreshTime = date("H:i", $usTokenAPI["last_updated"]);
					?>
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							<?php echo floatval(@(number_format($usTokenAPI["price"] / 100 / 100, 0, ',','.'))); ?> Gold<br>
							Letztes Update: <?php echo $usTokenRefreshDate." ".$usTokenRefreshTime; ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="invasion-timer">
						<div class="invasion-status">
							<span id="invasion-us-status"></span>
						</div>
						
						<div class="invasion-counter">
							<div class="invasion-hours">
								<span id="hours-us">0</span>
								<p>Stunden</p>
							</div>
							<div class="invasion-minutes">
								<span id="minutes-us">0</span>
								<p>Minuten</p>
							</div>
							<div class="invasion-seconds">
								<span id="seconds-us">0</span>
								<p>Sekunden</p>
							</div>
						</div>
						
						<div class="invasion-date">
							<span id="invasion-time-us"></span><br>
							<span id="invasion-zone-us">Zone</span>
						</div>
					</div>
					
					<?php
						$invasionJSON = json_decode(file_get_contents($apiLink.'/invasion/US/', false), true);
					?>
					
					<div class="invasion-plan">
						<div class="invasion-plan-title">
							Invasionen Übersicht
						</div>
						
						<table>
							<tbody>
								<?php
									$i = 0;
		
									foreach($invasionJSON['invasions'] as $item) {
										
										$date = date("d.m.Y", $item["startTimestamp"]);
										$time = date("H:i", $item["startTimestamp"]);
										$day = date("d", $item["startTimestamp"]);
										$tag = date("w", $item["startTimestamp"]);
										$monat = date("n", $item["startTimestamp"]);
										$year = date("Y", $item["startTimestamp"]);
										
										$dateEND = date("d.m.Y", $item["endTimestamp"]);
										$timeEND = date("H:i", $item["endTimestamp"]);
										$dayEND = date("d", $item["endTimestamp"]);
										$tagEND = date("w", $item["endTimestamp"]);
										$monatEND = date("n", $item["endTimestamp"]);
										$yearEND = date("Y", $item["endTimestamp"]);
										
										$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
										$monate = array("Dez.", "Jan.", "Feb.", "Mär.", "Apr.", "Mai", "Jun.", "Jul.", "Aug.", "Sep.", "Okt.", "Nov.");
										
										//echo $tage[$tag].', '.$day.' '.$monate[$monat].' '.$year;
									
								?>
								<tr>
									<td><?php echo $tage[$tag]; ?>, <?php echo $day; ?> <?php echo $monate[$monat]; ?></td>
									<td><?php echo $time; ?> Uhr → <?php echo $timeEND; ?> Uhr</td>
								</tr>
								<?php
										$i++;
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 ml-md-auto">
				<div class="box active">
					<div class="realm-bg">
						EU Realms
					</div>
					
					<?php 
						$euTokenRefreshDate = date("d.m.Y", $euTokenAPI["last_updated"]);
						$euTokenRefreshTime = date("H:i", $euTokenAPI["last_updated"]);
					?>
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							<?php echo floatval(@(number_format($euTokenAPI["price"] / 100 / 100, 0, ',','.'))); ?> Gold<br>
							Letztes Update: <?php echo $euTokenRefreshDate." ".$euTokenRefreshTime; ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="invasion-timer">
						<div class="invasion-status">
							<span id="invasion-eu-status"></span>
						</div>
						
						<div class="invasion-counter">
							<div class="invasion-hours">
								<span id="hours-eu">0</span>
								<p>Stunden</p>
							</div>
							<div class="invasion-minutes">
								<span id="minutes-eu">0</span>
								<p>Minuten</p>
							</div>
							<div class="invasion-seconds">
								<span id="seconds-eu">0</span>
								<p>Sekunden</p>
							</div>
						</div>
						
						<div class="invasion-date">
							<span id="invasion-time-eu"></span><br>
							<span id="invasion-zone-eu">Zone</span>
						</div>
					</div>
					
					<?php
						$invasionJSON = json_decode(file_get_contents($apiLink.'/invasion/EU/', false), true);
					?>
					
					<div class="invasion-plan">
						<div class="invasion-plan-title">
							Invasionen Übersicht
						</div>
						
						<table>
							<tbody>
								<?php
									$i = 0;
		
									foreach($invasionJSON['invasions'] as $item) {
										
										$date = date("d.m.Y", $item["startTimestamp"]);
										$time = date("H:i", $item["startTimestamp"]);
										$day = date("d", $item["startTimestamp"]);
										$tag = date("w", $item["startTimestamp"]);
										$monat = date("n", $item["startTimestamp"]);
										$year = date("Y", $item["startTimestamp"]);
										
										$dateEND = date("d.m.Y", $item["endTimestamp"]);
										$timeEND = date("H:i", $item["endTimestamp"]);
										$dayEND = date("d", $item["endTimestamp"]);
										$tagEND = date("w", $item["endTimestamp"]);
										$monatEND = date("n", $item["endTimestamp"]);
										$yearEND = date("Y", $item["endTimestamp"]);
										
										$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
										$monate = array("Dez.", "Jan.", "Feb.", "Mär.", "Apr.", "Mai", "Jun.", "Jul.", "Aug.", "Sep.", "Okt.", "Nov.");
										
										//echo $tage[$tag].', '.$day.' '.$monate[$monat].' '.$year;
									
								?>
								<tr>
									<td><?php echo $tage[$tag]; ?>, <?php echo $day; ?> <?php echo $monate[$monat]; ?></td>
									<td><?php echo $time; ?> Uhr → <?php echo $timeEND; ?> Uhr</td>
								</tr>
								<?php
										$i++;
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 ml-md-auto ">
				<div class="box">
					<div class="realm-bg">
						OZEAN Realms
					</div>
					
					
					<?php 
						$cnTokenRefreshDate = date("d.m.Y", $cnTokenAPI["CN"]["timestamp"]);
						$cnTokenRefreshTime = date("H:i", $cnTokenAPI["CN"]["timestamp"]);
					?>
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							China: <?php echo floatval(@(number_format($cnTokenAPI["CN"]["raw"]["buy"], 0, ',','.'))); ?> Gold<br>
							Letztes Update: <?php echo $cnTokenRefreshDate." ".$cnTokenRefreshTime; ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					
					<?php 
						$krTokenRefreshDate = date("d.m.Y", $krTokenAPI["last_updated"]);
						$krTokenRefreshTime = date("H:i", $krTokenAPI["last_updated"]);
					?>
					<div class="wow-token" id="kr-tokens" style="display: none;">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							Korea: <?php echo floatval(@(number_format($krTokenAPI["price"] / 100 / 100, 0, ',','.'))); ?> Gold<br>
							Letztes Update: <?php echo $krTokenRefreshDate." ".$krTokenRefreshTime; ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					
					<?php 
						$twTokenRefreshDate = date("d.m.Y", $twTokenAPI["last_updated"]);
						$twTokenRefreshTime = date("H:i", $twTokenAPI["last_updated"]);
					?>
					<div class="wow-token" id="tw-tokens" style="display: none;">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							Taiwan: <?php echo floatval(@(number_format($twTokenAPI["price"] / 100 / 100, 0, ',','.'))); ?> Gold<br>
							Letztes Update: <?php echo $twTokenRefreshDate." ".$twTokenRefreshTime; ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="token-collapse" id="ocean-tokens">
						+
					</div>
					
					<div class="invasion-timer">
						<div class="invasion-status">
							<span id="invasion-ozean-status"></span>
						</div>
						
						<div class="invasion-counter">
							<div class="invasion-hours">
								<span id="hours-ozean">0</span>
								<p>Stunden</p>
							</div>
							<div class="invasion-minutes">
								<span id="minutes-ozean">0</span>
								<p>Minuten</p>
							</div>
							<div class="invasion-seconds">
								<span id="seconds-ozean">0</span>
								<p>Sekunden</p>
							</div>
						</div>
						
						<div class="invasion-date">
							<span id="invasion-time-ozean"></span><br>
							<span id="invasion-zone-ozean">Zone</span>
						</div>
					</div>
					
					<?php
						$invasionJSON = json_decode(file_get_contents($apiLink.'/invasion/OZEAN/', false), true);
					?>
					
					<div class="invasion-plan">
						<div class="invasion-plan-title">
							Invasionen Übersicht
						</div>
						
						<table>
							<tbody>
								<?php
									$i = 0;
		
									foreach($invasionJSON['invasions'] as $item) {
										
										$date = date("d.m.Y", $item["startTimestamp"]);
										$time = date("H:i", $item["startTimestamp"]);
										$day = date("d", $item["startTimestamp"]);
										$tag = date("w", $item["startTimestamp"]);
										$monat = date("n", $item["startTimestamp"]);
										$year = date("Y", $item["startTimestamp"]);
										
										$dateEND = date("d.m.Y", $item["endTimestamp"]);
										$timeEND = date("H:i", $item["endTimestamp"]);
										$dayEND = date("d", $item["endTimestamp"]);
										$tagEND = date("w", $item["endTimestamp"]);
										$monatEND = date("n", $item["endTimestamp"]);
										$yearEND = date("Y", $item["endTimestamp"]);
										
										$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
										$monate = array("Dez.", "Jan.", "Feb.", "Mär.", "Apr.", "Mai", "Jun.", "Jul.", "Aug.", "Sep.", "Okt.", "Nov.");
										
										//echo $tage[$tag].', '.$day.' '.$monate[$monat].' '.$year;
									
								?>
								<tr>
									<td><?php echo $tage[$tag]; ?>, <?php echo $day; ?> <?php echo $monate[$monat]; ?></td>
									<td><?php echo $time; ?> Uhr → <?php echo $timeEND; ?> Uhr</td>
								</tr>
								<?php
										$i++;
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer">
			&copy; <?php echo date("Y"); ?> iLazlow - For China Token prices this website use data from <a href="http://wowtoken.info">wowtoken.info</a>.
		</div>
	</div>
	
</body>
</html>