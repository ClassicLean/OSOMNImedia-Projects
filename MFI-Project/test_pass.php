<html>
<head>
<title>Pass JS array to PHP.</title>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

</head>

<body>
 	
	<script type="text/javascript">
	function convert(){
		var JSarray =["a","b","c"];
		var string=document.getElementById("string1");
		NEWstring=JSarray.toString();
		string.value=NEWstring;
	}
	</script>
	<form method="post">
		<input name="string1" id="string1" type="hidden" value="aaa"/>
		<input onclick="convert();" name="BTN" type="submit" value="convert from JS to PHP"/>
	</form>
	
	<?php
		if(isset($_POST['BTN'])) {
			$PHParray=explode(',',$_POST['string1']);
			print_r($PHParray);
		}
	?>
	
</body>
</html>