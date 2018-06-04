<?php
  include('connection.php');
if(isset($_POST["view"]))
{
  $sql = "
          SELECT *
            FROM
              products
              INNER JOIN brands
                ON products.brandID = brands.brandID
              INNER JOIN vendors
                ON brands.vendorID = vendors.vendorID
              WHERE
                vendors.vendorID = '".$_POST["view"]."
              LIMIT 1'
          ";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    $brandName = $row["brandName"];
    $vendorName = $row["vendorName"];
  }
}
else
{
  echo 'Vendor ID not passed';
}
?>

<!DOCTYPE HTML>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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

</head>

<script>
  $(document).ready(function()
  {
    let table = $('#example').DataTable(
      {
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ],
        "scrollY": "350px",
        "scrollCollapse": true
    } );
  } );

  function hide()
  {
    document.getElementById('wait').style.display = 'none';
    document.getElementById('done').style.display = 'block';
  }


</script>

<style>
  body, h2, h5 {
    font-family: 'Work Sans', sans-serif;
  }
</style>

<body style="padding-top: 15px; padding-right: 20px;">

  <h2 style="display: block; padding: 0 0 0 20px;"> Products of <?php echo $brandName ?> </h2>
  <h5 style="display: block; padding: 0 0 0 20px;"> Vendor: <?php echo $vendorName ?> </h2>

  <!-- Loading alerts -->
  <div class="alert alert-info fade in alert-dismissible show" style="margin: 5px 15px 15px 15px;" id="wait">
    <strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
  </div>

  <div class="alert alert-success fade in alert-dismissible show" style="margin: 5px 15px 15px 15px; display: none" id="done">
    <strong>Table completed.</strong> You may now proceed.
  </div>


<?php
  $output = '';
  if(isset($_POST["view"])) {

  $sql = "
          SELECT *
          FROM
              products
              INNER JOIN brands
                ON products.brandID = brands.brandID
              INNER JOIN vendors
                ON brands.vendorID = vendors.vendorID
              WHERE
                vendors.vendorID = '".$_POST["view"]."'
          ";
  $result = $conn->query($sql);

    $output .= '
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
      <tbody style="font-size: 14px;" id = "brandDetailsTableBodyID">';

    while($row = $result->fetch_assoc()) {
        $output .= '<tr>
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
          <td>' . $row["collection"] . '</td>
          ';

        if($row["carryover"] == '1') {
          $output .= '<td> Carryover </td>';
        }
        else if($row["carryover"] == '2') {
          $output .= '<td> Non-carryover </td>';
        }
        else {
          $output .= '<td> </td>';
        }

        $output .= '
          <td>' . $row["productID"] . '</td>
          <td>' . $row["FNSKU"] . '</td>
          <td>' . $row["asin"] . '</td>
          <td>' . $row["dateCreated"] . '</td>
          <td>' . $row["afn-total-quantity"] . '</td>
          <td>' . $row["MAP_policy"] . '</td>
          <td>' . $row["MAP_price"] . '</td>
          <td>' . $row["MAP_status"] . '</td>
          <td>' . $row["new_cost"] . '</td>
          </tr>
          ';
    }

    $output .= '
      </tbody>
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

$output .= "
<script>
  hide();
</script>
";

    echo $output;
  }
$conn->close();
?>

</body>
</html>
