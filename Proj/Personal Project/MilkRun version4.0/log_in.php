<!DOCTYPE html>
<html lang="en-US" charset="UTF-8">
<head>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<title>Milk Run</title>  

<!-- Add in style sheets -->
<link rel="stylesheet" type="text/css" href="log_in_stylesheet.css">

</head>
<body>
<?php
//function to "clean" the inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// define variables and set to empty values
$UnameErr = $pw1Err = "";
$Uname =  $pw1 = $pw2 = "";
$errors = 1;
$form = "block";
$thankyou = "none";
//Connection to the server
$servername = "209.129.8.5";
$username = "48075";
$password = "48075cis12";
$dbname = "48075";


//check if each line is filled out correctly
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $errors=0;
  if(empty($_POST["Uname"])){
    $UnameErr = "User name is required";
	$errors++;
  }else{
	$Uname = test_input($_POST["Uname"]);
	//Converts user name to all lowercase
	$Uname = strtolower($Uname);
    //Check if name only contains letters and numbers
    if (!preg_match("/^[a-zA-Z0-9 ]*$/",$Uname)) {
		$UnameErr = "User name or password is incorrect";
		$errors++;
	};
  };
  if (empty($_POST["password1"])){
    $pw1Err = "password is required";
	$errors++;
  }else{
    $pw1 = test_input($_POST["password1"]);
    // check if password contains atleast one letter and one number
    if (!preg_match("/^(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])[a-zA-Z0-9]{6,}$/",$pw1)){
      $UnameErr = "User name or password is incorrect";
	  $errors++;
    };
  };

  if($errors == 0){
	//encrypts the password
	$pw1 = sha1($pw1);
	//Check if username exists already
	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	};
	$sql = "SELECT user_name, password FROM entity_players_th1998726 WHERE user_name = '$Uname'";
	$result = $conn->query($sql);
	//check if there is a match
	if ($result->num_rows == 0){
		$UnameErr = "Invalid User name or password";
		$errors++;
		//close the connection		
		$conn->close();		
	}else{
		while($row = $result->fetch_assoc()){
//			echo $row["password"];
		};
//		if($pw2 != $pw1){
//			$UnameErr = "Invalid User name or password";
//			$errors++;
//			echo "<p>";
//			echo $pw1;
//			echo "<br />";
//			echo $pw2;
//			echo "</p>";
			//close the connection		
//			$conn->close();			
//		};
	};
  };
  
  if($errors == 0){
	//Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		};
		$sql = "SELECT player_id FROM entity_players_th1998726 WHERE user_name = '$Uname'";
		$result = $conn->query($sql);
		//check if there is a match
		if (mysqli_num_rows($result) > 0){
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$playerid = $row["player_id"];
		};
		setcookie('username', $Uname, time()+(86400*2), "/");
		setcookie('playerid', $playerid, time()+(86400*2), "/");
		//Close the connection
		$conn->close();
		$form = "none";
		$thankyou = "block";
	}else{$conn->close();};
  };
};	
	
?>

<div id="log_in">

<form id="main_form" method="POST" style="display:<?php echo $form;?>" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' >

<h1>Please Log In</h1>

<p><span class="error">* required field.</span></p>

<span class="label">User Name:</span><br />
<input name="Uname" type="text" /><span class="error">*<?php echo $UnameErr;?></span></br>
 
<span class="label">Password:</span><br />
<input name="password1" type="password" /><span class="error">*<?php echo $pw1Err;?></span></br></br>
 
<input id="log_in_button" type="submit" value="Log In" >
</form>
<div style="display:<?php echo $thankyou;?>" >
<h1>Thank you, <?php echo $Uname;?></h1>
</div>
<button id="register_button" onclick="window.location.href='register.php'">Register</button>
<button id="back" onclick="window.location.href='index.php'">Back to Main Menu</button>
</div>

<footer style="position:relative; left:20%">Created by Travis Hajagos on 12/08/2014 <a href="mailto:tchajagos@hotmail.com">tchajagos@hotmail.com</a>.</footer>
</body>
</html>