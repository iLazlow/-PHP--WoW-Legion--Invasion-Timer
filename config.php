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