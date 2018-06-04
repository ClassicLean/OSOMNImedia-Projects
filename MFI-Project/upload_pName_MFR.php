<!DOCTYPE HTML>
<html>
<head>
<title>Upload</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<style type="text/css">

    #filecontents
    {
      border:double;
      overflow-y:scroll;
      height:400px;
    }

    body {
      font-family: 'Work Sans', sans-serif;
      color: black;
    }

</style>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

</head>

<body style="padding-left: 30px; padding-right: 50px;">

  <h2 style="display: block; padding: 0px 0 0 0; font-weight: bold;"> Upload </h2>

    <br><br>
    <input type="file" class="form-control-file" id="txtfiletoread" aria-describedby="fileHelp">
    <br>    
    <br>
    <div id="filecontents" style="white-space: nowrap; font-family: 'Courier New'"></div>

<script type="text/javascript">
  'use strict';

  window.onload = function ()
  {
    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
      var fileSelected = document.getElementById('txtfiletoread');

      fileSelected.addEventListener('change', function (e)
      {
        var fileExtension = /text.*/;
        var fileTobeRead = fileSelected.files[0];
        if (fileTobeRead.type.match(fileExtension))
        {
          var fileReader = new FileReader();

          fileReader.onload = function (e)
          {
            var fileContents = document.getElementById('filecontents');
            fileContents.innerText = fileReader.result;
            getWords(fileReader.result);
          }

          fileReader.readAsText(fileTobeRead);

          var fileVal=document.getElementById("txtfiletoread");
        }
        else
        {
          alert("Please select text file");
        }
      }, false);
    }
    else
    {
      alert("Files are not supported");
    }

  }

  window.save = new Array();

  function show()
  {
    var text = document.getElementById('filecontents').innerHTML;      
    var noTabs = text.split(/\t|<br\s*\/?>/g);

    //alert(noTabs);

    var i=0;
    while(i < noTabs.length)
    {    
      save[i] = noTabs[i];            // Get category                         
      save[i+1] = noTabs[i+1];            // Get SKU                1         20
      save[i+2] = noTabs[i+2];            // Get MFR
      save[i+3] = noTabs[i+3];            // Get productName
      save[i+4] = noTabs[i+4];            // Get retail_MSRP
      save[i+5] = noTabs[i+5];            // Get fba_price
      save[i+6] = noTabs[i+6];            // Get original_cost
      save[i+7] = noTabs[i+7];            // Get img_url
      save[i+8] = noTabs[i+8];            // Get collection
      save[i+9] = noTabs[i+9];            // Get carryover
      save[i+10] = noTabs[i+10];            // Get productID
      save[i+11] = noTabs[i+11];            // Get FNSKU
      save[i+12] = noTabs[i+12];            // Get ASIN
      save[i+13] = noTabs[i+13];            // Get dateCreated
      save[i+14] = noTabs[i+14];            // Get stock
      save[i+15] = noTabs[i+15];            // Get MAP_policy
      save[i+16] = noTabs[i+16];            // Get MAP_price
      save[i+17] = noTabs[i+17];            // Get MAP_status
      save[i+18] = noTabs[i+18];            // Get new_cost
      save[i+19] = noTabs[i+19];            // Get new_cost
      save[i+20] = noTabs[i+20];            // Get new_cost
      i+=21;
    }
   
  }

  function convert()
  {
    show();
    var string=document.getElementById("string1");
    var NEWstring=save.toString();
    string.value=NEWstring;
  }

</script>

<br>
<form method="post">
  <input name="string1" id="string1" type="hidden" value="aaa"/>
  <input onclick="convert();" name="BTN" type="submit" value="Convert and Update"/>
</form>

<?php
  
  if(isset($_POST['BTN']))
  {
    $PHParray=explode(',',$_POST['string1']);                                                                     // Get Javascript array
    //print_r($PHParray);
  }
  
  include('connection.php');

  // Check existing SKU
  $x = 0; $i = 0; $n = 0;
  $existSKU = array();
  $notexistSKU = array(); 
  
  // category sku  mfr product-name  retail  fba-price original-cost img-url collection  carryover product-id fnsku  asin date-created stock map-pol map-price map-status  new-cost
  
  while($x < sizeof($PHParray))
  {
    $now = $PHParray[$x+1];
    $sql = "SELECT SKU
            FROM
              products
            WHERE
              SKU = '$now'";
    $result = $conn->query($sql);

    # For existing SKUs
    if ($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc()) {
        $existSKU[$i] = $row["SKU"];                                                                             
        $existSKU[$i+1] = $PHParray[$x];        // Category
        $existSKU[$i+2] = $PHParray[$x+2];        // MFR
        $existSKU[$i+3] = $PHParray[$x+3];        // productName
        $existSKU[$i+4] = $PHParray[$x+4];        // retail
        $existSKU[$i+5] = $PHParray[$x+5];        // fba_price
        $existSKU[$i+6] = $PHParray[$x+6];        // original_cost
        $existSKU[$i+7] = $PHParray[$x+7];        // img_url
        $existSKU[$i+8] = $PHParray[$x+8];        // collection
        $existSKU[$i+9] = $PHParray[$x+9];        // carryover
        $existSKU[$i+10] = $PHParray[$x+10];        // productID
        $existSKU[$i+11] = $PHParray[$x+11];        // FNSKU
        $existSKU[$i+12] = $PHParray[$x+12];        // ASIN
        $existSKU[$i+13] = $PHParray[$x+13];        // dateCreated
        $existSKU[$i+14] = $PHParray[$x+14];        // stock
        $existSKU[$i+15] = $PHParray[$x+15];        // MAP_policy
        $existSKU[$i+16] = $PHParray[$x+16];        // MAP_price
        $existSKU[$i+17] = $PHParray[$x+17];        // MAP_status
        $existSKU[$i+18] = $PHParray[$x+18];        // new_cost
        $existSKU[$i+19] = $PHParray[$x+19];        // vendorName
        $existSKU[$i+20] = $PHParray[$x+20];        // brandName
        $i += 21;
      }
    }
    
    # For non-existing SKUs
    else{   
      $notexistSKU[$n] = $PHParray[$x+1];
      $notexistSKU[$n+1] = $PHParray[$x];        // Category
      $notexistSKU[$n+2] = $PHParray[$x+2];        // MFR
      $notexistSKU[$n+3] = $PHParray[$x+3];        // productName
      $notexistSKU[$n+4] = $PHParray[$x+4];        // retail
      $notexistSKU[$n+5] = $PHParray[$x+5];        // fba_price
      $notexistSKU[$n+6] = $PHParray[$x+6];        // original_cost
      $notexistSKU[$n+7] = $PHParray[$x+7];        // img_url
      $notexistSKU[$n+8] = $PHParray[$x+8];        // collection
      $notexistSKU[$n+9] = $PHParray[$x+9];        // carryover
      $notexistSKU[$n+10] = $PHParray[$x+10];        // productID
      $notexistSKU[$n+11] = $PHParray[$x+11];        // FNSKU
      $notexistSKU[$n+12] = $PHParray[$x+12];        // ASIN
      $notexistSKU[$n+13] = $PHParray[$x+13];        // dateCreated
      $notexistSKU[$n+14] = $PHParray[$x+14];        // stock
      $notexistSKU[$n+15] = $PHParray[$x+15];        // MAP_policy
      $notexistSKU[$n+16] = $PHParray[$x+16];        // MAP_price
      $notexistSKU[$n+17] = $PHParray[$x+17];        // MAP_status
      $notexistSKU[$n+18] = $PHParray[$x+18];        // new_cost
      $notexistSKU[$n+19] = $PHParray[$x+19];        // vendorName
      $notexistSKU[$n+20] = $PHParray[$x+20];        // brandName
      $n += 21;      
    }
    
    $x += 21;
  }   

  
  # UPDATE FOR EXISTING
  $counter = 0;
  if(sizeof($existSKU) != 0){  
    //print_r($existSKU);  
    while($counter < $i)
    {
      $c1 = $existSKU[$counter+1]; $c2 = $existSKU[$counter+2]; $c3 = $existSKU[$counter+3]; $c4 = $existSKU[$counter+4]; $c5 = $existSKU[$counter+5];
      $c6 = $existSKU[$counter+6]; $c7 = $existSKU[$counter+7]; $c8 = $existSKU[$counter+8]; $c9 = $existSKU[$counter+9]; $c10 = $existSKU[$counter+10];
      $c11 = $existSKU[$counter+11]; $c12 = $existSKU[$counter+12]; $c13 = $existSKU[$counter+13]; $c14 = $existSKU[$counter+14]; $c15 = $existSKU[$counter+15];
      $c16 = $existSKU[$counter+16]; $c17 = $existSKU[$counter+17]; $c18 = $existSKU[$counter+18]; $c19 = $existSKU[$counter+19]; $c20 = $existSKU[$counter+20];
      $current = $existSKU[$counter];

      if(substr($c9, 0, 1) === 'C' || substr($c9, 0, 1) === 'c'){                   // Carryover
        $c9 = 1;
      }
      else if(substr($c9, 0, 1) === 'N' || substr($c9, 0, 1) === 'n'){              // Non-carryover
        $c9 = 2;
      }
      else{
        $c9 = 0;
      }

      $c3 = addslashes($c3); $c7 = addslashes($c7); $c19 = addslashes($c19); $c20 = addslashes($c20);
      $c4 = str_replace("$","",$c4); $c5 = str_replace("$","",$c5); $c6 = str_replace("$","",$c6); $c18 = str_replace("$","",$c18);

      $sql = "UPDATE products
              SET `category`='$c1',
                  `MFR`='$c2',
                  `productName`='$c3',
                  `retail_MSRP`='$c4',
                  `fba_price`='$c5',
                  `original_cost`='$c6',
                  `img_url`='$c7',
                  `collection`='$c8',
                  `carryover`='$c9',
                  `productID`='$c10',
                  `FNSKU`='$c11',
                  `ASIN`='$c12',
                  `dateCreated`='$c13',
                  `afn-total-quantity`='$c14',
                  `MAP_policy`='$c15',
                  `MAP_price`='$c16',
                  `MAP_status`='$c17',
                  `new_cost`='$c18',
                  `vendorT`='$c19',
                  `brandT`='$c20'
              WHERE
                SKU = '$current'";

      if ($conn->query($sql) === TRUE)
      {
        //echo '<script type="text/javascript"> alert("YEY"); </script>';
      }
      else
      {      
        //echo '<script type="text/javascript"> alert('.$conn->error.'); </script>';
      }

      $counter += 21;
      
    }
  }  

  # INSERT FOR EXISTING
  $counter = 0;
  if(sizeof($notexistSKU) != 0){
    //print_r($notexistSKU);
    while($counter < $n)
    {      
      $c1 = $notexistSKU[$counter+1]; $c2 = $notexistSKU[$counter+2]; $c3 = $notexistSKU[$counter+3]; $c4 = $notexistSKU[$counter+4]; $c5 = $notexistSKU[$counter+5];
      $c6 = $notexistSKU[$counter+6]; $c7 = $notexistSKU[$counter+7]; $c8 = $notexistSKU[$counter+8]; $c9 = $notexistSKU[$counter+9]; $c10 = $notexistSKU[$counter+10];
      $c11 = $notexistSKU[$counter+11]; $c12 = $notexistSKU[$counter+12]; $c13 = $notexistSKU[$counter+13]; $c14 = $notexistSKU[$counter+14]; $c15 = $notexistSKU[$counter+15];
      $c16 = $notexistSKU[$counter+16]; $c17 = $notexistSKU[$counter+17]; $c18 = $notexistSKU[$counter+18]; $c19 = $notexistSKU[$counter+19]; $c20 = $notexistSKU[$counter+20];
      $current = $notexistSKU[$counter];

      if(substr($c9, 0, 1) === 'C' || substr($c9, 0, 1) === 'c'){                   // Carryover
        $c9 = 1;      
      }
      else if(substr($c9, 0, 1) === 'N' || substr($c9, 0, 1) === 'n'){              // Non-carryover
        $c9 = 2;
      }
      else{
        $c9 = 0;
      }

      $c3 = addslashes($c3); $c7 = addslashes($c7); $c19 = addslashes($c19); $c20 = addslashes($c20);
      $c4 = str_replace("$","",$c4); $c5 = str_replace("$","",$c5); $c6 = str_replace("$","",$c6); $c18 = str_replace("$","",$c18);

      $sql = "INSERT INTO products (SKU, category, MFR, productName, retail_MSRP, fba_price, original_cost, img_url, collection, carryover, productID,
                          FNSKU, ASIN, dateCreated, `afn-total-quantity`, MAP_policy, MAP_price, MAP_status, new_cost, vendorT, brandT)
              VALUES ('$current', '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8', '$c9', '$c10', '$c11', '$c12', '$c13', '$c14', '$c15', '$c16', '$c17', '$c18', '$c19', '$c20')
              ";

      if ($conn->query($sql) === TRUE) {    
        
      }
      else {        
        
      }
      $counter += 21;
    }    
  }    

  $conn->close();  
  

?>

</body>
</html>