<!DOCTYPE html>
<html lang="en-US">

<head>

<title>Milk Run</title>  

<!-- Add in style sheets -->


<!-- Add in scripts -->
<script  src="Startscreen.js"></script>

</head>
<body onload="GetScore()">

<!--Game Over Screen -->
<div id="game_over_screen" style="display: block"> 
<h1>Game Over!</h1>

<?php 
// $cookie_score = "score";
//if the score is set and the player id is set then load the info to the server data table game_score
if(isset($_COOKIE["score"])){ //&& isset($_COOKIE["playerid")){

	$playerID = '1';
	$score = $_COOKIE["score"];	
	
	echo "score is set <br />";
	echo $_COOKIE["score"];	
	
	require ('mysqli_connect.php');
		$q = 'INSERT INTO entity_score_th1998726 (player_id, game_score) VALUES (?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ii', $playerID, $score);
		mysqli_stmt_execute($stmt);
	
		// Close this prepared statement:
		mysqli_stmt_close($stmt);
		// Close the database connection.
		mysqli_close($dbc);
	};
?>

<p id="Score"></p>
<button id="start_button" onclick="window.location.href='gamepage.html'">Play Again?</button><br />
<button id="game_over_button" onclick="location.href = 'index.php';" >Back to Title Screen</button>
</div>
</body>
</html>

