<?php
session_start();
require('PHP/functionlist.php');
include 'user.php';
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
#main
{
  display:block;
  text-align:center;
}
</style>
</head>
<body>
<?php
include 'menu.php';
?>
<div id="main">
<?php
/*-------------------------------------if user parameter is set--------------------------------------*/
if(isset($_GET['user'])) {
        $username = $_GET['user'];
        $username = $mysqli->real_escape_string($username); 
        $result = $mysqli->query("SELECT * FROM user WHERE username='$username'");
        $row = $result->fetch_array(MYSQLI_ASSOC);             
        if($row['username'] === $username) {
	     $proGravatar = new TalkPHP_Gravatar();
	     $proGravatar->setEmail($row['email']);
	     $proGravatar->setSize(80);
	     $progravurl = $proGravatar->getAvatar();
	     echo "<img src='". $progravurl ."' alt='Gravatar' /> this is ". $username ."'s profile";
	     if($_SESSION['name'] === $row['username']) {
	     echo "and you are ". $username;}
        } else {
             echo "Error: User does not exist.";
        } 
} else {
/*-------------------------------------main page, what it should do with no profile parameter--------------------------------------*/

/*-------------------------------------check if logged in--------------------------------------*/
if(isset($_SESSION['loggedin'])) {
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
}
/*-------------------------------------end of session stuff--------------------------------------*/

//VV this stuff should probably be includes VV

/*-------------------------------------leaderboard--------------------------------------*/
echo "<div><div id='leaderboard' style='display:inline-block;background-color:black'>leaedr board<br>";

	if(!($stmt = $mysqli->prepare("SELECT username, points FROM user ORDER BY points DESC LIMIT 10"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$stmt->bind_result($leadname, $leadpoints);
	$i = 1; 
	while ($stmt->fetch()) {
        echo $i++ .". <a href='players.php?user=". $leadname ."'>". $leadname ."</a> (". $leadpoints .")<br>";
    }
    
/*-------------------------------------end leaderboard--------------------------------------*/

/*-------------------------------------list of matches--------------------------------------*/
    
echo "</div>

<div id='matches' style='display:inline-block;background-color:black'>stuff to bet on | <a href='bets.php'>Create new match</a><br>";

	if(!($stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod` FROM `bets_matches` ORDER BY `ID` DESC LIMIT 50"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$stmt->bind_result($matchNo, $name1, $name2, $mod);
	$i = 1; 
	while ($stmt->fetch()) {
        echo $i++ .". <a href='bets.php?mid=". $matchNo ."'> ". $name1 ." VS. ". $name2 ."</a> [Moderator: ". $mod ."]<br>";
    }

echo "</div></div>";
?>
</div>
</body>
</html>
