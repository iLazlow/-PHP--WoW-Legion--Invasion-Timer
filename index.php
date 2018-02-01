<?php
include("required.php");
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
					
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							<span id="token_us_price">0</span> Gold<br>
							Letztes Update: <span id="token_us_time">00.00.0000 00:00</span>
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
					
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							<span id="token_eu_price">0</span> Gold<br>
							Letztes Update: <span id="token_eu_time">00.00.0000 00:00</span>
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
					
					<div class="wow-token">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							China: <span id="token_cn_price">0</span> Gold<br>
							Letztes Update: <span id="token_cn_time">00.00.0000 00:00</span>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="wow-token" id="kr-tokens" style="display: none;">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							Korea: <span id="token_kr_price">0</span> Gold<br>
							Letztes Update: <span id="token_kr_time">00.00.0000 00:00</span>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="wow-token" id="tw-tokens" style="display: none;">
						<div class="pull-left">
							<img src="img/token_icon.png" style="width: 50px;" />
						</div>
						
						<div class="pull-left" style="width: calc(100% - 50px);">
							Taiwan: <span id="token_tw_price">0</span> Gold<br>
							Letztes Update: <span id="token_tw_time">00.00.0000 00:00</span>
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