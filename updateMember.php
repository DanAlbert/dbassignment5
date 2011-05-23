<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$id = $_POST['id'];
$engr = $_POST['engr'];
$name = $_POST['name'];
$exec = $_POST['exec'];

$con = mysql_connect($hostname, $username, $password);

if (!$con)
{
	die('Could not open database connection: ' . mysql_error());
}

mysql_select_db($database, $con);

$query = "UPDATE Members SET ENGR='" . $engr . "', Name='" . $name . "', Executive='" . $exec . "' WHERE ID='" . $id . "';";

$result = mysql_query($query, $con);
if (mysql_num_rows($result) == 0)
{
	print "Member updated successfully.";
}
else
{
	# Shouldn't ever get here...
	print "updateMember.php:32";
}

mysql_close($con);

?>
