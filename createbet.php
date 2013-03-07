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
background:#0c0c70 url('IS/slip_bg.gif') repeat-x;
width:410px;
min-height:570px;
margin:40px auto 100px;
border-radius:5px;
border-top:1px solid #6d93f6;
font-family: 'Helvetica', sans-serif;
}

.slipTitle
{
height:75px;
line-height:75px;
text-align:center;
font-size:30px;
font-weight:bold;
text-shadow: 0px 3px 2px rgba(0, 0, 0, .5);
}

.editbox
{
width:355px;
min-height:388px;
margin:0px auto;
background:#adb1fb url('IS/slip_white.gif') repeat-x;
border-radius:5px;
border-bottom:1px solid #675bff;
}

.tophead
{
border-top-left-radius:5px;
border-top-right-radius:5px;
}

.sliphead
{
background:#2528cf url('IS/slip_head.gif') repeat-x;
height:30px;
border-top:1px solid #a3d5f0;
border-bottom:1px solid #2528cf;
text-align:center;
font-size:25px;
font-weight:bold;
-webkit-box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
-moz-box-shadow:    0px 5px 5px rgba(0, 0, 0, 0.2);
box-shadow:         0px 5px 5px rgba(0, 0, 0, 0.2);
}

#choiceContainer
{
margin:10px auto;
}

.slipchoice
{
background:url('IS/choice_bg.gif') repeat-x;
font-size:30px;
font-weight:bold;
text-align:center;
height:75px;
line-height:75px;
width:300px;
margin:5px auto;
-webkit-box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
-moz-box-shadow:    0px 5px 5px rgba(0, 0, 0, 0.2);
box-shadow:         0px 5px 5px rgba(0, 0, 0, 0.2);
}

.slipchoice img
{
width:68px;
height:75px;
float:left;
}

.radioContainer {
	min-width: 70px;
	width: 55px;
	height:46px;
	border:0px;
	float: right;
}

input[type="radio"] {
	display:none;
}

input[type="radio"] + label span {
	vertical-align: middle;
	display:inline-block;
	width: 55px;
	height: 55px;
	background: white url(IS/radio-sheet.png) -50px top no-repeat;
	cursor: pointer;
}

input[type="radio"]:checked + label span {
	background: white url(IS/radio-sheet.png) left top no-repeat;
}

.valueContainer
{
margin:20px auto;
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
$event = $Match->getEvent();
$description = $Match->getDescription();
$img1 = $Match->getImg1();
$img2 = $Match->getImg2();

if($Match->getMod() != $_SESSION['name'] && $IP != $Match->getModIP() || $IPBYPASS) {
	echo "
<div class='bettingslip'>
<form id='createbet' action='$_SERVER[PHP_SELF]?mid=".$match_ID."' method='POST' 
onsubmit=\"return confirm('You are betting ' + $('input[name=betamount]', '#createbet').val() + ' FV Bux on ' + $('input[name=winner]:checked', '#createbet').val() + '. Is this correct?')\">

	<div class='slipTitle'>SPAGHETTI SHOWDOWN</div>
	<div class='editbox'>
		
		<div class='sliphead tophead'>Event</div>
		<div style='min-height:8px;padding:10px;color:#100875;font-weight:bold'>
		". $event ."
		</div>
		
		<div class='sliphead'>Information</div>
		<div style='min-height:68px;padding:10px;color:#100875;font-weight:bold'>
		". nl2br($description) ."
		<br><br><div style='text-align:right;font-weight:bold'>Moderator: ". $Match->getMod() ."</div>
		</div>
		
		<div class='sliphead'>Choose Winner</div>
		
		<div id='choiceContainer'>
		<div class='slipchoice'>";
		if(!empty($img1)){echo "<img src='". $img1 ."'/>";}
		echo "
			<div class='radioContainer'><input type='radio' id='r1' name='winner' value='".$input1."'/>
			<label for='r1'><span></span></label>
			</div>
			<div class='playerName'>".$input1."</div>
		</div>
		<div></div>
		<div class='slipchoice'>";
		if(!empty($img2)){echo "<img src='". $img2 ."'/>";}
		echo "
			<div class='radioContainer'><input type='radio' id='r2' name='winner' value='".$input2."'/>
			<label for='r2'><span></span></label>
			</div>
			<div class='playerName'>".$input2."</div>
		</div>
		</div>
	</div>		
	<div class='valueContainer'>Bet Amount<span class='fvbux'>$ </span><input type='text' name='betamount' /></div>
	
	Private? <input type='checkbox' name='private'><br/>
	(Note: Private only means that your bet wont show publicly on the website.)<br />		
</div>
<input type='image' src='IS/submit.png' name='submit' value='Submit' />
</form>	
    ";
} else {
	echo "<br /> <br />You are the moderator ya cunt";
}
?>
</body>
</head>
</html>