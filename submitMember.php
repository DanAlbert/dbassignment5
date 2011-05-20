<?php

$engr = mysql_real_escape_string($_REQUEST['engr']);
$name = mysql_real_escape_string($_REQUEST['name']);

$con = mysql_connect($host, $user, $pass);

if (!$con)
{
	die('Could not open database connection: ' . mysql_error());
}

mysql_select_db($db, $con);

$query = "INSERT INTO Members (ENGR, Name) VALUES ('" . $engr . "', '" . $name . "');";

$result = mysql_query($query, $con);

mysql_close($con);

?>
