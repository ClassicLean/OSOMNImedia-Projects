<?php
	include('connection.php');

	$sql = "SELECT * FROM vendors";
	$result = $conn->query($sql);
 ?>
<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">-->
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
	<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

	<style>
		div.dom_wrapper {
			position: sticky;  /* Fix to the top */
			top: 0;
			padding: 5px;
			background: rgba(255, 255, 255, 1);  /* hide the scrolling table */
		}
	
	</style>
</head>
<body style="padding-top: 15px; padding-right: 20px;">
	<table id="example" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
		<thead style="font-size: 12px">
	    <tr style="max-width:100%; white-space:nowrap; color: #383737">
			<th>Vendor Name</th>
      </tr>
    </thead>
    <tbody style="font-size: 14px;">
<?php
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{?>
			<tr>
	  		<td ><?php echo $row["vendorName"]	?>
				<input type="image" name="view" value="" id="<?php echo $row["vendorID"]; ?>" class="btn btn-info btn-xs view_data" src="images/view.png" style="background: transparent; border: 0px; height: 20px; width: 22px; padding: 3px 5px 0 0; float: right" /></td>
	    </tr>
<?php
    }
	}
?>

	</tbody>
		<tfoot>
      <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
        <th>vendorName</th>
      </tr>
		</tfoot>
	</table>
<?php
	$conn->close();
?>
<br>
</body>
</html>

<div id="dataModal" class="modal fade">
		 <div class="modal-dialog">
					<div class="modal-content">
							 <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Vendor Details</h4>
							 </div>
							 <div class="modal-body" id="vendorDetailID">
							 </div>
							 <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							 </div>
					</div>
		 </div>
</div>

<script>
$(document).ready(function()
{
      $('.view_data').click(function()
      {
	      var vendorIDPHP = $(this).attr("id");
	      $.ajax(
	      {
	            url:"brandSelect.php",
	            method:"post",
	            data:{vendorIDPHP:vendorIDPHP},
	            success:function(data)
	            {
	                  $('#vendorDetailID').html(data);
	                  $('#dataModal').modal("show");
	            }
	      });
      });
});

$(document).ready(function()
{
	let table = $('#example').DataTable(
		{
			dom: 'lBfrtip',
			buttons: [
					{ extend: 'copy', className: 'btn btn-primary glyphicon glyphicon-duplicate' },
				    { extend: 'csv', className: 'btn btn-primary glyphicon glyphicon-save-file' },
				    { extend: 'excel', className: 'btn btn-primary glyphicon glyphicon-list-alt' },
				    { extend: 'pdf', className: 'btn btn-primary glyphicon glyphicon-file' }
			],
			"scrollY": "500px",
			"scrollCollapse": true
	} );
} );

</script>
