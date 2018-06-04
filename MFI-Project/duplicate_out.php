<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">

	$(document).ready(function()
	{
	    $('#example').dataTable(
			{
				"initComplete": function( settings, json )
				{
					alert( 'The table has finished its initialisation.' );
				}
			});
	} );

	function hide(){
		document.getElementById("wait").style.display = "none";
		document.getElementById("done").style.display = "block";
	}

</script>

<!-- EXTERNAL CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

</script>

</head>
<body style="padding-top: 15px; padding-right: 20px;" id='body'>

<?php
	include('connection.php');

	echo '<div class="alert alert-info fade in alert-dismissible show" style="margin: 5px 15px 15px 15px;" id="wait">
			<strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
	</div>';

	echo '<div class="alert alert-success fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="done">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true" style="font-size:20px">&times;</span> </button>
			<strong>Table completed.</strong> You may now proceed.
		</div>';

	$dup = FALSE;
	$zero = FALSE;

	$sql = "SELECT COUNT(SKU) as count, `afn-total-quantity`, vendorName, brandName, SKU, MFR, productName, productID, FNSKU, new_cost
				FROM
					products
					INNER JOIN brands
						ON products.brandID = brands.brandID
					INNER JOIN vendors
						ON brands.vendorID = vendors.vendorID
				GROUP BY
					SKU
				HAVING
					count > 1";
	$result = $conn->query($sql);

	// Out of stock or Zero-priced
	$sql2 = "SELECT `afn-total-quantity`, vendorName, brandName, SKU, MFR, productName, productID, FNSKU, new_cost
				FROM
					products
					INNER JOIN brands
						ON products.brandID = brands.brandID
					INNER JOIN vendors
						ON brands.vendorID = vendors.vendorID
					WHERE
						(`afn-total-quantity` = 0 OR new_cost = 0) AND
						vendorName LIKE '2%'";
	$result2 = $conn->query($sql2);

	if ($result->num_rows > 0 && $result2->num_rows > 0 ){														// Both
		echo '<h2 style="padding: 20px 0 20px 12px"> Duplicates and Out of Stock </h2>';
		$sql = "SELECT COUNT(SKU) as count, `afn-total-quantity`, vendorName, brandName, SKU, MFR, productName, productID, FNSKU, new_cost
				FROM
					products
					INNER JOIN brands
						ON products.brandID = brands.brandID
					INNER JOIN vendors
						ON brands.vendorID = vendors.vendorID
				WHERE
					`afn-total-quantity` = 0 OR new_cost = 0
				GROUP BY
					SKU
				HAVING
					count > 1";
		$dup = TRUE; $zero = TRUE;
	}
	else if ($result->num_rows > 0){																			// Duplicate
		echo '<h2 style="padding: 20px 0 20px 12px"> Duplicates </h2>';		
		$dup = TRUE;
	}
	else if ($result2->num_rows > 0){																			// Out of Stock
		echo '<h2 style="padding: 20px 0 20px 12px"> Out of stock or Zero-priced </h2>';	
		$zero = TRUE;
		$sql = $sql2;
	}

	$result = $conn->query($sql);
	
	echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
			<thead style="font-size: 12px">
	            <tr style="max-width:100%; white-space:nowrap; color: #383737">
	                <th># of Copies</th>
	                <th>Stock</th>
	                <th>Vendor Name</th>
	                <th>Brand</th>
	                <th>SKU</th>
	                <th>MFR#</th>
	                <th>Product Name</th>
	                <th>Product ID</th>
	                <th>FNSKU</th>
	                <th>New Cost</th>
	            </tr>
	        </thead>
	        <tbody style="font-size: 14px;">';

	// Duplicate
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	echo '<tr>';
	    		
	    		if ($dup == TRUE){
	    			echo '<td style="background: #f2dede">' . $row["count"] . '</td>';
	    		}
	    		else {
	    			echo '<td> 0 </td>';
	    		}

	    		if ($zero == TRUE){
	    			echo '<td style="background: #fff3cd">' . $row["afn-total-quantity"] . '</td>';
	    		}
	    		else {
	    			echo '<td> 0 </td>';
	    		}
	    	
	    	echo '
	        		<td>' . $row["vendorName"] . '</td>
	        		<td>' . $row["brandName"] . '</td>
	        		<td>' . $row["SKU"] . '</td>
	        		<td>' . $row["MFR"] . '</td>
	        		<td>' . $row["productName"] . '</td>
	        		<td>' . $row["productID"] . '</td>
	        		<td>' . $row["FNSKU"] . '</td> ';

				if ($row["new_cost"] == 0){
	    			echo '<td style="background: #fff3cd">' . $row["new_cost"] . '</td>';
	    		}
	    		else {
	    			echo '<td>' . $row["new_cost"] . '</td>';
	    		}

	    	echo '</tr>';
	    }
	}

	echo '</tbody>
			<tfoot>
	            <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
	                <th># of Copies</th>
	                <th>Stock</th>
	                <th>Vendor Name</th>
	                <th>Brand</th>
	                <th>SKU</th>
	                <th>MFR#</th>
	                <th>Product Name</th>
	                <th>Product ID</th>
	                <th>FNSKU</th>
	                <th>New Cost</th>
	            </tr>
        		</tfoot>
			</table>';

	$conn->close();
?>

<script>hide();</script>

<br>
</body>
</html>