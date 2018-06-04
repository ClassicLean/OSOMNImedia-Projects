<!DOCTYPE HTML>
<html>
<head>
<title>Upload</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

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
        
        document.getElementById("path").innerHTML = document.getElementById('txtfiletoread').value;
        document.getElementById("btnConvert").disabled = false;

        if (fileTobeRead.type.match(fileExtension))
        {
          var fileReader = new FileReader();

          fileReader.onload = function (e)
          {
            var fileContents = document.getElementById('filecontents');
            fileContents.innerText = fileReader.result;
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
    var text = text.replace(/[']+/g, "\'");
    var text = text.replace(/[, ]+|[,]/g, " ");
    var noTabs = text.split(/\t|<br\s*\/?>/g);

    var i=48; var x=0;                // Start at first data    
    while(i < noTabs.length)
    {
      save[x] = noTabs[i];            // Get SKU
      save[x+1] = noTabs[i+3];        // Product name
      save[x+2] = noTabs[i+10];       // Skip to inv-age-0-to-90-days in health
      save[x+3] = noTabs[i+11];
      save[x+4] = noTabs[i+12];
      save[x+5] = noTabs[i+13];
      save[x+6] = noTabs[i+14];
      x+=7;
      i+=47;                         // Go to next SKU
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

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

</head>

<body style="padding-left: 30px; padding-right: 50px; text-align: center">

  <div class="center-div">

        <h2 style="display: block; padding: 0px 0 0 0;"> Upload health.txt </h2>
        <p> Please select .txt file of which contents are to be read: </p>                                        

        <!-- File Button -->
        <br>

  <form class="form-horizontal" action="upload_health.php" method="post" name="upload_excel" enctype="multipart/form-data">
          <div class="path">
            <label class="btn btn-default">
                <img src="images/upload_txt.png" style="height: 100px; width: 100px;"><br>
                <span style="color: #0A83C8; font-weight: bold">Click to choose file</span>
                <input type="file" hidden name="file" id="txtfiletoread" aria-describedby="fileHelp" class="form-control-file">
            </label>
          </div>                 
          <span id="path" style="color: black"></span>
          
          <br><br>   
          <div id="filecontents" style="white-space: nowrap; font-family: 'Courier New'" hidden></div>

          <!-- Button -->
            <input name="string1" id="string1" type="hidden" value="aaa"/>
            <input onclick="convert();" name="submit" type="submit" id="btnConvert" class="btn button-loading" value="Import" style="background: #00bb9a; color: white; font-size: 12px; width: 100px;" disabled/>
  </form>  

  </div>

<br>
</body>

<?php

  include('connection.php');

  if(isset($_POST['submit'])) {

    if($_FILES["file"]["size"] > 0) {

      $PHParray=explode(',',$_POST['string1']);            // Get Javascript array
      //print_r($PHParray);

      // Check existing SKU
      $x = 0;
      while($x < sizeof($PHParray)) {
          $sql = "SELECT SKU
                  FROM
                    products
                  WHERE
                    SKU = '$PHParray[$x]'";
          $result = $conn->query($sql);
          
          $c1 = $PHParray[$x+1];  
          $c2 = $PHParray[$x+2];  
          $c3 = $PHParray[$x+3];
          $c4 = $PHParray[$x+4];
          $c5 = $PHParray[$x+5];
          $c6 = $PHParray[$x+6];

          # For existing SKUs
          if ($result->num_rows > 0) {                                                                                   
            $sql = "UPDATE products
                    SET 
                        `productName`='$c1',
                        `inv-age-0-to-90-days`='$c2',
                        `inv-age-91-to-180-days`='$c3',
                        `inv-age-181-to-270-days`='$c4',
                        `inv-age-271-to-365-days`='$c5',
                        `inv-age-365-plus-days`='$c6'                      
                    WHERE
                      SKU = '$PHParray[$x]'
                  ";
            $conn->query($sql);
          }
          $x+=7;        
      }

      $conn->close(); 

      echo '<script type="text/javascript">
              alert("health.txt successfully updated database.");
              window.location = "upload_health.php";
            </script>';   
    }

    else {
      echo '<script type="text/javascript">
              alert("Please upload a non-empty or the correct file.");
              window.location = "upload_health.php";
            </script>';    
    }
  }
?>
</html>