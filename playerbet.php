<?php
session_start();
require('PHP/functionlist.php');

if(isset($_GET['bid'])) {
	if(ctype_digit($_GET['bid'])) {
		$BetInfo = new BetInfo($_GET['bid']);
		
	}
	
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<title>Fightan' /v/idya</title>
<link rel="shortcut icon" href="FV.ico" >
<link rel="stylesheet" type="text/css" href="CSS/newfightans.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>

</style>
</head>

<body>

</body>
</html>
