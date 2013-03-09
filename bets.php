<?php
session_start();
require('PHP/functionlist.php');

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);

if(array_key_exists('submit',$_POST)) {
	$featured = isset($_POST['featured']) ? 'yes' : 'no';
	$img1 = "";
	$img2 = "";
	$description = $_POST['description'];
    if(!empty($_POST['input1'])) {
		$submitinput1 = $_POST['input1'];
	} else {
		$errmsg = "You didn't fill in the first betting choice.";
	}
    if(!empty($_POST['input2'])) {
		$submitinput2 = $_POST['input2'];
	} else {
		$errmsg = "You didn't fill in the second betting choice.";
	}
	if(empty($_POST['input1']) && empty($_POST['input2'])) {
		$errmsg = "You didn't submit any choices to bet on.";
	}
	if(!empty($_POST['event'])) {
		$event = $_POST['event'];
	} else {
		$errmsg = "You didn't fill in the event name.";
	}
	if(isset($_POST['featured'])){
		if(!preg_match("/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|gif|png)$/i", $_POST['img1'])
		|| !preg_match("/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|gif|png)$/i", $_POST['img2'])) {
			$errmsg = "Invalid image url submitted.";
		}
		if(empty($_POST['img1']) || empty($_POST['img2'])) {
			$errmsg = "Featured matches require images of each choice.";
		}
	$img1 = $_POST['img1'];	
	$img2 = $_POST['img2'];
	}
	if(!isset($_SESSION['loggedin'])) {
		$errmsg = "You need to be <a href='signinpage.php'>logged in</a> to do that.";
	}
	if(!isset($errmsg)) {
	$newMID = createMatch($submitinput1, $submitinput2, $_SESSION['name'], $IP, $event, $description, $featured, $img1, $img2);
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

#form_head
{
background:url('IS/form_head.gif') repeat-x;
height:23px;
width:100%;
border-top-left-radius:5px;
border-top-right-radius:5px;
border-top:#9c8fd5 1px solid;
}

#form_mCreate
{
background:#070419 url('IS/form_BG.gif') repeat-x 0px 0px;
border-bottom:#2700fc 1px solid;
border-radius:5px;
width:660px;
margin:40px auto;
}

#form_mCreate input, textarea
{
color:#fff;
font-weight:bold;
font-family:arial;
background:black;
border:0px;
border-radius:5px;
text-align:center
}

.form_text
{
margin:10px;
}

.form_box
{
width:155px;
height:22px;
}

.form_event
{
margin:5px auto auto auto;
width:245px;
height:32px;
font-size:20px;
}

.form_description
{
margin:5px auto 15px auto;
max-width:225px;
min-width:225px;
min-height:70px;
text-align:left;
padding:5px 10px;
}

.form_submit
{
margin:20px auto 40px auto;
}

.form_box:focus, .form_event:focus, .form_description:focus
{
outline: #2700fc auto;
}

::-webkit-input-placeholder { /* WebKit browsers */
    color:    #5f5f5f;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #5f5f5f;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #5f5f5f;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    color:    #5f5f5f;
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
	if(isset($_GET['mid']) and !empty($_GET['mid']) and ctype_digit($_GET['mid'])) {
		$match_ID = $_GET['mid'];
		$match_ID = $mysqli->real_escape_string($match_ID);
		$Match = new MatchInfo($match_ID);
		$matchid = $Match->getMatchID();
		$input1 = $Match->getInput1();
		$input2 = $Match->getInput2();
		$mod = $Match->getMod();
		$modip = $Match->getModIP();
		$matchstatus = $Match->getStatus();
		$matchwinner = $Match->getWinner();
		if ($matchwinner === $input1) {
			$matchloser = $input2;
		}
		else {
			$matchloser = $input1;
		}

/* Match ID in mid parameter exists */
		if($matchid == $match_ID) {

/* Match status is open */
			if ($matchstatus === "open") {

/* Moderator Options - Winner selection and bet freezing */
				if ($_SESSION['name'] === $mod) {
					echo "<h1>" . $input1 . "</h1>
                                        <form action='declarewinner.php' method='POST'>
					<input type='hidden' name='matchid' value='" . $match_ID . "'>
					<input type='hidden' name='winner' value='" . $input1 . "'>
                                        <input type='image' src='IS/tick.png' name='submit'>
					</form>";
					echo "<h4>VS</h4>";
					echo "<h1>" . $input2 . "</h1>
					<form action='declarewinner.php' method='POST'>
					<input type='hidden' name='matchid' value='" . $match_ID . "'>
					<input type='hidden' name='winner' value='" . $input2 . "'>
					<input type='image' src='IS/tick.png' name='submit'>
					</form>";
					echo "You are the moderator";
					echo "<br>Betting status: Open";
				}

/* Cheating Prevention - Moderator tried to bet with a different account */
				else if ($IP == $modip and !$IPBYPASS) {
					echo "<h1>" . $input1 . "</h1>";
					echo "<h4>VS</h4>";
					echo "<h1>" . $input2 . "</h1>";
				        echo "<div style='color:red'>You have the same IP as the moderator</div>";
				}

/* Normal User Page - Select from list of bets or create a new one */
				else {
					echo "<h1>" . $input1 . "</h1>";
					echo "<h4>VS</h4>";
					echo "<h1>" . $input2 . "</h1>";
					echo "Moderator: <a href='players.php?user=" . $mod . "'>" . $mod . "</a>";
	
				/* Begin list of open bets */
					echo "<br><br><div id='open_bets'>Open Bets:<br>";
					$stmt = $mysqli->prepare("SELECT `ID`, `username 1`, `value`, `user1choice` FROM `bets_money` WHERE (`match`=? AND `status`='open' AND `private`=0) ");
					$stmt->bind_param("s", $match_ID);
					$stmt->execute();
					$stmt->bind_result($betNo, $user1name, $betvalue, $user1choice);
					$i = 1;
					while ($stmt->fetch()) {
						echo $i++ .". <a href='playerbet.php?bid=". $betNo ."'> ". $betvalue ." FVBux on ". $user1choice ."</a>
						[<a href='players.php?user=". $user1name ."'>". $user1name ."</a>]<br>";
					}
					echo "</div>";
				/* End list of open bets */

					echo "<br />Select a bet from the list or"
					."<br /><a href='createbet.php?mid=$match_ID'><img src='IS/createbet.jpg'></a>";
				}
			}

/* Match status is locked */
			else if ($matchstatus === "locked") {

/* Moderator Options - Winner selection and bet freezing */
				if ($_SESSION['name'] === $mod) {
					echo "<h1>" . $input1 . "</h1>
     <form action='declarewinner.php' method='POST'>
					<input type='hidden' name='matchid' value='" . $match_ID . "'>
					<input type='hidden' name='winner' value='" . $input1 . "'>
     <input type='image' src='IS/tick.png' name='submit'>
					</form>";
					echo "<h4>VS</h4>";
					echo "<h1>" . $input2 . "</h1>
					<form action='declarewinner.php' method='POST'>
					<input type='hidden' name='matchid' value='" . $match_ID . "'>
					<input type='hidden' name='winner' value='" . $input2 . "'>
					<input type='image' src='IS/tick.png' name='submit'>
					</form>";
					echo "You are the moderator";
					echo "<br>Betting status: Locked";
				}
/* Normal User Page - Betting is locked, winner not decided yet */
				else {
                                        echo "<h1>" . $input1 . "</h1>";
					echo "<h4>VS</h4>";
					echo "<h1>" . $input2 . "</h1>";
					echo "Betting on this match is locked.";
                                        echo "<br><a href='players.php?user=" . $mod . "'>" . $mod . "</a> has not updated this match-up with a winner yet.";
                                        echo "<br>Betting may be unlocked at a later time.";
				}
			}


/* Match status is closed */
			else {
				echo "This match has ended.
				<h1>" . $matchwinner . "</h1>";
				echo "<h4>Defeated</h4>";
				echo "<h1>" . $matchloser . "</h1>";
				/* Begin list of winners */
					echo "<br><br><div id='open_bets'>Winners:<br>";
					$stmt = $mysqli->prepare("SELECT `winner`, `value` FROM `bets_money` WHERE `match`=? AND NOT `username 2`='' ORDER BY value DESC");
					$stmt->bind_param("s", $match_ID);
					$stmt->execute();
					$stmt->bind_result($winner, $winnings);
					$i = 1;
					while ($stmt->fetch()) {
						echo $i++ .". <a href='players.php?user=". $winner ."'>". $winner ."</a> won ". $winnings ." FVBux!<br>";
					}
					echo "</div>";
				/* End list of winners */
			}
		}

/* Match ID (mid) is invalid */
		else {
			echo "Error: Match does not exist in database.<br>
			<form action='$_SERVER[PHP_SELF]' method='post'>
			<input type='text' name='input1'>
			<br>VS<br>
			<input type='text' name='input2'><br />
			<input type='submit' name='submit' value='Submit' />";
		}
	}

/* Moderate and Create Match Form - No match ID (mid) is set */
	else {
		echo "
		<div id='form_mCreate'>
		<div id='form_head'></div>
		<div class='form_text'>
		This is the submission form for creating and moderating a matchup.
		<br>As a moderator, you cannot bet on an outcome.
		<br>You will have the opportunity to earn fvbux based on the amount of people who have participated in your matchup.
		</div>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		
		<div>
		<input class='form_event' type='text' name='event' placeholder='EVENT TITLE' autocomplete='off'><br>
		<textarea class='form_description' wrap='physical' name='description' placeholder='Description' autocomplete='off'></textarea><br>
		</div>
		
		<div>
		<input class='form_box' style='position:relative;bottom:30px;right:15px' type='text' name='input1' placeholder='SCRUBLORD 1' autocomplete='off'>
		<img src='IS/VS2.png' alt='VS'/>
		<input class='form_box' style='position:relative;bottom:30px;left:15px' type='text' name='input2' placeholder='SCRUBLORD 2' autocomplete='off'><br>
		</div>
		
		<div style='font-size:15px'>
		<input class='form_box' style='position:relative;right:15px' type='text' name='img1' placeholder='Paste Image URL Here' autocomplete='off'>
		Featured?<input class='featured' type='checkbox' name='featured' title='Your matchup will be featured on the front page. Two images are required for featured matches.'>
		<input class='form_box' style='position:relative;left:15px' type='text' name='img2' placeholder='Paste Image URL Here' autocomplete='off'><br>
		</div>

		<input class='form_submit' type='image' src='IS/submit.png' name='submit' value='Submit'/>
		</div>";
	}

?>

</body>
</html>
