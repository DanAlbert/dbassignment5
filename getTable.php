<?php

/*$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';*/

$hostname = 'mysql.cs.orst.edu';
$database = 'albertd';
$username = 'albertd';
$password = '6106';

$con = mysql_connect($hostname, $username, $password);
if (!$con)
{
	die('Unable to connect to database server: ' . mysql_error());
}

$table = mysql_real_escape_string($_POST['table']);
$id = mysql_real_escape_string($_POST['ID']);
$engr = mysql_real_escape_string($_POST['ENGR']);
$name = mysql_real_escape_string($_POST['Name']);
$exec = mysql_real_escape_string($_POST['Executive']);

$query = 'SELECT * FROM ' . $table;
$filters = '';

if ($id != '')
{
	$filters .= " ID='" . $id . "'";
}

if ($engr != '')
{
	if ($filters != '')
	{
		$filters .= ' AND';
	}
	$filters .= " ENGR LIKE '%" . $engr . "%'";
}

if ($name != '')
{
	if ($filters != '')
	{
		$filters .= ' AND';
	}
	$filters .= " Name LIKE '%" . $name . "%'";
}

if ($exec != '')
{
	if ($filters != '')
	{
		$filters .= ' AND';
	}
	$filters .= " Executive='" . $exec . "'";
}

if ($filters != '')
{
	$query .= ' WHERE' . $filters;
}

$query .= ' ORDER BY ENGR ASC;';

mysql_select_db($database, $con);
$result = mysql_query($query, $con);

header("Content-Type: text/xml");

print '<?xml version="1.0" ?>' . "\n";
print "<Members>\n";
print "\t<Fields>\n";
print "\t\t<Field readonly=\"1\">ID</Field>\n";
print "\t\t<Field type=\"text\">ENGR</Field>\n";
print "\t\t<Field type=\"text\">Name</Field>\n";
print "\t\t<Field type=\"checkbox\">Executive</Field>\n";
print "\t</Fields>\n";

while ($row = mysql_fetch_array($result))
{
		print "\t<Row>\n";
		print "\t\t<ID>" . $row['ID'] . "</ID>\n";
		print "\t\t<ENGR>" . $row['ENGR'] . "</ENGR>\n";
		print "\t\t<Name>" . $row['Name'] . "</Name>\n";
		print "\t\t<Executive>" . $row['Executive'] . "</Executive>\n";
		print "\t</Row>\n";
}

print "</Members>\n";

mysql_close($con);

?>
