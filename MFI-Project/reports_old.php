<!DOCTYPE HTML>
<html>
<head>

<style type="text/css">

	body {
		padding: 50px 50px 50px 30px;
	}

	p {
		font: 20px 'Work Sans', sans-serif;
		color: black;
    	display: inline;
	}

	/* Dropdown */
	.dropbtn {
	    background: white;
	    border: 1px solid #eeeeee;	   
	    color: black;	    
	    cursor: pointer;
	    font-size: 12px;
	    height: 40px;
	    padding-left: 20px;
	    text-align: left;
	    width: 200px;
	}

	.dropdown {
	    position: relative;
	    display: inline-block;
	}

	.dropdown-content {
	    display: none;
	    font-size: 14px;
	    position: absolute;
	    background-color: #f9f9f9;
	    min-width: 220px;
	    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	    z-index: 1;
	}

	.dropdown-content a {
	    color: black;
	    padding: 12px 16px;
	    text-decoration: none;
	    display: block;
	}

	.dropdown-content a:hover {background-color: #f1f1f1}

	.dropdown:hover .dropdown-content {
	    display: block;
	}

	.dropdown:hover .dropbtn {
	    background-color: #dbdbdb;
	}

</style>

<!-- Bootstrap -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- EXTERNAL CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<script>

	$(document).ready(function() {
	    $('#fbaTable').dataTable({
	    });
	} );

	$(document).ready(function() {
	    $('#tskuTable').dataTable({
	    });
	} );

	function fbaShow(){
		document.getElementById("fba").style.display = "block";
		document.getElementById("tsku").style.display = "none";
	}

	function tskuShow(){
		document.getElementById("tsku").style.display = "block";
		document.getElementById("fba").style.display = "none";
	}

</script>

</head>
<body>

<p> REPORTS </p>

<br>
<div class="dropdown">
	<button class="dropbtn">Select report...</button>
	<div class="dropdown-content">
		<a role="menuitem" onclick="fbaShow()">Total FBA Value</a>
		<a role="menuitem" onclick="tskuShow()">Potential Trouble SKUs</a>
	</div>
</div>
			
<div id="fba" style="display: none; padding-right: 0px; padding-top: 15px;">
	
	<h1 style="display: inline">Total FBA Value</h1>

    <!-- Export button -->    
	<form method="post" action="export_fba.php" style="padding: 20px 0 15px 15px;">
		<input type="submit" name="export" class="btn btn-primary" value="Export as .xls (Excel)" />
	</form>

	<!-- Table -->
	<?php
	include('connection.php');
	
	$sql = "SELECT *
            FROM
                products
                INNER JOIN brands
                    ON products.brandID = brands.brandID
                INNER JOIN vendors
                    ON brands.vendorID = vendors.vendorID;";
	$result = $conn->query($sql);

	echo '<table id="fbaTable" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
			<thead style="font-size: 12px">
	            <tr style="max-width:100%; white-space:nowrap; color: #383737">
	                <th>Brand</th>  
		            <th>SKU</th>  
		            <th>Product Name</th>  
		            <th>Price</th>
		            <th>Retail/MSRP</th>
		            <th>FBA Price</th>
		            <th>Inbound</th>
		            <th>Fulfillable</th>
		            <th>Unsellable</th>
		            <th>Reserved</th>
		            <th>New Cost</th>
		            <th>FNSKU</th>
		            <th>ASIN</th>
		            <th>FBA Value</th>
	            </tr>
	        </thead>
	        <tbody style="font-size: 14px;">';

	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	$sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
			// TABLE
	        echo '<tr>
	        		<td>'.$row["brandName"].'</td>
	                <td>'.$row["SKU"].'</td>  
	                <td>'.$row["productName"].'</td>  
	                <td>'.$row["your_price"].'</td>  
	                <td>'.$row["retail_MSRP"].'</td>  
	                <td>'.$row["fba_price"].'</td>
	                <td>'.$sum_inbound.'</td>
	                <td>'.$row["afn-fulfillable-quantity"].'</td>
	                <td>'.$row["afn-unsellable-quantity"].'</td>
	                <td>'.$row["afn-reserved-quantity"].'</td>
	                <td>'.$row["new_cost"].'</td>
	                <td>'.$row["FNSKU"].'</td>
	                <td>'.$row["ASIN"].'</td>
	                <td>'.$row["fba_value"].'</td>
	        	</tr>';
	    }
	}

	echo '</tbody>
			<tfoot>
	            <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
	                <th>Brand</th>  
		            <th>SKU</th>  
		            <th>Product Name</th>  
		            <th>Price</th>
		            <th>Retail/MSRP</th>
		            <th>FBA Price</th>
		            <th>Inbound</th>
		            <th>Fulfillable</th>
		            <th>Unsellable</th>
		            <th>Reserved</th>
		            <th>New Cost</th>
		            <th>FNSKU</th>
		            <th>ASIN</th>
		            <th>FBA Value</th>
	            </tr>
        		</tfoot>
			</table>';
	$conn->close();
	?>
</div>

<div id="tsku" style="display: none; padding-right: 0px; padding-top: 15px;">
	
	<h1 style="display: inline">Potential Trouble SKUs</h1>

    <!-- Export button -->    
	<form method="post" action="export_tsku.php" style="padding: 20px 0 15px 15px;">
		<input type="submit" name="export" class="btn btn-primary" value="Export as .xls (Excel)" />
	</form>

	<!-- Table -->
	<?php
	include('connection.php');
	
	$sql = "SELECT *
            FROM
                products
                INNER JOIN brands
                    ON products.brandID = brands.brandID
                INNER JOIN vendors
                    ON brands.vendorID = vendors.vendorID;";
	$result = $conn->query($sql);

	echo '<table id="tskuTable" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
			<thead style="font-size: 12px">
	            <tr style="max-width:100%; white-space:nowrap; color: #383737">
	                <th>Inv-age-0-to-90-days</th>  
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
	    while($row = $result->fetch_assoc()) {
			// TABLE
	        echo '<tr>
	        		<td>'.$row["brandName"].'</td>
	                <td>'.$row["brandName"].'</td>  
	                <td>'.$row["productName"].'</td>  
	                <td>'.$row["SKU"].'</td>  
	                <td>'.$row["retail_MSRP"].'</td>  
	                <td>'.$row["retail_MSRP"].'</td>
	                <td>'.$row["retail_MSRP"].'</td>
	                <td>'.$row["retail_MSRP"].'</td>	               
	        	</tr>';
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
	?>
</div>

</body>

</html>