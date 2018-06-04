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

	$(document).ready(function() {
	    $('#example').dataTable({ });
	}

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

	<!-- Loading alerts -->
	<div class="alert alert-info fade in alert-dismissible show" style="margin: 5px 15px 15px 15px;" id="wait">
		<strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
	</div>

	<div class="alert alert-success fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="done">
		<strong>Table completed.</strong> You may now proceed.
	</div>

<?php
	
	include('connection.php');

	$sql = "SELECT *, COUNT(SKU) as count,
			FROM products
			GROUP BY SKU
			HAVING count > 1
			";
	$result = $conn->query($sql);
	
	echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
			<thead style="font-size: 12px">
	            <tr style="max-width:100%; white-space:nowrap; color: #383737">
	                <th># of Copies</th>
	                <th>Vendor Name</th>
	                <th>Brand</th>
	                <th>Category</th>
	                <th>SKU</th>
	                <th>MFR#</th>
	                <th>Product Name</th>
	                <th>Retail/MSRP</th>
	                <th>FBA Price</th>
	                <th>Original Cost</th>
	                <th>URL to Image</th>
	                <th>Season/Collection</th>
	                <th>Carryover</th>
	                <th>Product ID</th>
	                <th>FNSKU</th>
	                <th>ASIN</th>
	                <th>Date Created</th>
	                <th>Stock</th>
	                <th>MAP Policy</th>
	                <th>MAP Price</th>
	                <th>MAP Status</th>
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
	    	
	    	echo '<tr>
	        		<td>' . $row["vendorName"] . '</td>
	        		<td>' . $row["brandName"] . '</td>
	        		<td>' . $row["category"] . '</td>
	        		<td>' . $row["SKU"] . '</td>
	        		<td>' . $row["MFR"] . '</td>
	        		<td>' . $row["productName"] . '</td>
	        		<td>' . $row["retail_MSRP"] . '</td>
	        		<td>' . $row["fba_price"] . '</td>
	        		<td>' . $row["original_cost"] . '</td>
	        		<td>' . $row["img_URL"] . '</td>
	        		<td>' . $row["collection"] . '</td>';

			if($row["carryover"] == '1') {
    			echo '<td> Carryover </td>';
    		}
    		else if($row["carryover"] == '2') {
    			echo '<td> Non-carryover </td>';
    		}
    		else {
    			echo '<td> </td>';
			}

   			echo '
				<td>' . $row["productID"] . '</td>
	    		<td>' . $row["FNSKU"] . '</td>
	    		<td>' . $row["asin"] . '</td>
	    		<td>' . $row["dateCreated"] . '</td>
	    		<td>' . $row["afn-total-quantity"] . '</td>
	    		<td>' . $row["MAP_policy"] . '</td>
	    		<td>' . $row["MAP_price"] . '</td>
	    		<td>' . $row["MAP_status"] . '</td>
	    		<td>' . $row["new_cost"] . '</td>
	    	</tr>';
	    }
	}

	echo '</tbody>
			<tfoot>
	            <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
	                <th># of Copies</th>
	                <th>Vendor Name</th>
	                <th>Brand</th>
	                <th>Category</th>
	                <th>SKU</th>
	                <th>MFR#</th>
	                <th>Product Name</th>
	                <th>Retail/MSRP</th>
	                <th>FBA Price</th>
	                <th>Original Cost</th>
	                <th>URL to Image</th>
	                <th>Season/Collection</th>
	                <th>Carryover</th>
	                <th>Product ID</th>
	                <th>FNSKU</th>
	                <th>ASIN</th>
	                <th>Date Created</th>
	                <th>Stock</th>
	                <th>MAP Policy</th>
	                <th>MAP Price</th>
	                <th>MAP Status</th>
	                <th>New Cost</th>
	            </tr>
        		</tfoot>
			</table>';

	$conn->close();

	echo '<script>hide();</script>';
?>

<br>
</body>
</html>