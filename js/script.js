var realmTime = [];

jQuery(document).ready(function($){   
	
	
	realmTime["us_startTimestamp"] = 0;
	realmTime["us_endTimestamp"] = 0;
	
	realmTime["us_active"] = false;
	realmTime["us_zone"] = "";
				
	realmTime["eu_startTimestamp"] = 0;
	realmTime["eu_endTimestamp"] = 0;
	
	realmTime["eu_active"] = false;
	realmTime["eu_zone"] = "";
				
	realmTime["ozean_startTimestamp"] = 0;
	realmTime["ozean_endTimestamp"] = 0;
	
	realmTime["ozean_active"] = false;
	realmTime["ozean_zone"] = "";
	
	function getRealmData(realm){
		
		var curTime = Math.round(new Date().getTime()/1000); //$.now();
		
		if(realmTime[realm + "_active"] == false){
			
			//console.log("Data: " + curTime + " > " + realmTime[realm + "_startTimestamp"]);

			if(curTime > realmTime[realm + "_startTimestamp"]){
				getRealmRequest(realm);
			}else{
				loadRealmRequest(realm);
			}
		}else{
			//console.log("Data: " + curTime + " > " + realmTime[realm + "_endTimestamp"]);
			
			if(curTime > realmTime[realm + "_endTimestamp"]){
				getRealmRequest(realm);
			}else{
				loadRealmRequest(realm);
			}
		}
	}
	
	
	setInterval(function(){
		getRealmData("us");
		getRealmData("eu");
		getRealmData("ozean");
	}, 1000);
	
	
	getTokenPrice();
	
	setInterval(function(){
		getTokenPrice();
	}, 10000);
	
	function getTokenPrice(){
		$.get( "api/token/", function( data ) {
			$("#token_us_price").html(data.token[0].price);
			$("#token_us_time").html(data.token[0].last_updated);
			
			$("#token_eu_price").html(data.token[1].price);
			$("#token_eu_time").html(data.token[1].last_updated);
			
			$("#token_cn_price").html(data.token[2].price);
			$("#token_cn_time").html(data.token[2].last_updated);
			
			$("#token_kr_price").html(data.token[3].price);
			$("#token_kr_time").html(data.token[3].last_updated);
			
			$("#token_tw_price").html(data.token[4].price);
			$("#token_tw_time").html(data.token[4].last_updated);
		});
	}
	
	function getRealmRequest(realm){
		$.get( "api/invasion/" + realm, function( data ) {
			if(data.invasions[0].active == true){
				$("#invasion-" + realm + "-status").html("<font color=\"#d32f2f\">Invasion aktiv!</font>");
				
				var curTime = Math.round(new Date().getTime()/1000); //$.now();
				
				var timeDifference = data.invasions[0].endTimestamp - curTime;
				
				var second = 1;
				var minute = 60 * second;
				var hour = 60 * minute;
				var day = 24 * hour;
				
				var days =  Math.round(timeDifference / day);
				var hours =  Math.round((timeDifference % day) / hour);
				var minutes =  Math.round(((timeDifference % day) % hour) / minute);
				var seconds =  Math.round((((timeDifference % day) % hour) % minute) / second);
				
				if(Math.round(hours - (minutes / 60)) < 10){
					$("#hours-" + realm).html("0" + Math.round(hours - (minutes / 60)));
				}else{
					$("#hours-" + realm).html(Math.round(hours - (minutes / 60)));
				}
				
				if(Math.round(minutes - (seconds / 60)) < 10){
					$("#minutes-" + realm).html("0" + Math.round(minutes - (seconds / 60)));
				}else{
					$("#minutes-" + realm).html(Math.round(minutes - (seconds / 60)));
				}
				
				if(seconds < 10){
					$("#seconds-" + realm).html("0" + seconds);
				}else{
					$("#seconds-" + realm).html(seconds);
				}
				
				$("#invasion-time-" + realm).html(data.invasions[0].startTime + " Uhr → " + data.invasions[0].endTime + " Uhr");
				$("#invasion-zone-" + realm).html("Zone: <b>" + data.invasions[0].zone + "</b>");
			}else{
				$("#invasion-" + realm + "-status").html("<font color=\"#303030\">Nächste Invasion in:</font>");
							
				var curTime = Math.round(new Date().getTime()/1000); //$.now();
							
				var timeDifference = data.invasions[0].startTimestamp - curTime;
				
				var second = 1;
				var minute = 60 * second;
				var hour = 60 * minute;
				var day = 24 * hour;
				
				var days =  Math.round(timeDifference / day);
				var hours =  Math.round((timeDifference % day) / hour);
				var minutes =  Math.round(((timeDifference % day) % hour) / minute);
				var seconds =  Math.round((((timeDifference % day) % hour) % minute) / second);
				
				if(Math.round(hours - (minutes / 60)) < 10){
					$("#hours-" + realm).html("0" + Math.round(hours - (minutes / 60)));
				}else{
					$("#hours-" + realm).html(Math.round(hours - (minutes / 60)));
				}
				
				if(Math.round(minutes - (seconds / 60)) < 10){
					$("#minutes-" + realm).html("0" + Math.round(minutes - (seconds / 60)));
				}else{
					$("#minutes-" + realm).html(Math.round(minutes - (seconds / 60)));
				}
				
				if(seconds < 10){
					$("#seconds-" + realm).html("0" + seconds);
				}else{
					$("#seconds-" + realm).html(seconds);
				}
				
				$("#invasion-time-" + realm).html(data.invasions[0].startTime + " Uhr → " + data.invasions[0].endTime + " Uhr");
				$("#invasion-zone-" + realm).html("Zone: <b>" + data.invasions[0].zone + "</b>");
			}
			
			//console.log("Zone: " + data.invasions[0].zone);
			
			realmTime[realm + "_startTimestamp"] = data.invasions[0].startTimestamp;
			realmTime[realm + "_endTimestamp"] = data.invasions[0].endTimestamp;
			realmTime[realm + "_startTime"] = data.invasions[0].startTime;
			realmTime[realm + "_endTime"] = data.invasions[0].endTime;
			realmTime[realm + "_active"] = data.invasions[0].active;
			realmTime[realm + "_zone"] = data.invasions[0].zone;
			
			console.log("Data: " + realmTime[realm + "_active"]);
			
		});
	}
	
	function loadRealmRequest(realm){
		if(realmTime[realm + "_active"] == true){
			$("#invasion-" + realm + "-status").html("<font color=\"#d32f2f\">Invasion aktiv!</font>");
			
			var curTime = Math.round(new Date().getTime()/1000); //$.now();
			
			var timeDifference = realmTime[realm + "_endTimestamp"] - curTime;
			
			var second = 1;
			var minute = 60 * second;
			var hour = 60 * minute;
			var day = 24 * hour;
			
			var days =  Math.round(timeDifference / day);
			var hours =  Math.round((timeDifference % day) / hour);
			var minutes =  Math.round(((timeDifference % day) % hour) / minute);
			var seconds =  Math.round((((timeDifference % day) % hour) % minute) / second);
			
			if(Math.round(hours - (minutes / 60)) < 10){
				$("#hours-" + realm).html("0" + Math.round(hours - (minutes / 60)));
			}else{
				$("#hours-" + realm).html(Math.round(hours - (minutes / 60)));
			}
			
			if(Math.round(minutes - (seconds / 60)) < 10){
				$("#minutes-" + realm).html("0" + Math.round(minutes - (seconds / 60)));
			}else{
				$("#minutes-" + realm).html(Math.round(minutes - (seconds / 60)));
			}
			
			if(seconds < 10){
				$("#seconds-" + realm).html("0" + seconds);
			}else{
				$("#seconds-" + realm).html(seconds);
			}
			
			//console.log("Data: " + seconds);
			
			$("#invasion-time-" + realm).html(realmTime[realm + "_startTime"] + " Uhr → " + realmTime[realm + "_endTime"] + " Uhr");
			$("#invasion-zone-" + realm).html("Zone: <b>" + realmTime[realm + "_zone"] + "</b>");
		}else{
			$("#invasion-" + realm + "-status").html("<font color=\"#303030\">Nächste Invasion in:</font>");

			var curTime = Math.round(new Date().getTime()/1000); //$.now();
			
			var timeDifference = realmTime[realm + "_startTimestamp"] - curTime;
			
			var second = 1;
			var minute = 60 * second;
			var hour = 60 * minute;
			var day = 24 * hour;
			
			var days =  Math.round(timeDifference / day);
			var hours =  Math.round((timeDifference % day) / hour);
			var minutes =  Math.round(((timeDifference % day) % hour) / minute);
			var seconds =  Math.round((((timeDifference % day) % hour) % minute) / second);
			
			if(Math.round(hours - (minutes / 60)) < 10){
				$("#hours-" + realm).html("0" + Math.round(hours - (minutes / 60)));
			}else{
				$("#hours-" + realm).html(Math.round(hours - (minutes / 60)));
			}
			
			if(Math.round(minutes - (seconds / 60)) < 10){
				$("#minutes-" + realm).html("0" + Math.round(minutes - (seconds / 60)));
			}else{
				$("#minutes-" + realm).html(Math.round(minutes - (seconds / 60)));
			}
			
			if(seconds < 10){
				$("#seconds-" + realm).html("0" + seconds);
			}else{
				$("#seconds-" + realm).html(seconds);
			}
			
			$("#invasion-time-" + realm).html(realmTime[realm + "_startTime"] + " Uhr → " + realmTime[realm + "_endTime"] + " Uhr");
			$("#invasion-zone-" + realm).html("Zone: <b>" + realmTime[realm + "_zone"] + "</b>");
		}
	}
	
	var tokenCollapsed = true;
	
	$("#ocean-tokens").click(function() {
		if(tokenCollapsed == true){
			$("#kr-tokens").fadeIn("slow");
			$("#tw-tokens").fadeIn("slow");
			
			$("#ocean-tokens").html("-");
			tokenCollapsed = false;
		}else{
			$("#kr-tokens").fadeOut("slow");
			$("#tw-tokens").fadeOut("slow");
			
			$("#ocean-tokens").html("+");
			tokenCollapsed = true;
		}
	});
	
});