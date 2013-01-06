<?php
session_start();
require('PHP/functionlist.php');
if(!isset($_SESSION['loggedin'])) {
	header('Location: signinpage.php');
}

if(!isset($_GET['mid']) or empty($_GET['mid'])) {
	header('Location: players.php');
	exit();
} else {
	$match_ID = $_GET['mid'];
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
body
{
  text-align:center;
}

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
$Match = new MatchInfo($match_ID);
$input1 = $Match->getInput1();
$input2 = $Match->getInput2();
echo "<h1>" . $input1 . "</h1>";
echo "<h4>VS</h4>";
echo "<h1>" . $input2 . "</h1>";
echo "Moderator : " . $Match->getMod();

echo "
<br /><br ><br />
<form action='$_SERVER[PHP_SELF]' method='POST'>
Who to win: <input type='radio' name='winner' value='".$input1."'>".$input1."
&nbsp;<input type='radio' name='winner' value='".$input2."'>".$input2."<br />
Bet Amount: <input type='text' name='betamount'>
</form>";
?>

</body>
</html>