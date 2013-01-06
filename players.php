<?php
session_start();
require('PHP/functionlist.php');
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
#user
{
  display:block;
  position:fixed;
  top:15px;
  right:30px;
}
#fvbux
{
  display:block;
  text-align:center;
}
#create
{
  text-align:center;
}
</style>
</head>
<body>
<?php
include 'menu.php';
?>
<?php
$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
if(isset($_SESSION['loggedin'])) {
//        updatePoints(1, $_SESSION['name']);
	include 'user.php';
	echo "
        <div id='fvbux'>You have <br>
        $totalpoints
        <br>FVBux</div>
        <div id='create'><a href='bets.php'>Create new match</a></div>
        ";
} else {
	echo "<a href='signuppage.php'>Register</a><br/>";
	echo "<a href='signinpage.php'>Log In</a>";
}
?>




</body>
</html>