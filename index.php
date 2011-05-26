<!DOCTYPE HTML>
<html>
<head>
	<title>CS 275 Assignment 5</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		function newMember()
		{
			var engr = $("div#table-container tbody tr:last-child input[name='ENGR']").val();
			var name = $("div#table-container tbody tr:last-child input[name='Name']").val();
			var exec = $("div#table-container tbody tr:last-child input[name='Executive']:checked").val();
			
			$("span").load("submitMember.php", { engr: engr,  name: name, exec: exec }, function (response, status)
			{
				if (status == "success")
				{
					clearFilter();
					refreshTable();
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
					clearFilter();
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
					clearFilter();
					refreshTable();
				}
			});
		}
		
		function applyFilter()
		{
			$("span").html('&nbsp;');
			var filterExec = $("div#table-container thead input[name=\"Executive\"]:checked").val();
			refreshTable();
		}
		
		function clearFilter()
		{
			$("div#table-container thead input[type=\"checkbox\"]").attr('checked', false);
			$("div#table-container thead input[type!=\"checkbox\"]").val('');
			refreshTable();
		}
		
		function refreshTable()
		{
			var filters = new Array();
			$("div#table-container thead input").each(function ()
			{
				if ($(this).attr("type") == 'checkbox')
				{
					filters.push($(this).attr('checked'));
				}
				else
				{
					filters.push($(this).val());
				}
			});
			
			var filterID = $("div#table-container thead input[name=\"ID\"]").val();
			var filterENGR = $("div#table-container thead input[name=\"ENGR\"]").val();
			var filterName = $("div#table-container thead input[name=\"Name\"]").val();
			var filterExec = $("div#table-container thead input[name=\"Executive\"]:checked").val();
			
			$.ajax({type: "POST",
				url: "getTable.php",
				data: { table: 'Members', ID: filterID, ENGR: filterENGR, Name: filterName, Executive: filterExec },
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
						var field = new Object;
						field.name = $(this).text();
						field.readonly = $(this).attr('readonly');
						field.type = $(this).attr('type');
						fields.push(field);
					});
					
					$("div#table-container").html('<table border="1"><thead></thead><tbody></tbody></table>');
					
					var header = '<tr>';
					var filter = '<tr>';
					for (var i in fields)
					{
						header += '<th>' + fields[i].name + '</th>';
						
						filter += '<td>';
						if (fields[i].type == 'checkbox')
						{
							filter += '<input type="' + fields[i].type + '" name="' + fields[i].name + '" value="1" />';
						}
						else 
						{
							filter += '<input type="' + fields[i].type + '" name="' + fields[i].name + '" />';
						}
						filter += '</td>';
					}
					filter += '<td><button onclick="applyFilter()">Apply Filter</button></td><td><button onclick="clearFilter();">Clear Filter</button></td></tr>';
					header += '<th>Edit</th><th>Delete</th></tr>';

					$("div#table-container thead").append(header);
					$("div#table-container thead").append(filter);
					
					$(xml).find('Row').each(function ()
					{
						var cols = '';
						
						for (var i in fields)
						{
							if (fields[i].readonly == '1')
							{
								cols += '<td>' + $(this).find(fields[i].name).text() + '</td>';
							}
							else
							{
								
								if (fields[i].type == 'checkbox')
								{
									cols += '<td><input type="checkbox" name="' + fields[i].name + '" ';
									
									if ($(this).find(fields[i].name).text() != '0')
									{
										cols += 'checked="checked" ';
									}
									
									cols += 'value="1" /></td>';
								}
								else if (fields[i].type == 'text')
								{
									cols += '<td><input type="text" name="' + fields[i].name + '" value="' + $(this).find(fields[i].name).text() + '" /></td>';
								}
							}
						}
						
						cols += '<td><button onclick="editMember(' + $(this).find('ID').text() + ');">Save Changes</button></td>';
						cols += '<td><button onclick="deleteMember(' + $(this).find('ID').text() + ');">Delete</button></td>';
						
						$("div#table-container tbody").append('<tr id="id' + $(this).find('ID').text() + '">' + cols + '</tr>');
					});
					
					if (	((filterID == '') || (filterID === undefined)) &&
							((filterENGR == '') || (filterENGR === undefined)) &&
							((filterName == '') || (filterName === undefined))&&
							(filterExec === undefined))
					{
						$("div#table-container tbody").append('<tr><td>--</td><td><input type="text" name="ENGR" /></td><td><input type="text" name="Name" /></td>' +
										'<td><input type="checkbox" name="Executive" value="1" /></td>' +
										'<td><button onclick="newMember()">New Member</button></td><td>&nbsp</td></tr>');
					}
					
					var i = 0;
					$("div#table-container thead input").each(function ()
					{
						if ($(this).attr('type') == 'checkbox')
						{
							$(this).attr('checked', filters[i]);
						}
						else
						{
							$(this).val(filters[i]);
						}
						i++;
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
