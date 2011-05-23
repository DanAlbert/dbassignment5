<!DOCTYPE HTML>
<html>
<head>
	<title>CS 275 Assignment 5</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		function newMember()
		{
			$("span").load("submitMember.php", { engr: $("tr:last-child input[name='ENGR']").val(),  name: $("tr:last-child input[name='Name']").val(), exec: $("tr:last-child input[name='Executive']:checked").val() }, function (response, status)
			{
				if (status == "success")
				{
					refreshTable();
					$("input[name='engr']").val('');
					$("input[name='name']").val('');
					$("input#exec']").attr('checked', false);
				}
			});
		}
		
		function editMember(id)
		{
			var engr = $("tr#id" + id + ' input[name="ENGR"]').val();
			var name = $("tr#id" + id + ' input[name="Name"]').val();
			var exec = $("tr#id" + id + ' input[name="Executive"]:checked').val();
			
			$("span").load("updateMember.php", { id: id, engr: engr,  name: name, exec: exec }, function (response, status)
			{
				if (status == "success")
				{
					refreshTable();
				}
			});
		}
		
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
									cols += '<td><input type="checkbox" name="' + fields[i] + '" ';
									
									if ($(this).find(fields[i]).text() != '0')
									{
										cols += 'checked="checked" ';
									}
									
									cols += 'value="1" /></td>';
								}
								else if ($(this).find(fields[i]).attr('type') == 'text')
								{
									cols += '<td><input type="text" name="' + fields[i] + '" value="' + $(this).find(fields[i]).text() + '" /></td>';
								}
							}
						}
						
						cols += '<td><button onclick="editMember(' + $(this).find('ID').text() + ');">Save Changes</button></td>';
						cols += '<td><button onclick="deleteMember(' + $(this).find('ID').text() + ');">Delete</button></td>';
						
						$("tbody").append('<tr id="id' + $(this).find('ID').text() + '">' + cols + '</tr>');
					});
					
					$("tbody").append('<tr><td>--</td><td><input type="text" name="ENGR" /></td><td><input type="text" name="Name" /></td>' +
									'<td><input type="checkbox" name="Executive" value="1" /></td>' +
									'<td><button onclick="newMember()">New Member</button></td><td>&nbsp</td></tr>');
				},
				error: function(xhr)
				{
					alert("Error: " + xhr.status + " " + xhr.statusText);
				}});
		}

		$(document).ready(function ()
		{
			refreshTable();
		});
	</script>
</head>

<body>

<h1>Members</h1>
<span>&nbsp;</span>

<div id="table-container">
</div>

</body>
</html>
