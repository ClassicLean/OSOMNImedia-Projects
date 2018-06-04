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

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
<style>

	a:visited, a:hover, a:link, a:active {
		color: black;
		text-decoration: none;
	}

	.btn {
		background: transparent;
		border: 0;
		border-radius: 10px;
		color: #a09d9a;
		font-family: 'Work Sans', sans-serif;
		font-size: 16px;
		width: 150px;
	}

	.btn:hover {
		background: #72c2ef;
		color: white;
		text-decoration: none;
	}

	#full, #alertShow {
		height: 100%;
	}

		div.dom_wrapper {
	  position: sticky;  /* Fix to the top */
	  top: 0;
	  padding: 5px;
	  background: rgba(255, 255, 255, 1);  /* hide the scrolling table */
	}

	body {
  font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
  margin: 0;
  padding: 0;
  color: #333;
  background-color: #fff;
}

</style>

<script type="text/javascript">

	$(document).ready(function()
	{
		let table = $('#example').DataTable(
      {
				/*dom: '<"dom_wrapper fh-fixedHeader"lBf>tip',
				buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        fixedHeader:
        {
            header: true,
            footer: true
        }*/
				dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ],
        "scrollY": "350px",
        "scrollCollapse": true
    } );

		$('#save-link').click(function ()
		{
			let retContent = [];
			let retString = '';
			$('tr[id^=brandDetailsTableHeaderID]').each(function(idx,elem)
			{
				let elemText = [];
				$(elem).children('th').each(function (childIdx, childElem)
				{
					elemText.push($.trim($(childElem).text()));
				});
				retContent.push(`${elemText.join('\t')}`);
			})

			$('tbody[id^="brandDetailsTableBodyID"] tr').each(function (idx, elem)
			{
				let elemText = [];
				$(elem).children('td').each(function (childIdx, childElem)
				{
					elemText.push($.trim($(childElem).text()));
				});
				retContent.push(`${elemText.join('\t')}`);
			});

			retString = retContent.join(',\r\n');
			let file = new Blob([retString], {type: 'text/plain'});
			let btn = $('#save-link');
			btn.attr('href', URL.createObjectURL(file));
			btn.prop('download', 'MFI Data - All.txt');
		})
	} );

	function buttonState(value) {
		document.getElementById(value).style.background = "#007bff";
		document.getElementById(value).style.color = "white";
		if(value == "out" || value == "in"){
			document.getElementById("btnDownload").style.visibility = "hidden";
			document.getElementById("save-link").style.visibility = "hidden";
		}
		else {
			document.getElementById("btnDownload").style.visibility = "visible";
			document.getElementById("save-link").style.visibility = "visible";
		}
	}

	function hide() {
		document.getElementById("wait").style.display = "none";
		document.getElementById("done").style.display = "block";
	}

	function duplicateAlert() {
		document.getElementById("duplicateID").style.display = "block";
	}

	function brandlessAlert() {
		document.getElementById("brandlessID").style.display = "block";
	}

	function hideDuplicateAlert() {
		document.getElementById("duplicateID").style.display = "none";
	}

	function hideBrandlessAlert() {
		document.getElementById("brandlessID").style.display = "none";
	}

</script>
</head>

<body style="padding-top: 15px; padding-right: 20px;">

	<!-- Loading alerts -->
	<div class="alert alert-info fade in alert-dismissible show" style="margin: 5px 15px 15px 15px;" id="wait">
		<strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
	</div>

	<div class="alert alert-success fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="done">
		<strong>Table completed.</strong> You may now proceed.
	</div>

	<div id="brandName">
		<h1>
	</div>

	<!-- Error alerts -->
	<div class="alert alert-danger fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="duplicateID">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="hideDuplicateAlert()"> <span aria-hidden="true" style="font-size:20px" >&times;</span> </button>
			<strong>Double Trouble!</strong> There are detected duplicates. <a href="duplicate.php" style="color: blue;"> I'll show you. </a>
	</div>

	<div class="alert alert-danger fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="brandlessID">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="hideBrandlessAlert()"> <span aria-hidden="true" style="font-size:20px" >&times;</span> </button>
			<strong>Must be new.</strong> There are brandless items. <a href="brandless.php" style="color: blue;"> I'll show you. </a>
	</div>

	<table style="margin-bottom: 15px; width: 100%" border="0">
		<tr>
			<td style="padding: 5px 0 5px 20px">
				<form action="all.php" method="post">
					<button type="submit" id="all" name="all" class="btn" data-loading-text="Loading...">All</button>
					<button type="submit" id="out" name="outstock" class="btn" data-loading-text="Loading...">Out of stock</button>
					<button type="submit" id="in" name="instock" class="btn" data-loading-text="Loading...">Instock</button>
				</form>
			</td>
			<td style="padding: 5px 15px 5px 0; width: 5%">
				<!--<a href="#" id="save-link"><button class="btn" style="width: 100%" id="btnDownload">Download</button></a>-->
			</td>
		</tr>
	</table>

	<div id="full">

	<?php
		include('connection.php');

		$brandlessSQL = "SELECT *
						FROM products
						WHERE `brandID` = 0
						LIMIT 1
						";
		$brandlessResult = $conn->query($brandlessSQL);

		if ($brandlessResult->num_rows > 0) {
			echo '<script type="text/javascript"> brandlessAlert(); </script>';
		}

		// Check duplicates
		$sql = "SELECT SKU, COUNT(SKU) as count
				FROM products
				GROUP BY SKU
				HAVING count > 1
				LIMIT 1
				";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			echo '<script type="text/javascript"> duplicateAlert() </script>';
		}

		if(isset($_POST["outstock"])){
			$sql = "SELECT *
					FROM products
						INNER JOIN brands
							ON brands.brandID = products.brandID
						INNER JOIN vendors
							ON vendors.vendorID = brands.vendorID
					WHERE `afn-total-quantity` = 0
					";
			echo '<script> buttonState("out"); </script>';
		}
		else if(isset($_POST["instock"])){
			$sql = "SELECT *
					FROM products
						INNER JOIN brands
							ON brands.brandID = products.brandID
						INNER JOIN vendors
							ON vendors.vendorID = brands.vendorID
					WHERE `afn-total-quantity` > 0
					";
			echo '<script> buttonState("in"); </script>';
		}
		else{
			$sql = "SELECT *
					FROM products
						INNER JOIN brands
							ON brands.brandID = products.brandID
						INNER JOIN vendors
							ON vendors.vendorID = brands.vendorID
					";
			echo '
				<script> buttonState("all"); </script>';
		}

		// All products
		$result = $conn->query($sql);

		echo '
			<table id="example" class="table table-striped table-bordered table-responsive" cellspacing="0" style="width:100%">
				<thead style="font-size: 12px">
		            <tr style="max-width:100%; white-space:nowrap; color: #383737" id = "brandDetailsTableHeaderID">
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
		                <th>Other View 1</th>
		                <th>Other View 2</th>
		                <th>Other View 3</th>
		                <th>Other View 4</th>
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

		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
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
		        		<td>' . $row["view1"] . '</td>
		        		<td>' . $row["view2"] . '</td>
		        		<td>' . $row["view3"] . '</td>
		        		<td>' . $row["view4"] . '</td>
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
									<th>Other View 1</th>
									<th>Other View 2</th>
									<th>Other View 3</th>
									<th>Other View 4</th>
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

</div>

<br>
</body>
</html>
