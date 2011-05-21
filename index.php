<!DOCTYPE HTML>
<html>
<head>
	<title>CS 275 Assignment 5</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		function refreshTable()
		{
			$.ajax({type: "POST",
				url: "getTable.php",
				data: { table: 'Members' },
				dataType: "xml",
				beforeSend: function()
				{
					$("div#table-container").html("Refreshing table...");
				},
				success: function(xml)
				{
					var fields = new Array();
					$(xml).find('Fields').find('Field').each(function ()
					{
						fields.push($(this).text());
					});
					
					$("div#table-container").html('<table border="1"><thead><tr></tr></thead><tbody></tbody></table>');
					for (var i in fields)
					{
						$("tr").append('<th>' + fields[i] + '</th>');
					}
					
					$(xml).find('Member').each(function ()
					{
						var cols = '';
						
						for (var i in fields)
						{
							cols += '<td>' + $(this).find(fields[i]).text() + '</td>';
						}
						$("tbody").append('<tr>' + cols + '</tr>');
					});
				},
				error: function(xhr)
				{
					alert("Error: " + xhr.status + " " + xhr.statusText);
				}});
		}

		$(document).ready(function ()
		{
			refreshTable();
			$("button#new-member").click(function ()
			{
				$("span").load("submitMember.php", { engr : $("input[name='engr']").val(),  name : $("input[name='name']").val() }, function (response, status)
				{
					if (status == "success")
					{
						refreshTable();
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

</body>
</html>
