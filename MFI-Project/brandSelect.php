<?php
 if(isset($_POST["vendorIDPHP"]))
 {
      $output = '';
      include('connection.php');
      $query = "SELECT * FROM brands WHERE vendorID = '".$_POST["vendorIDPHP"]."'";
      $result = mysqli_query($conn, $query);
      $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">
           <tr>
            <th>Brand Name</th>
           </tr>';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '
                <tr>
                     <td>'.$row["brandName"].'</td>
                </tr>
                ';
      }
      $output .= "</table></div>";
      echo $output;
 }
 ?>
