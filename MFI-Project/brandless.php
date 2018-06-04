<?php
  include('connection.php');
  $brandlessSQL = "SELECT * FROM products WHERE `brandID` = 0";
  $brandlessResult = $conn->query($brandlessSQL);
?>

<!DOCTYPE HTML>
<html>
<head>

  <title>Brandless Items</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<style>
/* Dropdown Button */
.dropbtn {
    background-color: #3498DB;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;    
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;

    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    font-family: 'Work Sans', sans-serif;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
  background-color: transparent;
}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
  .show {
    display:block;
  }

  button {
    font-family: 'Work Sans', sans-serif;
  }
</style>

<script>

  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  function filterFunction() {
      var input, filter, ul, li, a, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      div = document.getElementById("myDropdown");
      a = div.getElementsByTagName("a");
      for (i = 0; i < a.length; i++) {
          if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
          } else {
              a[i].style.display = "none";
          }
      }
  }

  function getID(value){
    document.getElementById("brand").value = value;
  }

</script>

</head>

<body style="padding-top: 15px; padding-right: 20px;">

  <form class="form-horizontal" action="brandID.php" method="post" enctype="multipart/form-data">                                    
          <button type="submit" id="submit" name="brand" class="btn btn-primary button-loading" data-loading-text="Loading..." style="text-align: center; margin: 10px 0 10px 20px; font-size: 12px; width: 6%;">Update All</button>
  </form>

  <!-- TABLE -->
  <table id="brandlessTableID" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
  	<thead style="font-size: 12px">
      <tr style="max-width:100%; white-space:nowrap; color: #383737">
  			<th>Product Name</th>
      </tr>
    </thead>
    	<tbody style="font-size: 14px;">
  		<?php
  	  	while($row = mysqli_fetch_array($brandlessResult))
  			{
  		?>
  		    <tr>
  	    		<td>
              <?php echo $row["productName"] ?>              
              <input type="image" name="edit" value="" id="<?php echo $row["pID"] ?>" class="btn btn-info btn-xs edit_data" src="images/edit.png" style="background: transparent; border: 0px; height: 20px; width: 22px; padding: 3px 5px 0 0; float: right" /></td>
  	    		</td>
          </tr>
  		<?php
  			}
  		?>
  		</tbody>
  		<tfoot>
        <tr style="font-size: 10px; background: #c2bebb; color: #f7f2ee;">
          <th>Product Name</th>
  			</tr>
  		</tfoot>
  </table>
  <br>
</body>
</html>

<div id="dataModal" class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Brand ID</h4>
               </div>
               <div class="modal-body" id="employee_detail">
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
          </div>
     </div>
</div>

<div id="add_data_Modal" class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Brand ID</h4>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">
                         <label>Enter Brand ID</label>
                         <br>
                         <table>
                          <tr>
                              <td style="padding-right: 10px; width: 80%;"">
                                <input type="text" name="brand" id="brand" class="form-control"/>
                              </td>                          
                              <td>
                             <?php
                                $sql = "SELECT *
                                          FROM brands
                                          INNER JOIN vendors
                                            ON brands.vendorID = vendors.vendorID";
                                $result = $conn->query($sql);

                                echo '
                                      <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                                          Search Brand ID
                                        </button>
                                        <div id="myDropdown" class="dropdown-content" style="width: 250px">                                    
                                            <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" style="padding: 10px 5px 10px 5px; width: 100%">';

                                if(mysqli_num_rows($result) > 0) {    
                                  echo '<a class="dropdown-item" href="#"> <b>Brand ID</b> - Brand - Vendor </a>';
                                  while($row = mysqli_fetch_array($result)) {                                      
                                    echo '<a class="dropdown-item" href="#" name="'.$row[brandID].'" onclick="getID(this.name)"><b>'.$row[brandID].'</b> - '.$row[brandName].' - '.$row[vendorName].'</a>';
                                  }  
                                }   

                                echo '
                                      </div>
                                        </div>';                             
                             ?>
                              </td>
                            </tr>
                          </table>
                         <br />
                         <input type="hidden" name="productID" id="productID" />
                         <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                    </form>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
          </div>
     </div>
</div>

<script>
  'use strict';

  $(document).ready(function()
  {
    let brandlessTable = $('#brandlessTableID').DataTable({});
    $(document).on('click', '.edit_data', function()
     {
          var productID = $(this).attr("id");
          $.ajax(
          {
               url:"http://osomniserver/toolsforyou/masterfile-project/fetchBrandless.php",
               method:"POST",
               data:{productID:productID},
               dataType:"json",
               success:function(data)
               {                    
                    $('#brand').val(data.brandID);
                    $('#productID').val(data.pID);
                    $('#insert').val("Update");
                    $('#add_data_Modal').modal('show');
               }
          });
     });

       $('#insert_form').on("submit", function(event)
       {

             event.preventDefault();
             if($('#brand').val() == "")
             {
                   alert("Brand ID is required");
             }
             else
             {
                   $.ajax(
                   {
                         url:"http://osomniserver/toolsforyou/masterfile-project/brandlessUpdate.php",
                         method:"POST",
                         data:$('#insert_form').serialize(),
                         beforeSend:function()
                         {
                               $('#insert').val("Inserting");
                         },
                         success:function(data)
                         {
                               $('#insert_form')[0].reset();
                               $('#add_data_Modal').modal('hide');
                               location.reload();

                         }
                 });
            }

       });
   });

</script>
<?php
  $conn->close();
?>
