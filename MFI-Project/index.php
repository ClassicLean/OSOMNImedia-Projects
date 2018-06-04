<!DOCTYPE HTML>
<html>
<head>
<title>Masterfile Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

<style type="text/css">

	#mainDIV {			
		background: white;
		border: 1px #d9d9d9 solid;
		box-shadow: 0px 0px 2px 2px #e5e5e5;		
		font-family: 'Work Sans', sans-serif;	
		height: 300px;
		left: 50%;
		margin: -180px 0 0 -150px;	
		padding: 10px;
		position: fixed;
		text-align: center;
		top: 50%;		
		width: 300px;
		z-index: 15;
	}	

	form {
		margin: 5px auto 0 auto;	
		margin-top: 5px;	
		width: 90%;	
	}

	p {
		color: black;		
		font-size: 14px;
	}

	table {		
		font-family: 'Work Sans', sans-serif;
		font-size: 14px;
		width: 100%;
	}

	#eye {
		float: right;
		height: 30px;
		margin-top: 30px;
		width: 30px;
	}

	#labelPassword {
		font-style: italic;
		font-size: 10px;
		float: left;
	}

	#logo {
		height: 50px;
		margin-top: 20px;
		width: 62px;
		margin-bottom: 20px;
	}

	#password {
		font-size: 14px;
		margin-top: 25px;
		width: 85%;
		float: left;
	}

	#submit {
		background: #00bb9a;		
		border: 0;
		color: white;
		font-size: 12px;
		height: 35px;
		margin-top: 30px;
		text-align: center;	
		width: 100%;
	}

	#username {		
		font-size: 14px;
	}

	.labelLeft {
		float: left;
	}


</style>

<script>
	function showPassword() {
	    var x = document.getElementById("password");
	    if (x.type === "password") {
	        x.type = "text";
	    } else {
	        x.type = "password";
	    }
	    if(x.value == "password"){
			x.value = "";
		}
	}
</script>

</head>

<body style="background: #eeeeee; height: 100%" onload="load()">

    <div id="mainDIV">                     
        <div class="tab-content">

            <div id="login" class="tab-pane fade active show">

		        <img src="images/logo.png" id="logo">

		        <form action="main.php" method="post">					
					<input type="text" class="form-control" id="username" name="username" value="Username" onfocus="if(this.value == 'Username') {this.value=''}" onblur="if(this.value == ''){this.value ='Username'}">

					<input type="password" class="form-control" id="password" name="password" value="Password" onfocus="if(this.value == 'Password') {this.value=''}" onblur="if(this.value == ''){this.value ='Password'}" maxlength="25" minlength="1">
					<img src="images/eye.png" id="eye" onclick="showPassword()">

					<button type="submit" id="submit" name="signin" class="btn">Sign In</button>					
				</form>  

            </div>

        </div>
    </div>
</body>
</html>