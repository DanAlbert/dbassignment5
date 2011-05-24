<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$con = mysql_connect($hostname, $username, $password);

$table = mysql_real_escape_string($_POST['table']);
$query = 'SELECT * FROM ' . $table . ' ORDER BY ENGR ASC;';

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
print "\t\t<Field readonly=\"1\">ID</Field>\n";
print "\t\t<Field type=\"text\">ENGR</Field>\n";
print "\t\t<Field type=\"text\">Name</Field>\n";
print "\t\t<Field type=\"checkbox\">Executive</Field>\n";
print "\t</Fields>\n";

while ($row = mysql_fetch_array($result))
{
	#foreach ($row as $col)
	#{
		print "\t<Row>\n";
		print "\t\t<ID>" . $row['ID'] . "</ID>\n";
		print "\t\t<ENGR>" . $row['ENGR'] . "</ENGR>\n";
		print "\t\t<Name>" . $row['Name'] . "</Name>\n";
		print "\t\t<Executive>" . $row['Executive'] . "</Executive>\n";
		print "\t</Row>\n";
	#}
}

print "</Members>\n";

mysql_close($con);

?>
