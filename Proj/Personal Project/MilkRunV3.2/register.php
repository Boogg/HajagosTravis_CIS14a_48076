<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Register</title>
<link rel="stylesheet" type="text/css" href="log_in_stylesheet.css">
</head>
<body>
<h1>Register To Save Your Scores</h1>
<?php echo "this";
?>
<script type="text/javascript">
function validateForm() {
	var un = document.forms["registrationForm"]["Uname"].value;
    if (un==null || un=="") {
        alert("User name must be filled out");
		return false;
    }
    var fn = document.forms["registrationForm"]["Fname"].value;
    if (fn==null || fn=="") {
        alert("First name must be filled out");
        return false;
    }
	var ln = document.forms["registrationForm"]["Lname"].value;
    if (ln==null || ln=="") {
        alert("Last name must be filled out");
        return false;
    }
	 var pw1 = document.forms["registrationForm"]["password1"].value;
    if (pw1 ==null || pw1 =="") {
        alert("You must choose a password");
        return false;
    }
	var pw2 = document.forms["registrationForm"]["password2"].value;
    if (pw2 ==null || pw2 =="" || pw1 != pw2) {
        alert("Please retype the password");
        return false;
    }
	var eml = document.forms["registrationForm"]["email"].value;
}
 </script>

<p><span class='error'>* required field.</span></p>
<form name='registrationForm' method='POST'  onsubmit='validateForm()'>
User Name:<br /> <input type='text' name='Uname' ><span class='error'>*</span><br /><span class='example'>Example: Goldleader</span><br /><br />
First Name: <br /><input type='text' name='Fname'><span class='error'>*</span><br /><span class='example'>Example: John</span><br /><br />
Last Name:<br /> <input type='text' name='Lname'><span class='error'>*</span><br /><span class='example'>Example: Smith</span><br /><br />
E-mail: <br /><input type='text' name='email'><br /><span class='example'>Example: jsmith@email.com</span><br /><br />
Password: &nbsp <span class='error'>Must be 6-12 characters with at least 1 number and one letter. Case sensitive.</span><br /><input type='password' name='password1'><span class='error'>*</span><br /><span class='example'>Example: Dog123</span><br /><br />
Retype Password:<br /><input type='password' name='password2'><span class='error'>*</span><br /><br /><input type='submit' name='submit' value='Register'>
 </form>
 <button id="home_button" onclick="window.location.href='index.php'">Back to Title Screen</button>
 
</body>
</html>