<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$con = mysql_connect($hostname, $username, $password);

$id = mysql_real_escape_string($_POST['id']);
$engr = mysql_real_escape_string($_POST['engr']);
$name = mysql_real_escape_string($_POST['name']);
$exec = mysql_real_escape_string($_POST['exec']);

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
