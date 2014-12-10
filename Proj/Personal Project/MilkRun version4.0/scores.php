<!DOCTYPE html>
<html lang="en-US" charset="UTF-8">
<head>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<title>Milk Run</title>  

<!-- Add in style sheets -->
<link rel="stylesheet" type="text/css" href="scores_stylesheet.css">


<!-- Add in scripts -->
<script  src="Startscreen.js"></script>

</head>
<body>

<!-- Options screen divider -->
<div id="scores_screen">
<h1>High Scores</h1>
<?php
$servername = "209.129.8.5";
$username = "48075";
$password = "48075cis12";
$dbname = "48075";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = 'SELECT entity_players_th1998726.user_name, entity_score_th1998726.game_score FROM entity_score_th1998726, entity_players_th1998726 WHERE entity_score_th1998726.player_id = entity_players_th1998726.player_id ORDER BY entity_score_th1998726.game_score DESC LIMIT 1, 10';
$result = $conn->query($sql);
//check if there is a match
echo "<table id='score_table'><tr><th>Player</th><th>Distance</th></tr>";
// output data of each row
if($result === FALSE){
    die("Connection failed: ".$conn->connect_error);
};
while($row = $result->fetch_assoc()){
	echo "<tr><td>".$row["user_name"]."</td><td>".$row["game_score"]."</td></tr>";
};
echo "</table>";
mysqli_close($conn);
?>
<button id="back" onclick="window.location.href='index.php'">Back to Main Menu</button>
</div>

<footer style="position:relative; left:20%">Created by Travis Hajagos on 12/08/2014 <a href="mailto:tchajagos@hotmail.com">tchajagos@hotmail.com</a>.</footer>
</body>
</html>