<?php
	include('connection.php');

	$sql = "SELECT * FROM brands";
	$result = $conn->query($sql);
 ?>

<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
<style>

	.modal {
    	text-align:center;
		max-height: calc(100vh - 225px);
	}

	.modal-dialog {
	    display: inline-block;
	    width: 90%;
	    max-width: 90%;
	}

	a:visited, a:hover, a:link, a:active {
		color: black;
	}

	.float_center {
		float: right;
		position: relative;
		left: -50%; /* or right 50% */
		text-align: left;
	}

	.center-div {
        margin: 10% auto 0 auto;
        text-align: center;
        width: 50%;
    }

		input.view_data
		{
	    background-image: url("images/view.png");
	    cursor: pointer;
	}

	#brandDetailsTableID {
	  	width:100%;
	}

		div.dom_wrapper {
		position: sticky;  /* Fix to the top */
		top: 0;
		padding: 5px;
		background: rgba(255, 255, 255, 1);  /* hide the scrolling table */
	}

</style>
</head>

<body style="padding-top: 15px; padding-right: 20px;">

	<form action="vendorSelect.php" target="_blank" method="POST">
		<table id="example" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
		<thead style="font-size: 12px">
		<tr style="max-width:100%; white-space:nowrap; color: #383737">
				<th style="width: 5%">Brand ID</th>
				<th>Brand Name</th>
		</tr>
		</thead>
			<tbody style="font-size: 14px;">
			<?php
				if ($result->num_rows > 0) {
		  		while($row = $result->fetch_assoc()) {

			?>
			    <tr>
						<td><?php echo $row["brandID"] ?></td>
		    		<td>
							<?php echo $row["brandName"] ?>
								<button name="view" value="<?php echo $row["vendorID"] ?>" style="background: transparent; border: 0px; height: 20px; width: 22px; padding: 3px 5px 0 0; float: right"><img src="images/view.png" style="background: transparent; border: 0px; height: 20px; width: 22px; padding: 3px 5px 0 0; float: right"/></button>
						</td>

			  	</tr>
			<?php
				}
			}
			?>
			</tbody>
			<tfoot>
		  <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee">
					<th>Brand ID</th>
		    		<th>Brand Name</th>
				</tr>
			</tfoot>
		</table>
	</form>

<?php
	$conn->close();
?>

<br>
</body>
</html>

<script>

'use strict';

$(document).ready(function()
{
	let table = $('#example').DataTable(
		{
			dom: 'lBfrtip',
			buttons: [
					'copy', 'csv', 'excel', 'pdf'
			],
			"scrollY": "500px",
			"scrollCollapse": true
		})
});

</script>
