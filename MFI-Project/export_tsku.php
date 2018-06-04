<?php  

$connect = mysqli_connect("localhost", "mfi", "mfiuser", "mfi_db");
$output = '';
    if(isset($_POST["export2"])) {

    $query = "SELECT SKU, productName, `inv-age-0-to-90-days` AS first, `inv-age-91-to-180-days` AS second, `inv-age-181-to-270-days` AS third, `inv-age-271-to-365-days` AS fourth, `inv-age-365-plus-days` AS fifth
                FROM
                  products
            ";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) > 0) {
        $output .= '<table class="table" style="border: 0.5px solid #d0d7e5;">  
                       <tr style="max-width:100%; white-space:nowrap;">
                            <th style="background: #ffccff">inv-age-0-to-90-days</th>  
                            <th style="background: #ffccff; color: red">aged-days-total</th>  
                            <th style="background: #ffccff; text-align: left">product-name</th>  
                            <th style="background: #ffccff; text-align: left">sku</th>
                            <th style="background: #ffccff">inv-age-91-to-180-days</th>
                            <th style="background: #ffccff">inv-age-181-to-270-days</th>
                            <th style="background: #ffccff">inv-age-271-to-365-days</th>
                            <th style="background: #ffccff">inv-age-365-plus-days</th>                 
                        </tr>
                    ';

        while($row = mysqli_fetch_array($result)) {
            $agedTotal = number_format($row["inv-age-91-to-180-days"]) + number_format($row["inv-age-181-to-270-days"]) + number_format($row["inv-age-271-to-365-days"]) + number_format($row["inv-age-365-plus-days"]);
            if($agedTotal != 0){
                $output .= '
                    <tr style="text-align: center">  
                        <td>'.$row["first"].'</td>
                        <td style="color: red">'.$agedTotal.'</td>  
                        <td style="text-align: left">'.$row["productName"].'</td>  
                        <td style="text-align: left">'.$row["SKU"].'</td>  
                        <td>'.$row["second"].'</td>  
                        <td>'.$row["third"].'</td>
                        <td>'.$row["fourth"].'</td>
                        <td>'.$row["fifth"].'</td>  
                    </tr>
                    ';
                }
        }

        $final = "Potential Trouble SKUs(".date('m-d-y').")";        

        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename="'.$final.'".xls');
        echo $output;
        }
    }
?>
