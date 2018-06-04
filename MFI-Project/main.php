<!DOCTYPE HTML>
<html>
<head>
<title>Masterfile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">

	html, body {
		height: 100%;
	}

	iframe {
		overflow-x: hidden;
		overflow-y: hidden;
	}

	p {
		font-family: 'Work Sans', sans-serif;
		color: black;
		display: inline-block;
	}

	table {
		width: 100%;
	}

	td {
		font-family: 'Work Sans', sans-serif;
		padding: 3px;
		text-align: center;
		vertical-align: middle;
	}

	iframe {
		width: 101%;
		height: 101%;
	}

	a:visited,
	a:hover,
	a:link,
	a:active {
		color: black;
	}


	/* Classes */

	.btn-outline-secondary:active,
	.btn-outline-secondary:focus,
	.btn-outline-secondary.active {
		background: #337ab7;
		border: 0px;
		color: white;
		text-decoration: none;
	}

	.drop {
		background: transparent;
		border: 0;
		color: black;
		width: 100%;
	}

	.icon {
		height: 32px;
		width: 32px;
	}

	.btn {
		text-decoration: none;
	}

	/* ID */

	#tr_special {
		height: 20px;
	}

	#container1 {
		width: 100%;
		height: 100%;
		overflow: hidden;
	}

	.float_center {
		float: right;

		position: relative;
		left: -50%; /* or right 50% */
		text-align: left;
	}

	body {
    padding: 0;
	}
	.wrapper {
	    margin:0 auto;
	    width:100%;
	}
	.static {
	    width:100%;
	    z-index:2;
	    height:100px;
	    position: fixed;
	}
	.header {

	}

</style>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<script>
	'use strict';

	function disableMain(value){
		if(value == 'hide'){
			document.getElementById("category").style.display = "none";

			document.getElementById("brandsButtonID").style.display = "none";
			document.getElementById("vendorsButtonID").style.display = "none";
			document.getElementById("allButtonID").style.display = "none";
			document.getElementById("btnReport").style.display = "none";
			document.getElementById("btnUpload").style.display = "none";
			document.getElementById("btnUploadMaster").style.display = "none";
			document.getElementById("btnUploadHealth").style.display = "none";
		}
		else{
			document.getElementById("category").style.display = "block";

			document.getElementById("brandsButtonID").style.display = "inline-block";
			document.getElementById("vendorsButtonID").style.display = "inline-block";
			document.getElementById("allButtonID").style.display = "inline-block";
			document.getElementById("btnReport").style.display = "inline-block";
			document.getElementById("btnUpload").style.display = "inline-block";
			document.getElementById("btnUploadMaster").style.display = "inline-block";
			document.getElementById("btnUploadHealth").style.display = "inline-block";
		}
	}

	$(document).ready(function(){
		$('.btn-outline-secondary').click(function () {
			$('.btn-outline-secondary.active').removeClass("active");
			$(this).addClass("active");
		})
	});
</script>

</head>

<?php

	if(isset($_POST["signin"])) {

	        include('connection.php');

	        $user = $_POST["username"];
	        $pwd = $_POST["password"];


	        $sql = "SELECT *
	            FROM  accounts
	            WHERE username = '$user' AND password = '$pwd'
	            ";
	        $result = $conn->query($sql);

	        if ($result->num_rows > 0){
	        	echo '
				<body style="background: white; height: 100%;" onload="load()">
					<div class = "wrapper">
						<div class = "static">
							<div class = "header">
					<table style="background: white; width: 100%" border="0" >

						<tr>
							<td style="font-size: 30px; height: 50px; padding: 20px; width: 100%" colspan="9">
								<form action="index.php" method="post">
									<input type="image" src="images/logo.png" alt="Submit Form" style="height: 70px; width: 85px"/>
								</form>
							</td>

						</tr>

						<tr height="50px">
							<td style="background: white; color: black; padding-right: 30px; width: 8%">
								<span style="background: transparent; color: #383838;" id="category">CATEGORY</span>
							</td>
							<td style="width: 2%; text-align: left; padding-left: 13px" >
								<a href="http://osomniserver/toolsforyou/masterfile-project/brands.php" target="show">
									<button id="brandsButtonID" type="button" class="btn btn-outline-secondary"> Brands </button>
								</a>
							</td>
							<td style="width: 2%">
								<a href="http://osomniserver/toolsforyou/masterfile-project/vendors.php" target="show">
									<button id="vendorsButtonID" type="button" class="btn btn-outline-secondary"> Vendors </button>
								</a>
							</td>
							<td style="width: 2%">
								<a href="http://osomniserver/toolsforyou/masterfile-project/all.php" target="show">
									<button id="allButtonID" type="button" class="btn btn-outline-secondary"> All </button>
								</a>
							</td>
							<td style="width: 30%"> </td>
							<td style="width: 2%">
								<a href="reports.php" target="show">
									<button type="button" class="btn btn-outline-secondary" onclick="disableMain("hide")" id="btnReport">Report</button>
								</a>
							</td>
				';

				while($row = $result->fetch_assoc()) {
					if($row["type"] == 1){
						echo '
							<td style="width: 2%">
								<a href="upload_master.php" target="show">
									<button type="button" class="btn btn-outline-secondary" id="btnUploadMaster">Upload Masterfile</button>
								</a>
							</td>
							<td style="width: 2%">
								<a href="upload.php" target="show">
									<button type="button" class="btn btn-outline-secondary" id="btnUpload">Upload MFI</button>
								</a>
							</td>
							<td style="padding-right: 1%; width: 2%">
								<a href="upload_health.php" target="show">
									<button type="button" class="btn btn-outline-secondary" id="btnUploadHealth">Upload Health</button>
								</a>
							</td>
						';
					}
				}

				echo '
					</tr>
					</table>
						</div>
					</div>
				</div>
				</br>
				</br>
				</br>
				</br>
				</br>
				</br>
				</br>
					<div id="container1">
						<iframe src="welcome.html" name="show" id="show" frameborder="0"></iframe>
					</div>
				</body>
				';
	        }

	        else {
	        	echo "
		        <script type=\"text/javascript\">
		        	alert(\"Wrong username or password. Please try again.\");
		        	window.location = \"index.php\"
		        </script>
		        ";
	        }
	  }

?>

</html>
