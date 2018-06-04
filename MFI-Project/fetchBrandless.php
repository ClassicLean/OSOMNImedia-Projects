<?php

include('connection.php');

if(isset($_POST["productID"]))
{
   $query = "SELECT * FROM products WHERE pID = '".$_POST["productID"]."'";
   $result = mysqli_query($conn, $query);
   $row = mysqli_fetch_array($result);
   echo json_encode($row);
}
?>
