<?php
//include('connection.php');
$servername = "localhost";
$username = "mfi";
$password = "mfiuser";
$dbname = "mfi_db";

//$conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!empty($_POST))
{
   $output = '';
   $message = '';
   $brandIDDB = mysqli_real_escape_string($conn, $_POST["brand"]);
   $query;
   if($_POST["productID"] != '')
   {
        $query = "
        UPDATE products
        SET brandID='$brandIDDB'
        WHERE pID='".$_POST["productID"]."'";
        $message = 'Data Updated';
        mysqli_query($conn, $query);
   }

   if(mysqli_query($conn, $query))
      {
           $output .= '<label class="text-success">' . $message . '</label>';
           $select_query = "SELECT * FROM products WHERE brandID = 0";
           $result = mysqli_query($conn, $select_query);
           $output .= '
                <table class="table table-bordered">
                     <tr>
                          <th width="70%">Product Name</th>
                          <th width="15%">Edit</th>
                          <th width="15%">View</th>
                     </tr>
           ';
           while($row = mysqli_fetch_array($result))
           {
                $output .= '
                     <tr>
                          <td>' . $row["productName"] . '</td>
                          <td><input type="button" name="edit" value="Edit" id="'.$row["id"] .'" class="btn btn-info btn-xs edit_data" /></td>
                          <td><input type="button" name="view" value="view" id="' . $row["id"] . '" class="btn btn-info btn-xs view_data" /></td>
                     </tr>
                ';
           }
           $output .= '</table>';
      }
      echo $output;
 }


mysqli_close($conn);
?>
