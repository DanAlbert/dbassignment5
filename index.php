<!DOCTYPE HTML>
<html>
<head>
	<title>CS 275 Assignment 5</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function ()
		{
			$("div#table-container").load("getTable.php", { table : 'Members' });
			$("button#new-member").click(function ()
			{
				$("span").load("submitMember.php", { engr : $("input[name='engr']").val(),  name : $("input[name='name']").val() }, function (response, status)
				{
					if (status == "success")
					{
						$("div#table-container").load("getTable.php", { table : 'Members' });
					}
				});
			});
		});
	</script>
</head>

<body>

<h1>Add a new Member</h1>
<span></span>
<div class="form">
	<label for="engr">Engineering Username:</label>
	<input type="text" name="engr" />

	<label for="name">Full Name:</label>
	<input type="text" name="name" />
	
	<button id="new-member">Submit New Member</button>
</div>

<div id="table-container">
</div>

<!--<table border="1">
	<thead>
		<tr>
			<th>ID</th>
			<th>ENGR</th>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
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
	</tbody>
</table>-->

</body>
</html>
