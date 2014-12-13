<?php 
$page_title = 'New Product';
include ('./includes/header.html');
?>
<?php

//function to "clean" the inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
};

$errors = 1;
$form = "block";
$thankyou = "none";

//Connection to the server
$servername = "209.129.8.5";
$username = "48075";
$password = "48075cis12";
$dbname = "48075";

$fileName= $Pname= $price= $desc= "";
$PnameErr= $priceErr= $fileErr= $descErr= "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST["Pname"])){
    $PnameErr = "Product Name is required";
	$errors++;
  } else {
    $Pname = test_input($_POST["Pname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z0-9\-_\s]+$/",$Pname)){
      $PnameErr = "Only letters and white space allowed";
	  $errors++;
    };
  };

  if (empty($_POST["price"])){
    $priceErr = "A price is required";
	$errors++;
  } else {
    $price = test_input($_POST["price"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]+(?:\.[0-9]{2,})?$/",$price)) {
      $priceErr = "Only numbers allowed";
	  $errors++;
    };
  };

    if (empty($_POST["desc"])){
    $descErr = "A description is required";
	$errors++;
  } else {
    $desc = test_input($_POST["desc"]);
  };
  
  if(empty($_FILES["upload"])){
	$errors++;
	$fileErr= "You must add an image";
  }else{
	$fileName= "uploads/".$_FILES['upload']['name'];
  };
  
	// Check for an uploaded file:
	if (isset($_FILES['upload'])) {
		
		// Validate the type. Should be JPEG or PNG.
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
		if (in_array($_FILES['upload']['type'], $allowed)) {
		
			// Move the file over.
			if (move_uploaded_file ($_FILES['upload']['tmp_name'], "./uploads/{$_FILES['upload']['name']}")) {
//				$fileName="uploads/".$_FILES['upload']['name'];
				echo '<p><em>The file has been uploaded!</em></p>';
			} 
			
		} else { // Invalid type.
			echo '<p class="error">Please upload a JPEG or PNG image.</p>';
		}
	} 
	// Check for an error:
	if ($_FILES['upload']['error'] > 0) {
		echo '<p class="error">The file could not be uploaded because: <strong>';
		$errors++;
		// Print a message based upon the error.
		switch ($_FILES['upload']['error']) {
			case 1:
				print 'The file exceeds the upload_max_filesize setting in php.ini.';
				break;
			case 2:
				print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
				break;
			case 3:
				print 'The file was only partially uploaded.';
				break;
			case 4:
				print 'No file was uploaded.';
				break;
			case 6:
				print 'No temporary folder was available.';
				break;
			case 7:
				print 'Unable to write to the disk.';
				break;
			case 8:
				print 'File upload stopped.';
				break;
			default:
				print 'A system error occurred.';
				break;
		}
		
		print '</strong></p>';
	
	} 
	// Delete the file if it still exists:
	if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
		unlink ($_FILES['upload']['tmp_name']);
	}	
}

if($errors == 0){
	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	};
	//insert values into table
	$sql = "INSERT INTO entity_products_th1998726 (product_name, product_price, product_description, product_img) VALUES ('$Pname', '$price', '$desc', '$fileName')";
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

<div style="width:500px; display:<?php echo $adminShow;?>">

	<h1>Administrator</h1><br />
	<div style="display:<?php echo $form?>">
	<form enctype="multipart/form-data" onsubmit="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	
		<span class="title">Product Name:</span><input type="text" name="Pname" value="<?php echo $Pname;?>"/><span class="error">*<?php echo $PnameErr;?></span><br /><br />
		
		<span class="title">Product Price:</span><input type="text" name="price" value="<?php echo $price;?>" /><span class="error">*<?php echo $priceErr;?></span><br /><br />
		
		<span class="title">Product Description:</span><input type="text" name="desc" value="<?php echo $desc;?>" cols="30" rows="5" /><span class="error">*<?php echo $descErr;?></span><br /><br />

		<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
		<fieldset><legend>Select a JPEG or PNG image of 512KB or smaller to be uploaded:</legend>
		<p><span class="title">File:</span> <input type="file" name="upload" /></p>
		</fieldset><span class="error">*</span><br /><br />
	
		<div align="center"><input type="submit" name="submit" value="Submit" /></div>

	</form>
	</div>
	<div style="display:<?php echo $thankyou;?>">
	<h1>Product added.</h1>
	<button onclick="location.href='new_product.php' ">Add another Product</button>
	</div>
</div>
<div style=" display:<?php echo $customerShow;?>">
<p>You have navigated here in error. Please return to the <a href="index.php">Home Page</a>.<p>


<?php
include ('./includes/footer.html');
?>