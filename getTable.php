<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$table = $_POST['table'];
$query = 'SELECT * FROM ' . $table . ' ORDER BY ENGR ASC;';

$con = mysql_connect($hostname, $username, $password);

if (!$con)
{
	die('Unable to connect to database server: ' . mysql_error());
}

mysql_select_db($database, $con);
$result = mysql_query($query, $con);
if (mysql_num_rows($result) == 0)
{
	die('Empty table');
}

header("Content-Type: text/xml");

print '<?xml version="1.0" ?>' . "\n";
print "<Members>\n";
print "\t<Fields>\n";
print "\t\t<Field>ID</Field>\n";
print "\t\t<Field>ENGR</Field>\n";
print "\t\t<Field>Name</Field>\n";
print "\t\t<Field>Executive</Field>\n";
print "\t</Fields>\n";

while ($row = mysql_fetch_array($result))
{
	#foreach ($row as $col)
	#{
		print "\t<Row>\n";
		print "\t\t<ID readonly=\"1\">" . $row['ID'] . "</ID>\n";
		print "\t\t<ENGR type=\"text\">" . $row['ENGR'] . "</ENGR>\n";
		print "\t\t<Name type=\"text\">" . $row['Name'] . "</Name>\n";
		print "\t\t<Executive type=\"checkbox\">" . $row['Executive'] . "</Executive>\n";
		print "\t</Row>\n";
	#}
}

print "</Members>\n";

mysql_close($con);

?>
