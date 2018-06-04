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
        $('#fbaTable').dataTable(
            {               
            });
    } );

    function hide(){
        document.getElementById("wait").style.display = "none";
        document.getElementById("done").style.display = "block";
    }

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }



    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
          if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
          } else {
              a[i].style.display = "none";
          }
        }
    }

    function getID(value){
        document.getElementById("brandID").value = value;
        document.getElementById("brandSubmit").value = "Get Brand: " + value;
        document.getElementById("brandSubmit").disabled = false;    
    }
</script>

<style>
/* Dropdown Button */
.dropbtn {
    background-color: #3498DB;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;            
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    font-size: 12px;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 350px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    text-align: left;

    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    font-family: 'Work Sans', sans-serif;    
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: transparent;
}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {
    display: block;
}

.btn {    
    border: 0;
    border-radius: 10px;
    font-family: 'Work Sans', sans-serif;
    font-size: 16px;
    width: 150px;
}

#btnDrop {      
    border-radius: 5px; 
    width: 180px;    
}

</style>

</head>

<body style="padding-right: 20px;">

    <h2 style="display: block; padding-left: 15px;"> Total FBA Value </h2>

    <table style="vertical-align: middle; width: 100%;" border="0">
        <tr>
            <td>
                <form method="post" action="export_fba.php" style="padding: 0px 0 10px 10px;">
                    <input type="submit" name="export" id="btnExportFBA" class="btn btn-primary button-loading" value="Export All as .xls (Excel)" style="font-size: 12px; text-align: center; width: 200px" disabled />
                </form>                                
            </td>
            <td>
                <form method="post" action="export_fba.php" style="padding: 0px 0 10px 10px;">
                    <input type="submit" name="exportBrand" id="btnExportFBA_brands" class="btn btn-primary button-loading" value="Export Brands as .xls (Excel)" style="background: #00bb9a; font-size: 12px; text-align: center; width: 200px" disabled />
                </form> 
            </td>
            <td style="text-align: right; width: 80%; padding-right: 20px;">
                <form action="report_fba.php" method="post">
                    <input type="hidden" name="brandID" id="brandID" value="" />                        
                    <?php

                        include('connection.php');

                                $sql = "SELECT *
                                        FROM products
                                            INNER JOIN brands
                                                ON brands.brandID = products.brandID
                                            INNER JOIN vendors
                                                ON vendors.vendorID = brands.vendorID
                                        WHERE 
                                            `afn-inbound-working-quantity` != '0' OR
                                            `afn-inbound-shipped-quantity` != '0' OR
                                            `afn-inbound-receiving-quantity` != '0' OR                    
                                            `afn-fulfillable-quantity`  != '0' OR
                                            `afn-unsellable-quantity` != '0' OR
                                            `afn-reserved-quantity` != '0'
                                        GROUP BY
                                            brandName
                                        ORDER BY
                                            brands.brandID ASC                                        
                                ";
                                $result = $conn->query($sql);

                                echo '
                                      <div class="dropdown" id="dropdownDIV">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" onclick="myFunction()" id="btnDrop"  style="font-size: 12px;" disabled>
                                          Search Brand ID
                                        </button>
                                        <div id="myDropdown" class="dropdown-content" style="width: 250px">                                    
                                            <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" style="padding: 10px 5px 10px 5px; width: 100%">';

                                if(mysqli_num_rows($result) > 0) {    
                                  echo '<a class="dropdown-item" href="#"> <b>Brand ID</b> - Brand - Vendor </a>';
                                  while($row = mysqli_fetch_array($result)) {                                      
                                    echo '<a class="dropdown-item" href="#" name="'.$row[brandID].'" onclick="getID(this.name)"><b>'.$row[brandID].'</b> - '.$row[brandName].' - '.$row[vendorName].'</a>';
                                  }  
                                }   

                                echo '
                                      </div>
                                        </div>'; 

                        $conn->close();                        
                     ?>                
                     <input type="submit" id="brandSubmit" name="brandSubmit" class="btn btn-primary button-loading" value="Get Brand" data-loading-text="Loading..." style="background: #00bb9a; color: white; display: inline-block; text-align: center; font-size: 12px;" disabled>     
                </form>
            </td>
        </tr>
    </table>    

    <!-- Loading alerts -->
    <div class="alert alert-info fade in alert-dismissible show" style="margin: 0 15px 15px 10px;" id="wait">
        <strong>Table is loading.</strong> Please wait for the "completed" alert before proceeding.
    </div>

    <div class="alert alert-success fade in alert-dismissible show" style="margin: 0 15px 15px 10px; display: none" id="done">
        <strong>Table completed.</strong> You may now proceed.
    </div>

<?php   
    
    if(isset($_POST["report_fba"])) {
    
        include('connection.php');

        $sql = "SELECT brandName, SKU, productName, your_price, retail_MSRP, fba_price, `afn-inbound-working-quantity`, `afn-inbound-shipped-quantity`, `afn-inbound-receiving-quantity`,
                        `afn-fulfillable-quantity`, `afn-unsellable-quantity`, `afn-reserved-quantity`, new_cost, FNSKU, ASIN, products.brandID
                FROM
                    products
                    INNER JOIN brands
                        ON products.brandID = brands.brandID
                    INNER JOIN vendors
                        ON brands.vendorID = vendors.vendorID
                WHERE 
                    `afn-inbound-working-quantity` != '0' OR
                    `afn-inbound-shipped-quantity` != '0' OR
                    `afn-inbound-receiving-quantity` != '0' OR                    
                    `afn-fulfillable-quantity`  != '0' OR
                    `afn-unsellable-quantity` != '0' OR
                    `afn-reserved-quantity` != '0'
            ";
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
            echo '<script> document.getElementById("btnExportFBA").disabled = false; </script>';
            echo '<script> document.getElementById("btnExportFBA_brands").disabled = false; </script>';
            echo '<script> document.getElementById("btnDrop").disabled = false; </script>';
            while($row = $result->fetch_assoc()) {
                $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
                $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]); 
                $fba_value = number_format($row["new_cost"]) * $sum_qty;            
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
                        <td>'.$fba_value.'</td>
                    </tr>';
            }
        }

        echo '</tbody>
                <tfoot>
                    <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
                        <th>brandName</th>  
                        <th>SKU</th>  
                        <th>productName</th>  
                        <th>your_price</th>
                        <th>retail_MSRP</th>
                        <th>fba_price</th>
                        <th>sum_inbound</th>
                        <th>afn-fulfillable-quantity</th>
                        <th>afn-unsellable-quantity</th>
                        <th>afn-reserved-quantity</th>
                        <th>new_cost</th>
                        <th>FNSKU</th>
                        <th>ASIN</th>
                        <th>fba_value</th>
                    </tr>
                    </tfoot>
                </table>';                

        $conn->close();

        echo '<script>hide();</script>';
    }

    if(isset($_POST["brandSubmit"])) {        
        echo '<script> document.getElementById("btnExportFBA").disabled = true; </script>';
        echo '<script> document.getElementById("brandSubmit").style.visibility = "hidden"; </script>';
        echo '<script> document.getElementById("dropdownDIV").style.visibility = "hidden"; </script>';

        include('connection.php');

        $sql = "SELECT brandName, SKU, productName, your_price, retail_MSRP, fba_price, `afn-inbound-working-quantity`, `afn-inbound-shipped-quantity`, `afn-inbound-receiving-quantity`,
                        `afn-fulfillable-quantity`, `afn-unsellable-quantity`, `afn-reserved-quantity`, new_cost, FNSKU, ASIN, products.brandID
                FROM
                    products
                    INNER JOIN brands
                        ON products.brandID = brands.brandID
                    INNER JOIN vendors
                        ON brands.vendorID = vendors.vendorID
                WHERE 
                    (`afn-inbound-working-quantity` != '0' OR
                    `afn-inbound-shipped-quantity` != '0' OR
                    `afn-inbound-receiving-quantity` != '0' OR                    
                    `afn-fulfillable-quantity`  != '0' OR
                    `afn-unsellable-quantity` != '0' OR
                    `afn-reserved-quantity` != '0')
                    AND
                    products.brandID = '".$_POST['brandID']."'
            ";
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
            echo '<script> document.getElementById("btnExportFBA").disabled = false; </script>';
            while($row = $result->fetch_assoc()) {
                $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
                $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]); 
                $fba_value = number_format($row["new_cost"]) * $sum_qty;            
                echo '<tr>
                        <td style="background: #fdf3bd; font-weight: bold">'.$row["brandName"].'</td>
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
                        <td>'.$fba_value.'</td>
                    </tr>';
            }
        }

        echo '</tbody>
                <tfoot>
                    <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
                        <th>brandName</th>  
                        <th>SKU</th>  
                        <th>productName</th>  
                        <th>your_price</th>
                        <th>retail_MSRP</th>
                        <th>fba_price</th>
                        <th>sum_inbound</th>
                        <th>afn-fulfillable-quantity</th>
                        <th>afn-unsellable-quantity</th>
                        <th>afn-reserved-quantity</th>
                        <th>new_cost</th>
                        <th>FNSKU</th>
                        <th>ASIN</th>
                        <th>fba_value</th>
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