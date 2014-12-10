<?php 

	// Set the database access information
    $DB_USER= '48075';
	$DB_PASSWORD= '48075cis12';
	$DB_HOST= '209.129.8.5';
	$DB_NAME= '48075';

	// Make the connection:
	$dbc = @mysqli_connect ($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
	mysqli_set_charset($dbc, 'utf8');
	

?>