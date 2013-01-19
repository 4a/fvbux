<?php
session_start();
require('PHP/functionlist.php');

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
/* $IPBYPASS is used to get around the ip check so you are able to test bet creation locally */
$IPBYPASS = TRUE;

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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
body
{
  text-align:center;
}  
#user
{
  display:block;
  position:absolute;
  top:15px;
  right:30px;
}

#user-menu
{
float:left;
display:inline-block;
margin-right: 10px;
text-align:right;
}

#user-avatar
{
display:block;
float:right;
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

/* User is logged in */
if(isset($_SESSION['loggedin'])) {
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
					$stmt = $mysqli->prepare("SELECT `winner`, `value` FROM `bets_money` WHERE (`match`=?) ORDER BY value DESC");
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
		This is the submission form for creating and moderating a match-up.
		<br>As the moderator, you cannot bet on an outcome.
		<br>You will have the opportunity to earn fvbux based on the amount of people who have participated in your match-up.
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<input type='text' name='input1'>
		<br>VS<br>
		<input type='text' name='input2'><br>
		<input type='submit' name='submit' value='Submit' />";
	}

}

/* User is not signed in */
else {
	echo "<a href='signuppage.php'>Register</a><br/>";
	echo "<a href='signinpage.php'>Log In</a>";
}


?>

</body>
</html>
