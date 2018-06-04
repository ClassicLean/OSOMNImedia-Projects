<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<script type="text/javascript">
	$(document).ready(function()
	{
	    $('#tskuTable').dataTable(
			{				
			});
	} );

	function hide(){
		document.getElementById("wait").style.display = "none";
		document.getElementById("done").style.display = "block";
	}
</script>

</head>
<body style="padding-right: 20px;">

	<h2 style="display: block; padding-left: 15px;"> Potential Trouble SKUs </h2>

	<form method="post" action="export_tsku.php" style="padding: 0px 0 10px 10px;">
		<input type="submit" name="export2" id="export_t" class="btn btn-primary" value="Export as .xls (Excel)" disabled />
	</form>

	<!-- Loading alerts -->
	<div class="alert alert-info fade in alert-dismissible show" style="margin: 0 15px 15px 10px;" id="wait">
			<strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
	</div>

	<div class="alert alert-success fade in alert-dismissible show" style="margin: 0 15px 15px 10px; display: none" id="done">
		<strong>Table completed.</strong> You may now proceed.
	</div>

<?php	
	
	if(isset($_POST["report_tsku"])) {
	
		include('connection.php');

		$sql = "SELECT SKU, productName, `inv-age-0-to-90-days`, `inv-age-91-to-180-days`, `inv-age-181-to-270-days`, `inv-age-271-to-365-days`, `inv-age-365-plus-days`
                FROM
                  products
		   	";                    
		$result = $conn->query($sql);

		echo '<table id="tskuTable" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
				<thead style="font-size: 12px">
		            <tr style="max-width:100%; white-space:nowrap; color: #383737">
		                <th>Inv. Age (0 to 90 days)</th>  
			            <th>Aged Days Total</th>  
			            <th>Product Name</th>  
			            <th>SKU</th>
			            <th>Inv. Age (91 to 180 days)</th>
			            <th>Inv. Age (181 to 270 days)</th>
			            <th>Inv. Age (271 to 365 days)</th>
			            <th>Inv. Age (365 plus days)</th>		            
		            </tr>
		        </thead>
		        <tbody style="font-size: 14px;">';

		if ($result->num_rows > 0) {
			
			echo '<script> document.getElementById("export_t").disabled = false; </script>';

		    while($row = $result->fetch_assoc()) {
				$agedTotal = number_format($row["inv-age-91-to-180-days"]) + number_format($row["inv-age-181-to-270-days"]) + number_format($row["inv-age-271-to-365-days"]) + number_format($row["inv-age-365-plus-days"]);
		    	if($agedTotal != 0){
		    		echo '<tr>
		        		<td>'.$row["inv-age-0-to-90-days"].'</td>
		                <td>'.$agedTotal.'</td>  
		                <td>'.$row["productName"].'</td>  
		                <td>'.$row["SKU"].'</td>  
		                <td>'.$row["inv-age-91-to-180-days"].'</td>  
		                <td>'.$row["inv-age-181-to-270-days"].'</td>
		                <td>'.$row["inv-age-271-to-365-days"].'</td>
		                <td>'.$row["inv-age-365-plus-days"].'</td>	               
		        	</tr>';
		    	}
		    }
		}

		echo '</tbody>
				<tfoot>
		            <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
		                <th>inv-age-0-to-90-days</th>  
			            <th>aged-days-total</th>  
			            <th>product-name</th>  
			            <th>sku</th>
			            <th>inv-age-91-to-180-days</th>
			            <th>inv-age-181-to-270-days</th>
			            <th>inv-age-271-to-365-days</th>
			            <th>inv-age-365-plus-days</th>
		            </tr>
		    		</tfoot>
				</table>';
		$conn->close();

		echo '<script>hide();</script>';
	}
?>

<br><br>
</body>
</html>