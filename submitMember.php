<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$con = mysql_connect($hostname, $username, $password);

$engr = mysql_real_escape_string($_POST['engr']);
$name = mysql_real_escape_string($_POST['name']);
$exec = mysql_real_escape_string($_POST['exec']);

if (!$con)
{
	die('Could not open database connection: ' . mysql_error());
}

mysql_select_db($database, $con);

$query = "SELECT * FROM Members WHERE ENGR='" . $engr . "';";

$result = mysql_query($query, $con);
if (mysql_num_rows($result) == 0)
{
	$query = "INSERT INTO Members (ENGR, Name, Executive) VALUES ('" . $engr . "', '" . $name . "', '" . $exec . "');";
	
	mysql_query($query, $con);
	print "Member added successfully.";
}
else
{
	print "Member already exists in database.";
}

mysql_close($con);

?>
