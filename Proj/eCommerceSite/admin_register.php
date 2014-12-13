<?php

$page_title = 'Register';
include ('includes/header.html');


//function to "clean" the inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
};

// define variables and set to empty values
$FnameErr = $LnameErr = $addressErr = $cityErr = $stateErr = $zipErr = $phoneErr = $emailErr = $pw1Err = $pw2Err = "";
$Fname = $Lname = $address = $city = $State = $zip = $phone = $email = $pw1 = $pw2 = "";
$errors = 1;
$form = "block";
$thankyou = "none";
//Connection to the server
$servername = "209.129.8.5";
$username = "48075";
$password = "48075cis12";
$dbname = "48075";
$date= "";
//check if each line is filled out correctly
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$errors=0;
	
  if (empty($_POST["Fname"])){
    $FnameErr = "First Name is required";
	$errors++;
  } else {
    $Fname = test_input($_POST["Fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$Fname)) {
      $FnameErr = "Only letters and white space allowed";
	  $errors++;
    };
  };

  if (empty($_POST["Lname"])){
    $LnameErr = "Last Name is required";
	$errors++;
  } else {
    $Lname = test_input($_POST["Lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$Lname)) {
      $LnameErr = "Only letters and white space allowed";
	  $errors++;
    };
  };
  
  if (empty($_POST["email"])){
	$emailErr = "Your email address is required";
  } else{
		$email = test_input($_POST["email"]);
		$email = strtolower($email);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
			$errors++;
		}else{
			//Check if email is taken already
			//Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error){
				die("Connection failed: " . $conn->connect_error);
			};
			$sql = "SELECT email_address FROM entity_admin_th1998726 WHERE email_address = '$email'";
			$result = $conn->query($sql);
			//check if there is a match
			if ($result->num_rows > 0){
				$emailErr = "That email is already registered";
				$errors++;
			};
			//close the connection
			$conn->close();  
		};
  };

   if (empty($_POST["password1"])){
    $pw1Err = "password is required";
	$errors++;
  }else{
    $pw1 = test_input($_POST["password1"]);
    // check if password contains atleast one letter and one number
    if (!preg_match("/^(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])[a-zA-Z0-9]{6,}$/",$pw1)) {
      $pw1Err = "Invalid password";
	  $errors++;
    };
  };
  
	if(empty($_POST["password2"])){
		$pw2Err = "please retype the password";
		$errors++;
	} else{
		$pw2 = test_input($_POST["password2"]);
		if($pw2 != $pw1){
			$pw2Err = "Passwords did not match";
			$errors++;
		};
	};
};


if($errors == 0){
	$date= date("m/d/y");
	//encrypts the password
	$pw1 = sha1($pw1);
	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	};
	//insert values into table
	$sql = "INSERT INTO entity_admin_th1998726 (first_name, last_name, email_address, password) VALUES ('$Fname', '$Lname', '$email', '$pw1')";
	//If the upload was successful
	if ($conn->query($sql) === TRUE){
		$form = "none";
		$thankyou = "block";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	};
	//Close the connection
	$conn->close();
	
};

?>
<div id="register_form" ><br />
<h1 style="display:<?php echo $thankyou;?>">Thank you for registering, please navigate to the Main Menu to log in</h1>
<form id="main_form" name='registrationForm' method='POST'  onsubmit="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:<?php echo $form;?>">
<fieldset>
<br />
<legend>Register To Save Your Scores</legend>

<span class='error'>* required field.</span><br /><br />

<span class="label">First Name:</span><br /><input type='text' name="Fname" value="<?php echo $Fname;?>"><span class='error'>*<?php echo $FnameErr;?></span><br /><span class='example'>Example: John</span><br /><br />

<span class="label">Last Name:</span><br /><input type='text' name="Lname" value="<?php echo $Lname;?>"><span class='error'>*<?php echo $LnameErr;?></span><br /><span class='example'>Example: Smith</span><br /><br />

<span class="label">E-mail:</span><br /><input type='text' name="email" value="<?php echo $email;?>"><span class="error">*<?php echo $emailErr;?></span><br /><span class='example'>Example: jsmith@email.com</span><br /><br /> 

<span class="label">Password:&nbsp</span><span class='error'>Must contain atleast one number, and both an upper case and lower case letter.</span><br /><input type='password' name="password1"><span class='error'>*<?php echo $pw1Err;?></span><br /><span class='example'>Example: Dog123</span><br /><br />

<span class="label">Retype Password:</span><br /><input type='password' name="password2"><span class='error'>*<?php echo $pw2Err;?></span><br /><br />

<input id="register_input" type='submit' name='submit' value='Register'>

</fieldset>
</form><br />

 <button id="home_button" onclick="window.location.href='index.php'">Back to Main Menu</button>
  </div>
 
<?php include ('includes/footer.html'); ?>
  