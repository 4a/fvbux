<?php
session_start();
if($_SESSION['level'] != 'admin') {
	header('Location: players.php');
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
<script type="text/javascript" src="JS/idtabs.js"></script>
<style>
</head>

<body>

<div id='changeuserpoints'>
<h4>Change User's Points</h4>
<form>
Username: <input type='text' name='username' />
Add/Minus: <input type='radio' name='addorminus' />&nbsp;<input type='radio' name='addorminus' />
Amount: <input type='text' name='amount' />
</form>	
</div>

</body>