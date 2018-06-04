<?php  

if(isset($_POST["brand"])){    

    include('connection.php');

    $sql = "SELECT SKU, productName, brandID
            FROM
                products
            WHERE
                brandID = 0
            ";
    $result = $conn->query($sql);

    $counter = 0;
    $arr = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $arr[$counter] = $row["SKU"];
            $first = explode(' ',trim($row["productName"]));            
            $arr[$counter+1] = $first[0];
            $counter+=2;
        }
    }

    // Get brandID from vendorName (In cases with similar brandName but different vendorID)

    $brandID = array();   // Stores all brandID
    $counter = 0;       // Retrieve SKU from above    

    while($counter < sizeof($arr)) {
        $sku = $arr[$counter];
        $brand = $arr[$counter+1];

        $sql = "SELECT brandID, brandName, count(brandID) as count
                FROM
                    brands
                WHERE
                    brandName LIKE '%$brand%'
                HAVING
                    count > 0
            ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row["count"] = 1){
                    $brandID = $row["brandID"];                        
                }
            }
        }

        $sql = "UPDATE products
                SET `brandID` = '$brandID'
                WHERE
                  SKU = '$sku'";        

        if ($conn->query($sql) === TRUE) {
        }
        else {          
        }

        $counter += 2;
    }
    
    $conn->close();

    echo "<script type=\"text/javascript\">
            alert(\"Branding successful.\");
            window.location = \"brandless.php\"
        </script>";

}

?>
