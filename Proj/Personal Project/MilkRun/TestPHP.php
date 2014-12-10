//check email
\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b

//check password has more than 6 characters and contains atleast 1 letter and one number
/^(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])[a-zA-Z0-9]{6,}$/



//connect to the datatbase
<?php 
	// Connects to your Database 
	mysql_connect("localhost", "username", "password") or die(mysql_error());
	mysql_select_db("Database_Name") or die(mysql_error());
 
// Collects data from "friends" table 
$data = mysql_query("SELECT * FROM friends") or die(mysql_error());

// puts the "friends" info into the $info array 
$info = mysql_fetch_array( $data ); 

// Print out the contents of the entry 
Print "<b>Name:</b> ".$info['name'] . " "; 
Print "<b>Pet:</b> ".$info['pet'] . " <br>";


while($info = mysql_fetch_array( $data )) {
	Print "<b>Name:</b> ".$info['name'] . " "; 
	Print "<b>Pet:</b> ".$info['pet'] . " <br>";
};

//picking what data you want
"Select * From friends WHERE pet='Cat'"


//insert into tables
<?php // Connects to your Database 
mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error()); mysql_select_db("Database_Name") or die(mysql_error()); 
mysql_query("INSERT INTO tablename VALUES ( 'Bill', 29, 'Ford' ), ( 'Mike', 16, 'Beetle' ), ( 'Alisa', 36, 'Van' )"); 


//closing SQL
<?php 
 $link = mysql_connect('localhost', 'mysql_user', 'mysql_password') ; 
 if (!$link) 
 { 
 die(mysql_error()) ; 
 } 
 print 'You are connected'; 
 mysql_close($link) ; 
 ?> 

