<?php
session_start();
require('PHP/functionlist.php');

if(!isset($_GET['mid']) or empty($_GET['mid'])) {
	header('Location: betmain.php');
	exit();
} else {
	$match_ID = $_GET['mid'];
}

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);

$Match = new MatchInfo($match_ID);
$input1 = $Match->getInput1();
$input2 = $Match->getInput2();
$event = $Match->getEvent();
$description = $Match->getDescription();
$img1 = $Match->getImg1();
$img2 = $Match->getImg2();

if(array_key_exists('submit',$_POST)) {
	$betamount = $_POST['betamount'];
	$private = isset($_POST['private']) ? 1 : 0;
	if(isset($_POST['winner'])) {
		$user1choice = $_POST['winner'];
		if( !(($user1choice === $input1) || ($user1choice === $input2)) ) {
		//cheating prevention: if choice submitted isn't a real choice (radio value is editable with stuff like chrome's element inspector)
		$errmsg = "Stop that!";
		}
	} else {
		$errmsg = "You didn't pick a choice to win";
	}
	if((!preg_match('/^\d+$/', $betamount)) || empty($betamount)) {
		$errmsg = "Bet amount entered is not an integer or is empty.";
	}
	if(!isset($_SESSION['loggedin'])) {
		$errmsg = "You need to be <a href='signinpage.php'>logged in</a> to do that.";
	} else {
		$username = $_SESSION['name'];
		$totalpoints = getpoints($username);
		if($betamount > $totalpoints) {
			$errmsg = "You're too poor to do that.";
		}
		if($username === $Match->getMod() || ($IP = $Match->getModIP() && !$IPBYPASS)) {
			$errmsg = "You are the moderator ya cunt!";
		}
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

#createbet
{
width:410px;
margin:40px auto;
text-align:right;
}

#slip_container
{
/* Fallback */
background:#090b75 url('IS/slip_bg.gif') repeat-x;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#090b75), to(#1b47e4));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #1b47e4, #090b75);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #1b47e4, #090b75);
/* IE 10 */
	background: -ms-linear-gradient(top, #1b47e4, #090b75);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #1b47e4, #090b75);
min-height:570px;
border-radius:5px;
border-top:1px solid #6d93f6;
font-family: 'Helvetica', sans-serif;
text-align:left;
}

.slip_title
{
height:75px;
line-height:75px;
text-align:center;
font-size:30px;
font-weight:bold;
text-shadow: 0px 3px 2px rgba(0, 0, 0, .5);
}

.slip_editbox
{
width:355px;
min-height:388px;
margin:0px auto;
/* Fallback */
background:#aeb1fb url('IS/slip_white.gif') repeat-x;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#aeb1fb), to(#fff));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #fff, #aeb1fb);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #fff, #aeb1fb);
/* IE 10 */
	background: -ms-linear-gradient(top, #fff, #aeb1fb);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #fff, #aeb1fb);
border-radius:5px;
border-bottom:1px solid #675bff;
}

.slip_top
{
border-top-left-radius:5px;
border-top-right-radius:5px;
}

.slip_head
{
/* Fallback */
background:#2528cf url('IS/slip_head.gif') repeat-x;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#4756d0), to(#83aae6));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #83aae6, #4756d0);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #83aae6, #4756d0);
/* IE 10 */
	background: -ms-linear-gradient(top, #83aae6, #4756d0);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #83aae6, #4756d0);
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

.slip_white
{
padding:10px;
color:#100875;
font-weight:bold;
}

.slip_event
{
min-height:8px;
}

.slip_info
{
min-height:68px;
}

.slip_mod
{
text-align:right;
font-weight:bold;
}

#choice_container
{
margin:10px auto;
}

.slip_choice
{
/* Fallback */
background:#3d4fcd url('IS/choice_bg.gif') repeat-x;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#3d4fcd), to(#7daaed));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #7daaed, #3d4fcd);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #7daaed, #3d4fcd);
/* IE 10 */
	background: -ms-linear-gradient(top, #7daaed, #3d4fcd);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #7daaed, #3d4fcd);
text-align:center;
min-height:75px;
width:300px;
margin:5px auto;
-webkit-box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
-moz-box-shadow:    0px 5px 5px rgba(0, 0, 0, 0.2);
box-shadow:         0px 5px 5px rgba(0, 0, 0, 0.2);
border-top:1px solid #aecffc;
border-bottom:1px solid #262acb;
}

.slip_choice p
{
font-size:25px;
font-weight:bold;
display:table-cell;
vertical-align: middle;
text-align:center;
height:75px;
width:160px;
overflow:hidden;
}

.slip_choice img
{
width:68px;
height:75px;
float:left;
}

.slip_radiocontainer {
	margin:10px 10px 10px 0px;
	width: 58px;
	height:58px;
	border:0px;
	float: right;
}

input[type="radio"] {
	display:none;
}

input[type="radio"] + label span {
	vertical-align: middle;
	display:inline-block;
	width: 58px;
	height: 58px;
	background: white url(IS/radio-sheet.gif) -58px top no-repeat;
	cursor: pointer;
}

input[type="radio"]:checked + label span {
	background: white url(IS/radio-sheet.gif) 0px top no-repeat;
}

.slip_valuecontainer
{
width:355px;
margin:20px auto;
}

.slip_valuecontainer img
{
float:left;
}

.slip_valuecontainer input
{
float:right;
margin:4px;
border:2px solid #5e7add;
height:29px;
width:128px;
/* Fallback */
background:url('IS/slip_white.gif') repeat-x 50px;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#aeb1fb), to(#fff));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #fff, #aeb1fb);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #fff, #aeb1fb);
/* IE 10 */
	background: -ms-linear-gradient(top, #fff, #aeb1fb);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #fff, #aeb1fb);
color:#0d0c81;
font-size:25px;
font-weight:bold;
line-height:25px;
text-align:center;
}

.slip_private
{
margin:auto;
padding-bottom:20px;
clear:left;
width:355px;
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
	echo "<div class='error'>" . $errmsg . "</div>";
}
?>
<form id='createbet' action='<?php echo $_SERVER['PHP_SELF'] ."?mid=". $match_ID; ?>' method='POST' 
onsubmit="return confirm('You are betting ' + $('input[name=betamount]', '#createbet').val() + ' FV Bux on ' + $('input[name=winner]:checked', '#createbet').val() + '.\nIs this correct?')">

<div id='slip_container'>
	<div class='slip_title'>SPAGHETTI SHOWDOWN</div>
	<div class='slip_editbox'>
		
		<div class='slip_head slip_top'>Event</div>
		<div class='slip_white slip_event'>
		<?php echo $event; ?>
		</div>
		
		<div class='slip_head'>Information</div>
		<div class='slip_white slip_info'>
		<?php echo nl2br($description); ?>
		<br><br><div class='slip_mod'>Moderator: <a href='players.php?user=<?php echo $Match->getMod(); ?>'><?php echo $Match->getMod(); ?></a></div>
		</div>
		
		<div class='slip_head'>Choose Winner</div>
		
		<div id='choice_container'>
		<div class='slip_choice'>
		<?php if(!empty($img1)){echo "<img src='". $img1 ."' alt='". $input1 ."'/>";} ?>
			<div class='slip_radiocontainer'><input type='radio' id='r1' name='winner' value='<?php echo $input1; ?>'/>
			<label for='r1'><span></span></label>
			</div>
			<p><?php echo $input1 ?></p>
		</div>
		<div></div>
		<div class='slip_choice'>
		<?php if(!empty($img2)){echo "<img src='". $img2 ."' alt='". $input2 ."'/>";} ?>
			<div class='slip_radiocontainer'><input type='radio' id='r2' name='winner' value='<?php echo $input2; ?>'/>
			<label for='r2'><span></span></label>
			</div>
			<p><?php echo $input2 ?></p>
		</div>
		</div>
	</div>		
	<div class='slip_valuecontainer'><img src='IS/slip_amount.png' alt='Bet Amount'/><input type='text' name='betamount' />
	</div>
	<div class='slip_private'>Private? <input type='checkbox' name='private'>
	<br>(Your bet will be unlisted but it may still be challenged by anyone)</div>		
</div>
<input type='image' src='IS/submit.png' name='submit' alt='Submit' />
</form>	

</body>
</html>