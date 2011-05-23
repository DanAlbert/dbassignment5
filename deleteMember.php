<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$id = $_POST['id'];

$con = mysql_connect($hostname, $username, $password);

if (!$con)
{
	die('Could not open database connection: ' . mysql_error());
}

mysql_select_db($database, $con);

$query = "DELETE FROM Members WHERE ID='" . $id . "';";

$result = mysql_query($query, $con);
if (mysql_num_rows($result) == 0)
{
	print "Member deleted successfully.";
}
else
{
	# Shouldn't ever get here...
	print "Member does not exist in database.";
}

mysql_close($con);

?>
