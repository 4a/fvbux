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

/*
bet validation & creation
TODO:
1: check users bet amount and see if he has enough
2. create bet and take bet amount from users points (should be done in the createbet function?)
3. create a GET filled link that they can give to other people
*/

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
$IPBYPASS = TRUE;


/* Check if form has been submitted */
if(array_key_exists('submit',$_POST)) {
	$username = $_SESSION['name'];
	$totalpoints = getpoints($username);
	$betamount = $_POST['betamount'];
	$private = isset($_POST['private']) ? 1 : 0;
	if(isset($_POST['winner'])) {
		$user1choice = $_POST['winner'];
	} else {
		$errmsg = "You didn't pick a choice to win";
	}
	
	if((!preg_match('/^\d+$/', $betamount)) || empty($betamount)) {
		$errmsg = "Bet amount entered is not a numeric value or is empty";
	}
	
	if($betamount > $totalpoints) {
		$errmsg = "You're too poor to do that.";
	}

	if(!isset($errmsg)) {
		$betID = createBet($match_ID, $username, $betamount, $IP, $private, $user1choice);
		//create new page (new php page?) so the user can pass around the link and we can link to it publicly
		header('Location: playerbet.php?bid=' . $betID);
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
	include 'user.php';
?>

<?php
if(isset($errmsg)) {
	echo "<div style='color:red'>" . $errmsg . "</div>";
}
$Match = new MatchInfo($match_ID);
$input1 = $Match->getInput1();
$input2 = $Match->getInput2();
echo "<h1>" . $input1 . "</h1>";
echo "<h4>VS</h4>";
echo "<h1>" . $input2 . "</h1>";
echo "Moderator : " . $Match->getMod();

if($Match->getMod() != $_SESSION['name'] && $IP != $Match->getModIP() || $IPBYPASS) {
	echo "
	<br /><br ><br />
	<form action='$_SERVER[PHP_SELF]?mid=".$match_ID."' method='POST'>
	Who to win: <input type='radio' name='winner' value='".$input1."'>".$input1."
	&nbsp;<input type='radio' name='winner' value='".$input2."'>".$input2."<br />
	Bet Amount: <input type='text' name='betamount'><br />
	Private?: <input type='checkbox' name='private'><br/>
	<input type='submit' name='submit'>
	<br />
	(Note: Private only means that your bet wont show publicly on the website.)<br />
	</form>";
} else {
	echo "<br /> <br />You are the moderator ya cunt";
}
?>

</body>
</html>
