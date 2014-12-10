<!DOCTYPE html>
<html lang="en-US" charset="UTF-8">
<head>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<title>Milk Run</title>  

<!-- Add in style sheets -->
<link rel="stylesheet" type="text/css" href="start_screen_stylesheet.css">


<!-- Add in scripts -->
<script  src="Startscreen.js"></script>

</head>
<body onload="checkCookieLog()">
<?php 
	$Uname= $playerID= "";
	$cookie_name= "username";
	if(isset($_COOKIE[$cookie_name])){
		if($_COOKIE[$cookie_name] != ""){
		$Uname= "Welcome ".$_COOKIE[$cookie_name];
		}};
	if(isset($COOKIE["player_id"])){
		if($_COOKIE["player_id"] != ""){
		$playerID = "player ".$COOKIE["player_id"];
		};
	};
?>
<!-- Start screen divider -->
<div id="start_screen" style="z-index:200;" style="display:<?php echo $startscreen;?>">
<h1 id="title">Milk Run!</h1>
<button id="start_button" onclick="window.location.href='gamepage.html'">Play</button><br />
<button id="log_in_button" onclick="window.location.href='log_in.php'">Log In</button><br />
<button id="log_out_button" onclick="logOut()"style="display:none">LogOut</button>
<button id="options_button" onclick="window.location.href='scores.php'">Scores</button>
<span id="welcome"><?php echo $Uname; echo $playerID;?></span>
</div>



<footer style="position:relative; left:20%">Created by Travis Hajagos on 12/08/2014 <a href="mailto:tchajagos@hotmail.com">tchajagos@hotmail.com</a>.</footer>
</body>
</html>