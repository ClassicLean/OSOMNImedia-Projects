<!DOCTYPE HTML>
<html>
<head>

<style type="text/css">

	body {
		background-color: #f1f1f1;		
		padding: 5px 50px 50px 30px;
	}

	p {		
		font: 20px 'Work Sans', sans-serif;
		color: black;
    	display: inline;
	}

	.btn {
		background: transparent;
		border: 0;
		border-radius: 10px;
		color: #a09d9a;
		font-family: 'Work Sans', sans-serif;
		font-size: 16px;
		width: 8%;
	}

	.btn:hover {
		background: #007bff;
		color: white;
		text-decoration: none;
	}

	.center-div {
        margin: 10% auto 0 auto;
        text-align: center;
        width: 50%;
    }

</style>

<!-- Bootstrap -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- EXTERNAL CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

</head>
<body>

	<div class="center-div">
		<p> Select report </p>
		<hr>

		<br><br>
		
		<form method="post" action="report_fba.php">
			<button type="submit" id="out" name="report_fba" class="btn" style="width: 250px">Total FBA Value</button>
           <!--
           <input type="submit" name="report_fba" class="btn" value="Total FBA Value" />                
       		-->
        </form>

        <br><br>

        <form method="post" action="report_tsku.php">
            <input type="submit" name="report_tsku" class="btn" value="Potential Trouble SKUs" style="width: 250px"/>                
        </form>
	</div>

</body>
</html>