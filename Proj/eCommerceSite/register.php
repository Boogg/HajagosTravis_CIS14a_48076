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

    if(empty($_POST["address"])){
    $addressErr = "An address is required";
	$errors++;
  } else{
    $address = test_input($_POST["address"]);
	$address = ucwords(strtolower($address));
    // check if name only contains letters and whitespace
    if (!preg_match("/^([1-9][0-9]* )?([A-Za-z]+ )*([A-Za-z\.]*)$/",$address)) {
      $addressErr = "Invalid address";
	  $errors++;
    };
  };
  
  if (empty($_POST["city"])){
		$cityErr = "City is required";
		$errors++;
  } else{
		$city = test_input($_POST["city"]);
		$city = ucwords(strtolower($city));
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z]+(?:[ '-][a-zA-Z]+)*$/",$city)) {
		  $cityErr = "Invalid city";
		  $errors++;
		};
  };
  
    if (empty($_POST["State"])){
		$stateErr = "State is required";
		$errors++;
	}else{
		$State = $_POST["State"];
	};
  
      if (empty($_POST["zip"])){
    $zipErr = "Zip code is required";
	$errors++;
  } else{
    $zip = test_input($_POST["zip"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^\d{5}(?:[-\s]\d{4})?$/",$zip)) {
      $zipErr = "Invalid zip";
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
			$sql = "SELECT email_address FROM entity_customers_th1998726 WHERE email_address = '$email'";
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
	$sql = "INSERT INTO entity_customers_th1998726 (first_name, last_name, address, city, state, zip_code, phone_number, email_address, password, date) VALUES ('$Fname', '$Lname', '$address', '$city', '$State', '$zip', '$phone', '$email', '$pw1', '$date')";
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

<span class="label">Address:</span><br /><input type='text' name="address" value="<?php echo $address;?>"><span class='error'>*<?php echo $addressErr;?></span><br /><span class='example'>Example: 123 32nd st.</span><br /><br />

<span class="label">City:</span><br /> <input type='text' name="city" value="<?php echo $city;?>"><span class='error'>*<?php echo $cityErr;?></span><br /><span class='example'>Example: Riverside</span><br /><br />

<span class="label">State:</span><br />
<select name='State'>
   <option value=''>Choose a State</option>
   <option value='AK' <?php if ($State == 'AK') echo 'selected'; ?>>Alaska</option>
   <option value='AL' <?php if ($State == 'AL') echo 'selected'; ?>>Alabama</option>
   <option value='AR' <?php if ($State == 'AR') echo 'selected'; ?>>Arkansas</option>
   <option value='AZ' <?php if ($State == 'AZ') echo 'selected'; ?>>Arizona</option>
   <option value='CA' <?php if ($State == 'CA') echo 'selected'; ?>>California</option>
   <option value='CO' <?php if ($State == 'CO') echo 'selected'; ?>>Colorado</option>
   <option value='CT' <?php if ($State == 'CT') echo 'selected'; ?>>Connecticut</option>
   <option value='DC' <?php if ($State == 'DC') echo 'selected'; ?>>District of Columbia</option>
   <option value='DE' <?php if ($State == 'DE') echo 'selected'; ?>>Delaware</option>
   <option value='FL' <?php if ($State == 'FL') echo 'selected'; ?>>Florida</option>
   <option value='GA' <?php if ($State == 'GA') echo 'selected'; ?>>Georgia</option>
   <option value='HI' <?php if ($State == 'HI') echo 'selected'; ?>>Hawaii</option>
   <option value='IA' <?php if ($State == 'IA') echo 'selected'; ?>>Iowa</option>
   <option value='ID' <?php if ($State == 'ID') echo 'selected'; ?>>Idaho</option>
   <option value='IL' <?php if ($State == 'IL') echo 'selected'; ?>>Illinois</option>
   <option value='IN' <?php if ($State == 'IN') echo 'selected'; ?>>Indiana</option>
   <option value='KS' <?php if ($State == 'KS') echo 'selected'; ?>>Kansas</option>
   <option value='KY' <?php if ($State == 'KY') echo 'selected'; ?>>Kentucky</option>
   <option value='LA' <?php if ($State == 'LA') echo 'selected'; ?>>Louisiana</option>
   <option value='MA' <?php if ($State == 'MA') echo 'selected'; ?>>Massachusetts</option>
   <option value='MD' <?php if ($State == 'MD') echo 'selected'; ?>>Maryland</option>
   <option value='ME' <?php if ($State == 'ME') echo 'selected'; ?>>Maine</option>
   <option value='MI' <?php if ($State == 'MI') echo 'selected'; ?>>Michigan</option>
   <option value='MN' <?php if ($State == 'MN') echo 'selected'; ?>>Minnesota</option>
   <option value='MO' <?php if ($State == 'MO') echo 'selected'; ?>>Missouri</option>
   <option value='MS' <?php if ($State == 'MS') echo 'selected'; ?>>Mississippi</option>
   <option value='MT' <?php if ($State == 'MT') echo 'selected'; ?>>Montana</option>
   <option value='NC' <?php if ($State == 'NC') echo 'selected'; ?>>North Carolina</option>
   <option value='ND' <?php if ($State == 'ND') echo 'selected'; ?>>North Dakota</option>
   <option value='NE' <?php if ($State == 'NE') echo 'selected'; ?>>Nebraska</option>
   <option value='NH' <?php if ($State == 'NH') echo 'selected'; ?>>New Hampshire</option>
   <option value='NJ' <?php if ($State == 'NJ') echo 'selected'; ?>>New Jersey</option>
   <option value='NM' <?php if ($State == 'NM') echo 'selected'; ?>>New Mexico</option>
   <option value='NV' <?php if ($State == 'NV') echo 'selected'; ?>>Nevada</option>
   <option value='NY' <?php if ($State == 'NY') echo 'selected'; ?>>New York</option>
   <option value='OH' <?php if ($State == 'OH') echo 'selected'; ?>>Ohio</option>
   <option value='OK' <?php if ($State == 'OK') echo 'selected'; ?>>Oklahoma</option>
   <option value='OR' <?php if ($State == 'OR') echo 'selected'; ?>>Oregon</option>
   <option value='PA' <?php if ($State == 'PA') echo 'selected'; ?>>Pennsylvania</option>
   <option value='PR' <?php if ($State == 'PR') echo 'selected'; ?>>Puerto Rico</option>
   <option value='RI' <?php if ($State == 'RI') echo 'selected'; ?>>Rhode Island</option>
   <option value='SC' <?php if ($State == 'SC') echo 'selected'; ?>>South Carolina</option>
   <option value='SD' <?php if ($State == 'SD') echo 'selected'; ?>>South Dakota</option>
   <option value='TN' <?php if ($State == 'TN') echo 'selected'; ?>>Tennessee</option>
   <option value='TX' <?php if ($State == 'TX') echo 'selected'; ?>>Texas</option>
   <option value='UT' <?php if ($State == 'UT') echo 'selected'; ?>>Utah</option>
   <option value='VA' <?php if ($State == 'VA') echo 'selected'; ?>>Virginia</option>
   <option value='VT' <?php if ($State == 'VT') echo 'selected'; ?>>Vermont</option>
   <option value='WA' <?php if ($State == 'WA') echo 'selected'; ?>>Washington</option>
   <option value='WI' <?php if ($State == 'WI') echo 'selected'; ?>>Wisconsin</option>
   <option value='WV' <?php if ($State == 'WV') echo 'selected'; ?>>West Virginia</option>
   <option value='WY' <?php if ($State == 'WY') echo 'selected'; ?>>Wyoming</option>
</select>
<span class='error'>*<?php echo $stateErr;?></span><br /><br />

<span class="label">Zip Code:</span><br /> <input type='text' name="zip" value="<?php echo $zip;?>"><span class='error'>*<?php echo $zipErr;?></span><br /><span class='example'>Example: 92509</span><br /><br />

<span class="label">Phone Number:</span><br /> <input type='text' name="phone" value="<?php echo $phone;?>"><span class='error'><?php echo $phoneErr;?></span><br /><span class='example'>Example: (951)555-5555</span><br /><br />

<span class="label">E-mail:</span><br /><input type='text' name="email" value="<?php echo $email;?>"><span class="error">*<?php echo $emailErr;?></span><br /><span class='example'>Example: jsmith@email.com</span><br /><br /> 

<span class="label">Password:&nbsp</span><span class='error'>Must contain atleast one number, and both an upper case and lower case letter.</span><br /><input type='password' name="password1"><span class='error'>*<?php echo $pw1Err;?></span><br /><span class='example'>Example: Dog123</span><br /><br />

<span class="label">Retype Password:</span><br /><input type='password' name="password2"><span class='error'>*<?php echo $pw2Err;?></span><br /><br />

<input id="register_input" type='submit' name='submit' value='Register'>

</fieldset>
</form><br />

 <button id="home_button" onclick="window.location.href='index.php'">Back to Main Menu</button>
  </div>
 
<?php include ('includes/footer.html'); ?>
  