<?php

if(isset($_POST["Import"])){		
		
	if($_FILES["file"]["size"] > 0) {

		/////	OPENING FILE 	/////
		$filename=$_FILES["file"]["tmp_name"];		
		$file = fopen($filename, "r");

		$skip = 0;
		while ($row = fgetcsv($file, 1000000, ",")) {
		    include('connection.php');								
			if($skip != 0){
				$c0 = $row[0]; $c1 = $row[1]; $c2 = $row[2]; $c3 = $row[3]; $c4 = $row[4];
				$c10 = $row[10]; $c11 = $row[11]; $c12 = $row[12]; $c13 = $row[13]; $c14 = $row[14]; $c15 = $row[15];
				$c16 = $row[16]; $c17 = $row[17]; $c19 = $row[19];							

				if(substr($c11, 0, 1) === 'C' || substr($c11, 0, 1) === 'c'){                   // Carryover
					$c11 = 1;      
				}
				else if(substr($c11, 0, 1) === 'N' || substr($c11, 0, 1) === 'n'){              // Non-carryover
					$c11 = 2;
				}
				else{
					$c11 = 0;
				}				 				
				$c5 = addslashes($row[5]); $c9 = addslashes($row[9]);
				$c6 = str_replace("$","",$row[6]); $c7 = str_replace("$","",$row[7]); $c8 = str_replace("$","",$row[8]);
				$c18 = str_replace("$","",$row[18]); $c20 = str_replace("$","",$row[20]);
				
				$sql = "SELECT SKU
						FROM 
							products						
						WHERE
							SKU = '$c3'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0){		// Existing
					
					$sql = "UPDATE products
				              SET `category`='$c2',                  
				                  `MFR`='$c4',
				                  `productName`='$c5',
				                  `retail_MSRP`='$c6',
				                  `fba_price`='$c7',
				                  `original_cost`='$c8',
				                  `img_URL`='$c9',
				                  `collection`='$c10',
				                  `carryover`='$c11',
				                  `productID`='$c12',
				                  `FNSKU`='$c13',
				                  `ASIN`='$c14',
				                  `dateCreated`='$c15',
				                  `afn-total-quantity`='$c16',
				                  `MAP_policy`='$c17',
				                  `MAP_price`='$c18',
				                  `MAP_status`='$c19',
				                  `new_cost`='$c20'
				              WHERE
				                SKU = '$c3'";

							if ($conn->query($sql) === TRUE) {
								echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully imported.\");
								window.location = \"upload_master.php\"
								</script>";	
							}
							else {								
								echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"upload_master.php\"
							  	</script>";
							}
				}
				else {							// New

					$sql = "SELECT brandID, vendorName, brandName
							FROM 
								brands						
								INNER JOIN vendors
									ON brands.vendorID = vendors.vendorID
							WHERE
								vendorName = '$c0' AND brandName = '$c1'
							";
					$result = $conn->query($sql);

					$brandID = 0;
					if ($result->num_rows > 0){
						while($row = $result->fetch_assoc()) {
							$brandID = $row["brandID"];
						}
					}	
					
					/*
					echo $c0."---".$c1."---".$brandID."<br>";		

					echo $c2."--4>>".$c3."--5>>".$c4."--6>>".$c6."---7>>".$c7."---8>>".$c8."---9>>".$c9."---10>>".$c00."---15>>".$c5
								."---16>>".$c06."---17>>".$c07."---18>>".$c08."---19>>".$c09."---20>>".$c10."---22>>".$c12."---23>>".$c13."---24>>".$c14
								."---25>>".$c15."---26>>".$c16."---brandID>>".$brandID."<br><br>";
					// */
					 
					$sql = "INSERT INTO products (category, SKU, MFR, productName, retail_MSRP, fba_price, original_cost, img_URL, collection, carryover, productID, FNSKU,
												ASIN, dateCreated, `afn-total-quantity`, MAP_policy, MAP_price, MAP_status, new_cost, brandID) 
							VALUES ('$c2',	#category
									'$c3',	#SKU
									'$c4',	#MFR
									'$c5',	#productName
									'$c6',	#retail_MSRP
									'$c7',	#fba_price
									'$c8',	#original_cost
									'$c9',	#img_URL
									'$c10',	#collection
									'$c11',	#carryover
									'$c12',	#productID
									'$c13',	#FNSKU
									'$c14',	#ASIN
									'$c15',	#dateCreated
									'$c16',	#`atn-total-quantity`
									'$c17',	#MAP_policy
									'$c18',	#MAP_price
									'$c19',	#MAP_status
									'$c20',	#new_cost
									'$brandID')";
					$result = mysqli_query($conn, $sql);	

					if(!isset($result)) {
						echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"upload_master.php\"
							  </script>";		
					}
					else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully imported.\");
						window.location = \"upload_master.php\"
						</script>";			
					}
					  // */

				}
			}
			$skip = 1;			
		}		 	
		
		$conn->close();
		fclose($file);	

		echo "<script type=\"text/javascript\">
				alert(\"CSV File has been successfully imported.\");
				window.location = \"upload_master.php\"
				</script>";	
	}

	else {								
		echo "<script type=\"text/javascript\">
		alert(\"Invalid File:Please Upload CSV File.\");
		window.location = \"upload_master.php\"
	  	</script>";
	}

}
	
?>