<?php
  include('connection.php');

  if
  (
    isset($_GET['skuPHPData'])                        ||
    isset($_GET['fnskuPHPData'])                      ||
    isset($_GET['asinPHPData'])                       ||
    isset($_GET['productNamePHPData'])                ||
    isset($_GET['condPHPData'])                       ||
    isset($_GET['fba_pricePHPData'])                  ||
    isset($_GET['mfnListingExistsPHPData'])           ||
    isset($_GET['mfnFulfillableQuantityPHPData'])     ||
    isset($_GET['afnListingExistsPHPData'])           ||
    isset($_GET['afnWarehouseQuantityPHPData'])       ||
    isset($_GET['afnFulfillableQuantityPHPData'])     ||
    isset($_GET['afnUnsellableQuantityPHPData'])      ||
    isset($_GET['afnReservedQuantityPHPData'])        ||
    isset($_GET['stockPHPData'])                      ||
    isset($_GET['perUnitVolumePHPData'])              ||
    isset($_GET['afnInboundWorkingQuantityPHPData'])  ||
    isset($_GET['afnInboundShippedQuantityPHPData'])  ||
    isset($_GET['afnInboundReceivingQuantityPHPData'])
  )
  {

    $skuDB =  $_GET['skuPHPData'];
    $fnskuDB =  $_GET['fnskuPHPData'];
    $asinDB =  $_GET['asinPHPData'];
    $productNameDB =  $_GET['productNamePHPData'];
    $condDB =  $_GET['condPHPData'];
    $fba_priceDB =  $_GET['fba_pricePHPData'];
    $mfnListingExistsDB =  $_GET['mfnListingExistsPHPData'];
    $mfnFulfillableQuantityDB =  $_GET['mfnFulfillableQuantityPHPData'];
    $afnListingExistsDB =  $_GET['afnListingExistsPHPData'];
    $afnWarehouseQuantityDB =  $_GET['afnWarehouseQuantityPHPData'];
    $afnFulfillableQuantityDB =  $_GET['afnFulfillableQuantityPHPData'];
    $afnUnsellableQuantityDB =  $_GET['afnUnsellableQuantityPHPData'];
    $afnReservedQuantityDB =  $_GET['afnReservedQuantityPHPData'];
    $stockDB =  $_GET['stockPHPData'];
    $perUnitVolumeDB =  $_GET['perUnitVolumePHPData'];
    $afnInboundWorkingQuantityDB =  $_GET['afnInboundWorkingQuantityPHPData'];
    $afnInboundShippedQuantityDB =  $_GET['afnInboundShippedQuantityPHPData'];
    $afnInboundReceivingQuantityDB =  $_GET['afnInboundReceivingQuantityPHPData'];

    $sql = /*"INSERT INTO products
      (
        SKU,
        FNSKU,
        `ASIN`,
        productName,
        cond,
        fba_price,
        `mfn-listing-exists`,
        `mfn-fulfillable-quantity`,
        `afn-listing-exists`,
        `afn-warehouse-quantity`,
        `afn-fulfillable-quantity`,
        `afn-unsellable-quantity`,
        `afn-reserved-quantity`,
        `afn-total-quantity`,
        `per-unit-volume`,
        `afn-inbound-working-quantity`,
        `afn-inbound-shipped-quantity`,
        `afn-inbound-receiving-quantity`
      )
      VALUES
      (
        '$skuDB',
        '$fnskuDB',
        '$asinDB',
        '$productNameDB',
        '$condDB',
        '$fba_priceDB',
        '$mfnListingExistsDB',
        '$mfnFulfillableQuantityDB',
        '$afnListingExistsDB',
        '$afnWarehouseQuantityDB',
        '$afnFulfillableQuantityDB',
        '$afnUnsellableQuantityDB',
        '$afnReservedQuantityDB',
        '$stockDB',
        '$perUnitVolumeDB',
        '$afnInboundWorkingQuantityDB',
        '$afnInboundShippedQuantityDB',
        '$afnInboundReceivingQuantityDB'
      )
      ON DUPLICATE KEY */
        "UPDATE products
        SET
		    SKU = '$skuDB',
        FNSKU = '$fnskuDB',
        ASIN = '$asinDB',
        productName = '$productNameDB',
        cond = '$condDB',
        fba_price = '$fba_priceDB',
        `mfn-listing-exists` = '$mfnListingExistsDB',
        `mfn-fulfillable-quantity` = '$mfnFulfillableQuantityDB',
        `afn-listing-exists` = '$afnListingExistsDB',
        `afn-warehouse-quantity` = '$afnWarehouseQuantityDB',
        `afn-fulfillable-quantity` = '$afnFulfillableQuantityDB',
        `afn-unsellable-quantity` = '$afnUnsellableQuantityDB',
        `afn-reserved-quantity` = '$afnReservedQuantityDB',
        `afn-total-quantity` = '$stockDB',
        `per-unit-volume` = '$perUnitVolumeDB',
        `afn-inbound-working-quantity` = '$afnInboundWorkingQuantityDB',
        `afn-inbound-shipped-quantity` = '$afnInboundShippedQuantityDB',
        `afn-inbound-receiving-quantity` = '$afnInboundReceivingQuantityDB'
        WHERE SKU = '$skuDB'";

        if (mysqli_query($conn, $sql))
        {
            echo "<script>alert('Update successful');</script>";
        }
        else
        {
            echo "<script>alert('SKU not found');</script>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
  }
  else
  {

?>

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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

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

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

</head>

<body style="padding-left: 30px; padding-right: 50px; text-align: center">

  <div class="center-div">

        <h2 style="display: block; padding: 0px 0 0 0;"> Upload mfi.txt </h2>
        <p> Uploading the file will automatically submit it. <br>
            Please select .txt file of which contents are to be read: </p>

        <!-- File Button -->
        <br>

        <div class="path">
          <label class="btn btn-default">
              <img src="images/upload_txt.png" style="height: 100px; width: 100px;"><br>
              <span style="color: #0A83C8; font-weight: bold">Click to choose file</span>
              <input type="file" class="form-control-file" id="txtfiletoread" aria-describedby="fileHelp" hidden>
          </label>
        </div>
        <span id="path" style="color: black"></span>

        <br><br>
        <div id="filecontents" style="white-space: nowrap; font-family: 'Courier New'" hidden></div>


  </div>

</body>

<script>
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
            alert("Upload successful");
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

  function getNumWordRow(inputText)
  {
    let newLine = '';
    let newStr = [];
    let wordCounter = 0;
    let wordRow = -1;
    let numWordRow = 0;

    for(let counter = 0; counter<inputText.length;counter++)
    {
      newLine += inputText.charAt(counter);
      if(inputText.charAt(counter) == '\t' || inputText.charAt(counter) == '\n')
      {
        if(inputText.charAt(counter) == '\n')
        {
          wordRow++;
          if(wordRow == 0)
          {
            numWordRow = newStr.length + 1;
          }
        }

        newStr.push(newLine);
        newLine = '';
        wordCounter++;
      }
    }
    return numWordRow;
  }

  let numSku = 0;
  let numFnsku = 0;
  let numAsin = 0;
  let numProductName = 0;
  let numCondition = 0;
  let numYourPrice = 0;
  let numMfnListingExists = 0;
  let numMfnFulfillableQuantity = 0;
  let numAfnListingExists = 0;
  let numAfnWarehouseQuantity = 0;
  let numAfnFulfillableQuantity = 0;
  let numAfnUnsellableQuantity = 0;
  let numAfnReservedQuantity = 0;
  let numAfnTotalQuantity = 0;
  let	numPerUnitVolume = 0;
  let numAfnInboundWorkingQuantity = 0;
  let numAfnInboundShippedQuantity = 0;
  let numAfnInboundReceivingQuantity = 0;

  function getWords(inputText)
  {
    let newLine = '';
		let newStr = [];
    let wordCounter = 0;
    let wordRow = -1;
    let numWordRow = getNumWordRow(inputText);


    for(let counter = 0; counter<inputText.length;counter++)
		{
      newLine += inputText.charAt(counter);
			if(inputText.charAt(counter) == '\t' || inputText.charAt(counter) == '\n')
			{
        if(inputText.charAt(counter) == '\n')
        {
          wordRow++;
          if(wordRow > 0)
          {

            let wordLocation = numWordRow*wordRow;
            if(newStr[wordLocation+numSku]                    != '' ||
            newStr[wordLocation+numFnsku]                     != '' ||
            newStr[wordLocation+numAsin]                      != '' ||
            newStr[wordLocation+numProductName]               != '' ||
            newStr[wordLocation+numCondition]                 != '' ||
            newStr[wordLocation+numYourPrice]                 != '' ||
            newStr[wordLocation+numMfnListingExists]          != '' ||
            newStr[wordLocation+numMfnFulfillableQuantity]    != '' ||
            newStr[wordLocation+numAfnListingExists]          != '' ||
            newStr[wordLocation+numAfnWarehouseQuantity]      != '' ||
            newStr[wordLocation+numAfnFulfillableQuantity]    != '' ||
            newStr[wordLocation+numAfnUnsellableQuantity]     != '' ||
            newStr[wordLocation+numAfnReservedQuantity]       != '' ||
            newStr[wordLocation+numAfnTotalQuantity]          != '' ||
            newStr[wordLocation+numPerUnitVolume]             != '' ||
            newStr[wordLocation+numAfnInboundWorkingQuantity] != '' ||
            newStr[wordLocation+numAfnInboundShippedQuantity] != '' ||
            newStr[wordLocation+(numAfnInboundReceivingQuantity-1)]  != '')
            {
              let sku = newStr[wordLocation+numSku].trim();
              let fnsku = newStr[wordLocation+numFnsku].trim();
              let asin = newStr[wordLocation+numAsin].trim();
              let productName = newStr[wordLocation+numProductName].trim();
              let condition = newStr[wordLocation+numCondition].trim();
              let yourPrice = newStr[wordLocation+numYourPrice].trim();
              let mfnListingExists = newStr[wordLocation+numMfnListingExists].trim();
              let mfnFulfillableQuantity = newStr[wordLocation+numMfnFulfillableQuantity].trim();
              let afnListingExists = newStr[wordLocation+numAfnListingExists].trim();
              let afnWarehouseQuantity = newStr[wordLocation+numAfnWarehouseQuantity].trim();
              let afnFulfillableQuantity = newStr[wordLocation+numAfnFulfillableQuantity].trim();
              let afnUnsellableQuantity = newStr[wordLocation+numAfnUnsellableQuantity].trim();
              let afnReservedQuantity = newStr[wordLocation+numAfnReservedQuantity].trim();
              let afnTotalQuantity = newStr[wordLocation+numAfnTotalQuantity].trim();
              let	perUnitVolume = newStr[wordLocation+numPerUnitVolume].trim();
              let afnInboundWorkingQuantity = newStr[wordLocation+numAfnInboundWorkingQuantity].trim();
              let afnInboundShippedQuantity = newStr[wordLocation+numAfnInboundShippedQuantity].trim();
              let afnInboundReceivingQuantity = newStr[wordLocation+(numAfnInboundReceivingQuantity-1)].trim();

              productName = productCommaCheck(productName);

              toPHP
              (
                sku,
                fnsku,
                asin,
                productName,
                condition,
                yourPrice,
                mfnListingExists,
                mfnFulfillableQuantity,
                afnListingExists,
                afnWarehouseQuantity,
                afnFulfillableQuantity,
                afnUnsellableQuantity,
                afnReservedQuantity,
                afnTotalQuantity,
                perUnitVolume,
                afnInboundWorkingQuantity,
                afnInboundShippedQuantity,
                afnInboundReceivingQuantity
              );

            }
          }
        }

        newStr.push(newLine);
        newLine = '';
        headCheck(newStr[wordCounter],wordCounter,numWordRow);
        wordCounter++;
			}
    }
  }

  function productCommaCheck(productComma)
  {
    return productComma.replace(/'/g,"''");
  }

function headCheck(newStr,wordCounter,numWordRow)
  {
    if(newStr.trim() == 'sku' && wordCounter <= numWordRow)
    {
      numSku = wordCounter;
    }

    else if(newStr.trim() == 'fnsku' && wordCounter <= numWordRow)
    {
      numFnsku = wordCounter;
    }
    else if(newStr.trim() == 'asin' && wordCounter <= numWordRow)
    {
      numAsin = wordCounter;
    }
    else if(newStr.trim() == 'product-name' && wordCounter <= numWordRow)
    {
      numProductName = wordCounter;
    }
    else if(newStr.trim() == 'condition' && wordCounter <= numWordRow)
    {
      numCondition = wordCounter;
    }
    else if(newStr.trim() == 'your-price' && wordCounter <= numWordRow)
    {
      numYourPrice = wordCounter;
    }
    else if(newStr.trim() == 'mfn-listing-exists' && wordCounter <= numWordRow)
    {
      numMfnListingExists = wordCounter;
    }
    else if(newStr.trim() == 'mfn-fulfillable-quantity' && wordCounter <= numWordRow)
    {
      numMfnFulfillableQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-listing-exists' && wordCounter <= numWordRow)
    {
      numAfnListingExists = wordCounter;
    }
    else if(newStr.trim() == 'afn-warehouse-quantity' && wordCounter <= numWordRow)
    {
      numAfnWarehouseQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-fulfillable-quantity' && wordCounter <= numWordRow)
    {
      numAfnFulfillableQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-unsellable-quantity' && wordCounter <= numWordRow)
    {
      numAfnUnsellableQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-reserved-quantity' && wordCounter <= numWordRow)
    {
      numAfnReservedQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-total-quantity' && wordCounter <= numWordRow)
    {
      numAfnTotalQuantity = wordCounter;
    }
    else if(newStr.trim() == 'per-unit-volume' && wordCounter <= numWordRow)
    {
      numPerUnitVolume = wordCounter;
    }
    else if(newStr.trim() == 'afn-inbound-working-quantity' && wordCounter <= numWordRow)
    {
      numAfnInboundWorkingQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-inbound-shipped-quantity' && wordCounter <= numWordRow)
    {
      numAfnInboundShippedQuantity = wordCounter;
    }
    else if(newStr.trim() == 'afn-inbound-receiving-quantity' && wordCounter <= numWordRow)
    {
      numAfnInboundReceivingQuantity = wordCounter;
    }
  }

  function toPHP
  (
    skuData,
    fnskuData,
    asinData,
    productNameData,
    conditionData,
    yourPriceData,
    mfnListingExistsData,
    mfnFulfillableQuantityData,
    afnListingExistsData,
    afnWarehouseQuantityData,
    afnFulfillableQuantityData,
    afnUnsellableQuantityData,
    afnReservedQuantityData,
    afnTotalQuantityData,
    perUnitVolumeData,
    afnInboundWorkingQuantityData,
    afnInboundShippedQuantityData,
    afnInboundReceivingQuantityData
  )
  {
    $.ajax(
      {
        url: 'http://osomniserver/toolsforyou/masterfile-project/upload.php',
        type: 'GET',
        data:
        {
          skuPHPData: skuData ,
          fnskuPHPData: fnskuData,
          asinPHPData: asinData,
          productNamePHPData: productNameData,
          condPHPData: conditionData,
          fba_pricePHPData: yourPriceData,
          mfnListingExistsPHPData: mfnListingExistsData,
          mfnFulfillableQuantityPHPData: mfnFulfillableQuantityData,
          afnListingExistsPHPData: afnListingExistsData,
          afnWarehouseQuantityPHPData: afnWarehouseQuantityData,
          afnFulfillableQuantityPHPData: afnFulfillableQuantityData,
          afnUnsellableQuantityPHPData: afnUnsellableQuantityData,
          afnReservedQuantityPHPData: afnReservedQuantityData,
          stockPHPData: afnTotalQuantityData,
          perUnitVolumePHPData: perUnitVolumeData,
          afnInboundWorkingQuantityPHPData: afnInboundWorkingQuantityData,
          afnInboundShippedQuantityPHPData: afnInboundShippedQuantityData,
          afnInboundReceivingQuantityPHPData: afnInboundReceivingQuantityData
        },
        success: function(data)
        {
        }
     });
  }
</script>
</html>
<?php
}
mysqli_close($conn);
?>
