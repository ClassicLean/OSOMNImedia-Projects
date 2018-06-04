<?php
  include('connection.php');
  $productsOldID = "SELECT MAX(pID) FROM products";
  $brandsOldID = "SELECT MAX(brandID) FROM brands";
  $vendorsOldID = "SELECT MAX(vendorID) FROM vendors";
?>
<!DOCTYPE html>
<html lang="en">

<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<style type="text/css">

    body, span, #path {
        font-family: 'Work Sans', sans-serif;
        font-size: 14px;
        color: black;
    }

    .center-div {
        margin: 10% auto 0 auto;
        text-align: center;
        width: 50%;
    }

    [hidden] {
        display: none !important;
    }

</style>

<script>
    function showPath() {
        document.getElementById("path").innerHTML = document.getElementById("file").value;
        document.getElementById("submit").disabled = false;
    }
</script>

</head>

<body style="padding-left: 30px; padding-right: 50px; text-align: center">

  <div class="center-div">

    <a href="masterfile_instructions.html" target="_blank" style="text-decoration: none">
        <button class="btn button-loading" style="background: #0A83C8; color: white; font-size: 14px; width: 200px; margin-bottom: 20px">
            Read me first!
        </button>
    </a>

        <form class="form-horizontal" action="upload_master.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <fieldset>

                <h2 style="display: block; padding: 0px 0 0 0;"> Upload masterfile.csv </h2>
                <p> Please select .csv file of which contents are to be read: </p>

                <!-- File Button -->
                <br>

                <div class="path">
                    <label class="btn btn-default">
                        <img src="images/upload_csv.png" style="height: 100px; width: 100px;"><br>
                        <span style="color: #0A83C8; font-weight: bold">Click to choose file</span>
                        <input type="file" hidden name="file" id="file" class="input-large" onchange="showPath()">
                    </label>
                </div>
                <span id="path" style="color: black"></span>

                <!--
                <input type="file" name="file" id="file" class="input-large" style="margin: 0 auto;">
                -->

                <br><br>

                <!-- Button -->
                <button type="submit" id="submit" name="add" class="btn button-loading" data-loading-text="Loading..." style="background: #00bb9a; color: white; font-size: 12px; width: 100px;" disabled>Import</button>
                <br><br>

            </fieldset>

        <br><br><br><br><br><br>
        <hr/>
        <p style="color: #8c8c8c">scroll down for more options</p>

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <!-- Button -->
          <input name="redo" class="btn" type="submit" value="Redo Uploaded Master File" id="btnRedo" style="background: #dea848; color: white; font-size: 12px; width: 250px;" onclick="return confirm('Are you sure?')" disabled/>
          <br><br>
          <input name="delete" class="btn" type="submit" value="Delete Everything" id="btnDel" style="background: #dc3545; color: white; font-size: 12px; width: 250px;" onclick="return confirm('Are you sure?')"/>        
        </form>
    </div>

<br><br><br><br><br><br>
</body>
</html>
<?php $conn->close(); ?>

<?php

  include('connection.php');

  $sql = "SHOW TABLES LIKE 'brands_old'";
  $result = $conn->query($sql);

  if($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {
      echo '<script> document.getElementById("btnRedo").disabled = false; </script>';
    }
  }

if(isset($_POST["add"])) {    
    
  if($_FILES["file"]["size"] > 0) {

    ///// OPENING FILE  /////
    $filename=$_FILES["file"]["tmp_name"];    
    $file = fopen($filename, "r");

    $sql = "DROP TABLE IF EXISTS mfi_db.products_old";
    $conn->query($sql);
    $sql = "DROP TABLE IF EXISTS mfi_db.brands_old";
    $conn->query($sql);
    $sql = "DROP TABLE IF EXISTS mfi_db.vendors_old";
    $conn->query($sql);

    $sql = "CREATE TABLE products_old LIKE products";
    $conn->query($sql);    
    $sql = "CREATE TABLE brands_old LIKE brands";
    $conn->query($sql);
    $sql = "CREATE TABLE vendors_old LIKE vendors";
    $conn->query($sql);

    $sql = "INSERT INTO products_old SELECT * FROM products";
    $conn->query($sql);
    $sql = "INSERT INTO brands_old SELECT * FROM brands";
    $conn->query($sql);
    $sql = "INSERT INTO vendors_old SELECT * FROM vendors";
    $conn->query($sql);

    $skip = 0;
    while ($row = fgetcsv($file, 1000000, ",")) {        
      if($skip != 0){
        $c2 = $row[2]; $c3 = $row[3]; $c4 = $row[4];
        $c14 = $row[14]; $c15 = $row[15]; $c16 = $row[16]; $c17 = $row[17]; $c18 = $row[18]; $c19 = $row[19];
        $c20 = $row[20]; $c21 = $row[21]; $c23 = $row[23];              

        if(substr($c15, 0, 1) === 'C' || substr($c15, 0, 1) === 'c'){                   // Carryover
          $c15 = 1;      
        }
        else if(substr($c15, 0, 1) === 'N' || substr($c15, 0, 1) === 'n'){              // Non-carryover
          $c15 = 2;
        }
        else{
          $c15 = 0;
        }

        // Product Name
        $c0 = addslashes($row[0]); $c1 = addslashes($row[1]); $c5 = addslashes($row[5]);

        // URLS
        $c9 = addslashes($row[9]); $c10 = addslashes($row[10]); $c11 = addslashes($row[11]); $c12 = addslashes($row[12]); $c13 = addslashes($row[13]);

        // DECIMALS
        $c6 = str_replace("$","",$row[6]); $c7 = str_replace("$","",$row[7]); $c8 = str_replace("$","",$row[8]);
        $c22 = str_replace("$","",$row[22]); $c24 = str_replace("$","",$row[24]);
        
        $sql = "SELECT SKU
            FROM 
              products            
            WHERE
              SKU = '$c3'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){            
          $sql = "UPDATE products
                      SET `category`='$c2',                  
                          `MFR`='$c4',
                          `productName`='$c5',
                          `retail_MSRP`='$c6',
                          `fba_price`='$c7',
                          `original_cost`='$c8',
                          `img_URL`='$c9',
                          `view1` ='$c10',
                          `view2` ='$c11',
                          `view3` ='$c12',
                          `view4` ='$c13',
                          `collection`='$c14',
                          `carryover`='$c15',
                          `productID`='$c16',
                          `FNSKU`='$c17',
                          `ASIN`='$c18',
                          `dateCreated`='$c19',
                          `afn-total-quantity`='$c20',
                          `MAP_policy`='$c21',
                          `MAP_price`='$c22',
                          `MAP_status`='$c23',
                          `new_cost`='$c24'
                      WHERE
                        SKU = '$c3'";       
        }
        else {                      
          $sql = "SELECT brandID, vendorName, brandName
              FROM brands           
                INNER JOIN vendors
                  ON brands.vendorID = vendors.vendorID
              WHERE
                vendorName = '$c0' AND brandName = '$c1'
              ";
          $result = $conn->query($sql);

          $brandID = 0;
          if($result->num_rows > 0) {
            # Both brand and vendor exists          
            while($row = $result->fetch_assoc()) {
              $brandID = $row["brandID"];
            }
          }
          else {
            # New brand and/or vendor
            #==== Check if vendor exists ====#
            $sql = "SELECT *
                FROM vendors                              
                WHERE vendorName = '$c0'
                ";
            $result = $conn->query($sql);

            $vendorID = 0;
            #==== Get existing vendorID ====#
            if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $vendorID = $row["vendorID"];
              }             
            }
            #==== Create new vendor and get the vendorID ====#
            else{
              $sql = "INSERT INTO vendors (vendorName) 
                  VALUES ('$c0')";
              mysqli_query($conn, $sql);

              $sql = "SELECT vendorID
                  FROM vendors                              
                  WHERE vendorName = '$c0'
                  ";
              $result = $conn->query($sql);

              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $vendorID = $row["vendorID"];
                }
              }
            }

            #==== Create new brand ====#
            $sql = "INSERT INTO brands (brandName, vendorID) 
                VALUES ('$c1', '$vendorID')";
            mysqli_query($conn, $sql);                                

            #==== Repeat first to get brandID ====#
            $sql = "SELECT brandID, vendorName, brandName
                FROM brands           
                  INNER JOIN vendors
                    ON brands.vendorID = vendors.vendorID
                WHERE
                  vendorName = '$c0' AND brandName = '$c1'
                ";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {         
              while($row = $result->fetch_assoc()) {
                $brandID = $row["brandID"];
              }
            }
          }
           
          $sql = "INSERT INTO products (category, SKU, MFR, productName, retail_MSRP, fba_price, original_cost, img_URL, view1, view2, view3, view4, collection, carryover, productID, FNSKU,
                        ASIN, dateCreated, `afn-total-quantity`, MAP_policy, MAP_price, MAP_status, new_cost, brandID) 
              VALUES ('$c2',  #category
                  '$c3',  #SKU
                  '$c4',  #MFR
                  '$c5',  #productName
                  '$c6',  #retail_MSRP
                  '$c7',  #fba_price
                  '$c8',  #original_cost
                  '$c9',  #img_URL
                  '$c10',  #view1
                  '$c11',  #view2
                  '$c12',  #view3
                  '$c13',  #view4
                  '$c14', #collection
                  '$c15', #carryover
                  '$c16', #productID
                  '$c17', #FNSKU
                  '$c18', #ASIN
                  '$c19', #dateCreated
                  '$c20', #`atn-total-quantity`
                  '$c21', #MAP_policy
                  '$c22', #MAP_price
                  '$c23', #MAP_status
                  '$c24', #new_cost
                  '$brandID')";
          mysqli_query($conn, $sql);
        }
      }
      $skip = 1;      
    }     

    fclose($file);  

    echo "
        <script type=\"text/javascript\">
          alert(\"CSV File has been successfully imported.\");
          window.location = \"upload_master.php\"
        </script>
        "; 
    
  }

  else {              
    echo "
      <script type=\"text/javascript\">
        alert(\"Invalid File:Please Upload CSV File.\");
        window.location = \"upload_master.php\"
      </script>
      ";
  }
}

if(isset($_POST["redo"])){   

  $sql = "DROP TABLE IF EXISTS mfi_db.products";
  $conn->query($sql);
  $sql = "DROP TABLE IF EXISTS mfi_db.brands";
  $conn->query($sql);
  $sql = "DROP TABLE IF EXISTS mfi_db.vendors";
  $conn->query($sql);

  $sql = "ALTER TABLE products_old RENAME TO products";
  $conn->query($sql);
  $sql = "ALTER TABLE brands_old RENAME TO brands";
  $conn->query($sql);
  $sql = "ALTER TABLE vendors_old RENAME TO vendors";
  $conn->query($sql);

  echo "<script type=\"text/javascript\">
          alert(\"Database has been refreshed.\");
          window.location = \"upload_master.php\"
        </script>
        "; 
}

if(isset($_POST["delete"])){   
  $sql = "TRUNCATE TABLE products";
  $conn->query($sql);
  $sql = "TRUNCATE TABLE brands";
  $conn->query($sql);

  $sql = "DELETE FROM mfi_db.vendors";
  $conn->query($sql);
  $sql = "ALTER TABLE mfi_db.vendors AUTO_INCREMENT = 1";
  $conn->query($sql);

  $sql = "DROP TABLE IF EXISTS mfi_db.products_old";
  $conn->query($sql);
  $sql = "DROP TABLE IF EXISTS mfi_db.brands_old";
  $conn->query($sql);
  $sql = "DROP TABLE IF EXISTS mfi_db.vendors_old";
  $conn->query($sql);

  echo "<script type=\"text/javascript\">
          alert(\"Masterfile has been deleted. Database is now empty.\");
          window.location = \"upload_master.php\"
        </script>
        "; 
}

$conn->close();

?>