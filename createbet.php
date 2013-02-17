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
<link rel="stylesheet" type="text/css" href="CSS/tempstyles.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
.bettingslip
{
	margin-top:40px;
	margin-bottom:150px;
	font-family: Tahoma, Geneva, sans-serif;
	text-shadow: 0 0 1px rgba(0,0,0,0.3);
}  

.editbox
{
	text-align:left;
	position:relative;
	width:440px;
	margin:auto;
	background:#1a4ae0;
	border:0px solid #fff;
	padding:37px;
	padding-top:0px;
	padding-bottom: 10px;
	box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

.slipTitle
{
color:white;
font-size:6em;
text-align:center;
min-height:100px;
padding:20px 0px 20px 0px;
}

input[type="radio"] {
	display:none;
}

input[type="radio"] + label span {
	vertical-align: middle;
	display:inline-block;
	width: 70px;
	height: 55px;
	background: url(IS/radio-sheet.png) -50px top no-repeat;
	cursor: pointer;
}

input[type="radio"]:checked + label span {
	background: url(IS/radio-sheet.png) left top no-repeat;
}

.slipColumn {
	height: 50px;
	background: #7dacec;
}

.slipColumn .playerName {
	text-align: center;
	height: 100%;
	color: #0c69ce;
	font-size: 2.1em;
	line-height:50px;
	overflow: hidden;
}

.slipHeader {
	text-align: center;
	height: 100%;
	color: #000;
	font-size: 2.8em;
	line-height:50px;
	overflow: hidden;
}

.slipColumn .radioContainer {
	min-width: 70px;
	width: 70px;
	height:46px;
	border:2px #7dacec solid;
	float: right;
	background-color: white;
}

.valueContainer {
	height: 40px;
	margin-top: 20px;
	margin-bottom: 20px;
}

.valueContainer .valueName {
	text-align: left;
	height: 100%;
	font-size: 2.2em;
	font-style: bold;
	padding-left: 25px;
	line-height: 40px;
}

.valueContainer .valueInput {
	float: right;
	height: 100%;
	font-size: 2.2em;
	font-style: bold;
	line-height: 45px;
}
.valueInput input {
	top:-3px;
	height:30px;
	width:200px;
	font-size:20px;
	line-height:20px;
	text-align:right;
	position:relative;
	border: 2px #7dacec solid;
}
.private
{
display:inline-block;
width:100px;
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

if($Match->getMod() != $_SESSION['name'] && $IP != $Match->getModIP() || $IPBYPASS) {
	echo "
<div class='bettingslip'>
	<div class='editbox'>
		<div class='slipTitle'>
		FV Title Here
		</div>
		<div class='slipColumn'>
			<div class='slipHeader'>Event</div>
		</div>
		<div style='background:white;color:black;min-height:55px'>
		Evolution
		</div>
		<div class='slipColumn'>
			<div class='slipHeader'>Information</div>
		</div>
		<div style='background:white;color:black;min-height:240px'>
		Grand Finals<br>
		3/5 set<br/>
		Moderator: ". $Match->getMod() ."
		</div>
		<div class='slipColumn'>
			<div class='slipHeader'>Choose Winner</div>
		</div>
		<div style='background:white;height:15px'></div>
		<form action='$_SERVER[PHP_SELF]?mid=".$match_ID."' method='POST'>
		<div class='slipColumn'>
			<div class='radioContainer'><input type='radio' id='r1' name='winner' value='".$input1."'/>
			<label for='r1'><span></span></label></div>
			<div class='playerName'>".$input1."</div>
		</div>
		<div style='background:white;height:3px'></div>
		<div class='slipColumn'>
			<div class='radioContainer'><input type='radio' id='r2' name='winner' value='".$input2."'/>
			<label for='r2'><span></span></label></div>
			<div class='playerName'>".$input2."</div>
		</div>	
		<div class='valueContainer'>
			<div class='valueInput'><span class='fvbux'>$ </span><input type='text' name='betamount' /></div>
			<div class='valueName'>Bet Amount</div>
		</div>
		Private? <input type='checkbox' name='private'><br/>
		(Note: Private only means that your bet wont show publicly on the website.)<br />
	</div>
			<input type='submit' name='submit'>
	</form>
</div>
    ";
} else {
	echo "<br /> <br />You are the moderator ya cunt";
}
?>
</body>
</head>
</html>