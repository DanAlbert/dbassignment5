<!DOCTYPE HTML>
<html>
<head>
	<title>CS 275 Assignment 5</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		function deleteMember(id)
		{
			$("span").load("deleteMember.php", { id: id }, function (response, status)
			{
				if (status == "success")
				{
					refreshTable();
				}
			});
		}
		
		function editMember(id)
		{
			var engr;
			var name;
			var exec;
			
			engr = $("tr#id" + id).children("td:nth-child(2)").children("input").first().val();
			name = $("tr#id" + id).children("td:nth-child(3)").children("input").first().val();
			exec = $("tr#id" + id).children("td:nth-child(4)").children("input:checked").val();
			
			$("span").load("updateMember.php", { id: id, engr: engr,  name: name, exec: exec }, function (response, status)
			{
				if (status == "success")
				{
					refreshTable();
				}
			});
		}
		
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
					
					$("tr").append('<th>Edit</th>');
					$("tr").append('<th>Delete</th>');
					
					$(xml).find('Row').each(function ()
					{
						var cols = '';
						
						for (var i in fields)
						{
							if ($(this).find(fields[i]).attr('readonly') == '1')
							{
								cols += '<td>' + $(this).find(fields[i]).text() + '</td>';
							}
							else
							{
								if ($(this).find(fields[i]).attr('type') == 'checkbox')
								{
									cols += '<td><input type="checkbox" ';
									
									if ($(this).find(fields[i]).text() != '0')
									{
										cols += 'checked="checked" ';
									}
									
									cols += 'value="1" /></td>';
								}
								else if ($(this).find(fields[i]).attr('type') == 'text')
								{
									cols += '<td><input type="text" value="' + $(this).find(fields[i]).text() + '" /></td>';
								}
							}
						}
						
						cols += '<td><button onclick="editMember(' + $(this).find('ID').text() + ');">Save Changes</button></td>';
						cols += '<td><button onclick="deleteMember(' + $(this).find('ID').text() + ');">Delete</button></td>';
						$("tbody").append('<tr id="id' + $(this).find('ID').text() + '">' + cols + '</tr>');
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
				$("span").load("submitMember.php", { engr: $("input[name='engr']").val(),  name: $("input[name='name']").val(), exec: $("input#exec:checked").val() }, function (response, status)
				{
					if (status == "success")
					{
						refreshTable();
						$("input[name='engr']").val('');
						$("input[name='name']").val('');
						$("input#exec']").attr('checked', false);
					}
				});
			});
		});
	</script>
</head>

<body>

<h1>Add a new Member</h1>
<span>&nbsp;</span>
<div class="form">
	<label for="engr">Engineering Username:</label>
	<input id="engr" type="text" name="engr" />

	<label for="name">Full Name:</label>
	<input id="name" type="text" name="name" />
	
	<input id="exec" type="checkbox" name="exec" value="1" /><label class="inline" for="exec">Executive</label><br />
	
	
	<button id="new-member">Submit New Member</button>
</div>

<div id="table-container">
</div>

</body>
</html>
