<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$engr = $_POST['engr'];
$name = $_POST['name'];

$con = mysql_connect($hostname, $username, $password);

if (!$con)
{
	die('Could not open database connection: ' . mysql_error());
}

mysql_select_db($database, $con);

$query = "SELECT * FROM Members WHERE ENGR='" . $engr . "';";

$result = mysql_query($query, $con);
if (mysql_num_rows($result) == 0)
{
	$query = "INSERT INTO Members (ENGR, Name) VALUES ('" . $engr . "', '" . $name . "');";
	
	mysql_query($query, $con);
	print "Member added successfully.";
}
else
{
	print "Member already exists in database.";
}

mysql_close($con);

?>
