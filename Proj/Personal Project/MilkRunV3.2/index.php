<!DOCTYPE html>
<html lang="en-US">
<head>

<title>Milk Run</title>  

<!-- Add in style sheets -->
<link rel="stylesheet" type="text/css" href="start_screen_stylesheet.css">
<link rel="stylesheet" type="text/css" href="log_in_stylesheet.css">

<!-- Add in scripts -->
<script  src="Startscreen.js"></script>

</head>
<body onload="checkCookieLog()">

<!-- Start screen divider -->
<div id="start_screen" style="z-index:200;">
<h1 id="title">Milk Run!</h1>
<button id="start_button" onclick="window.location.href='gamepage.html'">Play</button><br />
<button id="log_in_button" onclick="In('log_in');">Log In</button><br />
<button id="log_out_button" onclick="logOut()">LogOut</button>
<button id="options_button" onclick="In('options_screen');">Scores</button>
</div>

<!-- Log in screen divider -->
<div id="log_in" style="display:none">
<h1>Log In Screen</h1>
<p><span class="error">* required field.</span></p>
<form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' >
 User Name:<br />
 <input name="Name" type="text" /><span class="error">*</span></br>
 Password:<br />
 <input name="Password" type="password" /><span class="error">*</span></br>
<input type="submit" value="Log In" >
</form>
<button id="register_button" type="submit" onclick="window.location.href='register.php'">Register</button>
<button id="1back" onclick="Back('log_in');" >Back to Title Screen</button>
</div>

<!-- Options screen divider -->
<div id="options_screen" style="display:none">
<h1>High Scores</h1>
<button id="2back" onclick="Back('options_screen');">Back to Title Screen</button>
</div>

</body>
</html>