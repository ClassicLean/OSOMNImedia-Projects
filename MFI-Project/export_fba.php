<?php  

$connect = mysqli_connect("localhost", "mfi", "mfiuser", "mfi_db");
$output = '';
    
    if(isset($_POST["export"])) {        
    
    $query = "SELECT brandName, SKU, productName, your_price, retail_MSRP, fba_price, `afn-inbound-working-quantity`, `afn-inbound-shipped-quantity`, `afn-inbound-receiving-quantity`,
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
    $result = mysqli_query($connect, $query);

    
    if(mysqli_num_rows($result) > 0) {
        $fba_total = 0;
        // Total FBA Value
        while($row = mysqli_fetch_array($result)) {
            $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
            $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]);
            $fba_value = number_format($row["new_cost"], 2) * $sum_qty;
            $fba_total = $fba_total + $fba_value;
        }

        $output .= '        
        <table class="table" style="border: 0.5px solid #d0d7e5;">  
            <tr style="max-width:100%; white-space:nowrap; background: #ffff99">
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
                <th style="background: #00ffff">Total FBA Value</th>
                <th style="background: #00ffff; color: blue">$'.$fba_total.'</th>
                <th>FNSKU</th>
                <th>ASIN</th>
            </tr>
        ';

        $result = mysqli_query($connect, $query);
        while($row = mysqli_fetch_array($result)) {
            $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
            $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]); 
            $fba_value = number_format($row["new_cost"], 2) * $sum_qty;       
            $output .= '
                <tr>  
                    <td>'.$row["brandName"].'</td>
                    <td>'.$row["SKU"].'</td>  
                    <td>'.$row["productName"].'</td>  
                    <td>'.$row["your_price"].'</td>  
                    <td>$'.number_format($row["retail_MSRP"], 2).'</td>  
                    <td>$'.number_format($row["fba_price"], 2).'</td>
                    <td>'.$sum_inbound.'</td>
                    <td>$'.number_format($row["afn-fulfillable-quantity"]).'</td>
                    <td>$'.number_format($row["afn-unsellable-quantity"]).'</td>
                    <td>$'.number_format($row["afn-reserved-quantity"]).'</td>
                    <td>$'.number_format($row["new_cost"], 2).'</td>
                    <td>$'.$fba_value.'</td>                
                    <td></td>
                    <td>'.$row["FNSKU"].'</td>
                    <td>'.$row["ASIN"].'</td>
                </tr>
                ';
        }

        $my = date('F Y');
        $week = date('W');

        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename="Total FBA Value - '.$my.' - Week '.$week.'".xls');
        echo $output;
        }
    }







    // BRAND ONLY
    if(isset($_POST["exportBrand"])) {        
    
    $query = "SELECT `afn-inbound-working-quantity`, `afn-inbound-shipped-quantity`, `afn-inbound-receiving-quantity`, `afn-fulfillable-quantity`, `afn-unsellable-quantity`, `afn-reserved-quantity`, new_cost
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
    $result = mysqli_query($connect, $query);

    
    if(mysqli_num_rows($result) > 0) {
        $fba_total = 0;
        // Total FBA Value
        while($row = mysqli_fetch_array($result)) {
            $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
            $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]);
            $fba_value = number_format($row["new_cost"], 2) * $sum_qty;
            $fba_total = $fba_total + $fba_value;
        }

        $output .= '        
        <table class="table" style="border: 0.5px solid #d0d7e5;">  
            <tr style="max-width:100%; white-space:nowrap; background: #ffff99">
                <th style="text-align: left">Brands</th>  
                <th>Value</th>                                
            </tr>
            <tr style="max-width:100%; white-space:nowrap; background: #ffff99">
                <th style="text-align: left">TOTAL</th>
                <th>$'.$fba_total.'</th>
            </tr>
        ';

        // GET EVERY BRAND FIRST
        $query = "SELECT products.brandID as brandID
                    FROM products
                        INNER JOIN brands
                            ON products.brandID = brands.brandID
                        INNER JOIN vendors
                            ON brands.vendorID = vendors.vendorID
                    WHERE 
                        `afn-inbound-working-quantity` != '0' OR `afn-inbound-shipped-quantity` != '0' OR `afn-inbound-receiving-quantity` != '0' OR `afn-fulfillable-quantity`  != '0' OR `afn-unsellable-quantity` != '0' OR `afn-reserved-quantity` != '0'
                    GROUP BY brandName
                    ORDER BY brandName ASC
            ";
        $result = mysqli_query($connect, $query);

        while($row = mysqli_fetch_array($result)) {            
            $query2 = "SELECT brandName, `afn-inbound-working-quantity`, `afn-inbound-shipped-quantity`, `afn-inbound-receiving-quantity`, `afn-fulfillable-quantity`, `afn-unsellable-quantity`, `afn-reserved-quantity`, new_cost
                        FROM products
                            INNER JOIN brands
                                ON products.brandID = brands.brandID
                            INNER JOIN vendors
                                ON brands.vendorID = vendors.vendorID
                        WHERE 
                            (`afn-inbound-working-quantity` != '0' OR `afn-inbound-shipped-quantity` != '0' OR `afn-inbound-receiving-quantity` != '0' OR `afn-fulfillable-quantity`  != '0' OR `afn-unsellable-quantity` != '0' OR `afn-reserved-quantity` != '0')
                            AND
                            products.brandID = '".$row['brandID']."'
            ";
            $result2 = mysqli_query($connect, $query2);

            $fba_total = 0;
            while($row = mysqli_fetch_array($result2)) {
                $brand = $row["brandName"];
                $sum_inbound = number_format($row["afn-inbound-working-quantity"]) + number_format($row["afn-inbound-shipped-quantity"]) + number_format($row["afn-inbound-receiving-quantity"]);
                $sum_qty = $sum_inbound + number_format($row["afn-fulfillable-quantity"]) + number_format($row["afn-unsellable-quantity"]) + number_format($row["afn-reserved-quantity"]); 
                $fba_value = (number_format($row["new_cost"], 2) * $sum_qty);
                $fba_total = $fba_total + $fba_value;
            }

            $output .= '
                <tr>  
                    <td>'.$brand.'</td>
                    <td>$'.$fba_total.'</td>
                </tr>
                ';            
        }

        $my = date('F Y');
        $week = date('W');

        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename="total-value-per-brand ('.$my.' - Week '.$week.')".xls');
        echo $output;
        }
    }

?>
