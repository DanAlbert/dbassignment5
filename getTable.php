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

print '<table border="1">';
print '<thead>';
print '<tr>';
print '<th>ID</th>';
print '<th>ENGR</th>';
print '<th>Name</th>';
print '<th>Exec</th>';
print '<th>Edit</th>';
print '<th>Delete</th>';
print '</tr>';
print '</thead>';
print '<tbody>';

while ($row = mysql_fetch_array($result, MYSQL_NUM))
{
	print '<tr>';
	
	foreach ($row as $col)
	{
		print '<td>' . $col . '</td>';
	}
	
	#print '<td>&nbsp;</td>';
	#print '<td>&nbsp;</td>';
	
	print '<td><button>&nbsp;</button></td>';
	print '<td><button>&nbsp;</button></td>';
	
	print '</tr>';
}

		/*<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button>Edit</button></td>
			<td><button>Delete</button></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button>Edit</button></td>
			<td><button>Delete</button></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button>Edit</button></td>
			<td><button>Delete</button></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><button>Edit</button></td>
			<td><button>Delete</button></td>
		</tr>*/
print '</tbody>';
print '</table>';

mysql_close($con);

?>