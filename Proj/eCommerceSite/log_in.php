<?php # Script 3.4 - index.php
$page_title = 'Junk.com!';
include ('./includes/header.html');
?>

<?php
//function to "clean" the inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// define variables and set to empty values
$emailErr = $pw1Err = "";
$email = $Fname = $customer = $pw1 = $pw2 = "";
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
  if(empty($_POST["email"])){
    $emailErr = "Email is required";
	$errors++;
  }else{
	$email = test_input($_POST["email"]);
	//Converts user name to all lowercase
	$email = strtolower($email);
    //Check if name only contains letters and numbers
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$emailErr = "Email or password is incorrect";
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
      $emailErr = "User name or password is incorrect";
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
	$sql = "SELECT email_address, password FROM entity_customers_th1998726 WHERE email_address = '$email'";
	$result = $conn->query($sql);
	//check if there is a match
	if ($result->num_rows == 0){
		$emailErr = "Invalid email or password";
		$errors++;
		//close the connection		
		$conn->close();		
	}else{
		while($row = $result->fetch_assoc()){
			$pw2= $row["password"];
		};
		if($pw2 != $pw1){
			$emailErr = "Invalid email or password";
			$errors++;
			echo "<p>";
			echo $pw1;
			echo "<br />";
			echo $pw2;
			echo "</p>";
			//close the connection		
			$conn->close();			
		};
	};
  };
  
  if($errors == 0){
	//Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		};
		$sql = "SELECT customer_id, first_name FROM entity_customers_th1998726 WHERE email_address = '$email'";
		$result = $conn->query($sql);
		//check if there is a match
		if (mysqli_num_rows($result) > 0){
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$customer = $row["customer_id"];
			$Fname = $row["first_name"];
		};
		setcookie('email', $email, time()+(86400*2), "/");
		setcookie('customer_id', $customer, time()+(86400*2), "/");
		setcookie('first_name', $Fname, time()+(86400*2), "/");
		//Close the connection
		$conn->close();
		$form = "none";
		$thankyou = "block";
	}else{$conn->close();};
  };
};	
	
?>

<div id="log_in" style="display:<?php echo $form;?>">

<form id="main_form" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' >

<h1>Please Log In</h1>

<p><span class="error">* required field.</span></p>

<span class="label">Email:</span><br />
<input name="email" type="text" /><span class="error">*<?php echo $emailErr;?></span></br>
 
<span class="label">Password:</span><br />
<input name="password1" type="password" /><span class="error">*<?php echo $pw1Err;?></span></br></br>
 
<input id="log_in_button" type="submit" value="Log In" >

</form>
<button id="register_button" onclick="window.location.href='register.php'">Register</button>
</div>


<div style="display:<?php echo $thankyou;?>" >
<h1>Thank you, <?php echo $Fname;?></h1>

<button id="back" onclick="window.location.href='index.php'">Back to Main Menu</button>
</div>

<?php
include ('./includes/footer.html');
?>