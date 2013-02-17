<?php
session_start();
require('PHP/functionlist.php');

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
/* $IPBYPASS is used to get around the ip check so you are able to test bet creation locally */
$IPBYPASS = FALSE;

if(isset($_SESSION['loggedin'])) {
	$totalpoints = getPoints($_SESSION['name']);
}
if(array_key_exists('submit',$_POST)) {
        if(!empty($_POST['input1'])) {
		$submitinput1 = $_POST['input1'];
	} else {
		$errmsg = "You didn't fill in the first box.";
	}
        if(!empty($_POST['input2'])) {
		$submitinput2 = $_POST['input2'];
	} else {
		$errmsg = "You didn't fill in the second box.";
	}
	if(empty($_POST['input1']) && empty($_POST['input2'])) {
		$errmsg = "You didn't even try to fill in a box.";
	}
	if(!isset($errmsg)) {
	$newMID = createMatch($submitinput1, $submitinput2, $_SESSION['name'], $IP);
	header('Location:bets.php?mid='.$newMID);}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<title>Fightan' /v/idya</title>
<link rel="shortcut icon" href="FV.ico" >
<link rel="stylesheet" type="text/css" href="CSS/newfightans.css">
<link rel="stylesheet" type="text/css" href="CSS/tempstyles.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
body
{
  text-align:center;
}  
</style>
</head>
<body>
<?php
include 'menu.php';
include 'user.php';
?>
This is the submission form for creating and moderating a match-up.
<br>As the moderator, you cannot bet on an outcome.
<br>You will have the opportunity to earn fvbux based on the amount of people who have participated in your match-up.
<form action='<?php echo $_SERVER['PHP_SELF'];?>' method='post'>
<input type='text' name='input1'>
<br>VS<br>
<input type='text' name='input2'><br>
<input type='submit' name='submit' value='Submit' />
</body>
</head>
</html>
