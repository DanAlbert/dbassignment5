<?php

$hostname = 'mysql.gingerhq.net';
$database = 'osugds';
$username = 'osugds';
$password = 'CUUh7N4aUWDJR2rF';

$table = $_POST['table'];
$query = 'SELECT * FROM ' . $table . ';';

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

print '<Members>';
print '<Fields>';
print '<Field>ID</Field>';
print '<Field>ENGR</Field>';
print '<Field>Name</Field>';
print '<Field>Exec</Field>';
print '</Fields>';

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	foreach ($row as $col)
	{
		print '<Member>';
		print '<ID>' . $row['ID'] . '</ID>';
		print '<ENGR>' . $row['ENGR'] . '</ID>';
		print '<Name>' . $row['Name'] . '</ID>';
		print '<Exec>' . $row['Exec'] . '</ID>';
		print '</Member>';
	}
}

print '</Members>';

mysql_close($con);

?>