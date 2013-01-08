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
#mainbox
{
max-width:100%;
}
#user
{
  display:block;
  position:fixed;
  top:15px;
  right:30px;
}
#content-left
{
position:absolute;
top:0px;
left:0px;
}

#avatar-border
{
width:82px;
height:82px;
border:1px solid #09f;
text-align: center;
margin: auto;
}

#avatar-border img
{
margin: 1px;
}

#content-center
{
position:relative;
top:0px;
max-width:650px;
left:100px;
padding-right:315px;
}

#content-right
{
float:right;
position:absolute;
top:0px;
right:0px;
max-width:200px;
}
</style>
</head>
<body>
<?php
include 'menu.php';
include 'user.php';
?>
<div id="mainbox">

<?php
if(isset($_GET['user']) and !empty($_GET['user'])) {
	$username = $_GET['user'];
        $username = $mysqli->real_escape_string($username); 
        $result = $mysqli->query("SELECT * FROM user WHERE username='$username'");
        $row = $result->fetch_array(MYSQLI_ASSOC);             
        if($row['username'] === $username) {
	     $proGravatar = new TalkPHP_Gravatar();
	     $proGravatar->setEmail($row['email']);
	     $proGravatar->setSize(80);
	     $progravurl = $proGravatar->getAvatar();
	     echo "<div id='content-left'>";

	     /*avatar section*/
	     echo "<div id='avatar-border'><img src='". $progravurl ."' alt='Gravatar' /></div>";
	     if ($username === $_SESSION['name']) {echo "[<a href='http://en.gravatar.com/gravatars/new/'>Edit</a>]";}
	     
	     echo "</div>";
	     
	     echo "<div id='content-center'>";
	     echo "<h1>" . $username . "</h1>";
	     echo "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel sodales ipsum. Vestibulum id purus quam. Sed non ligula vitae est aliquet euismod. Vivamus semper dui congue metus fermentum volutpat. In nec justo risus, eu pretium neque. Quisque rhoncus mi dui. Morbi feugiat tempor est a posuere. Nulla elementum leo eu felis tincidunt non auctor tortor hendrerit. Duis accumsan porttitor ante at dapibus. Proin at turpis vitae erat aliquet accumsan. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent pharetra, enim vitae accumsan mattis, velit elit scelerisque nisl, vitae sollicitudin lorem libero id orci. Vivamus molestie massa non ante ullamcorper mollis. Phasellus pulvinar tortor quis nulla fringilla vestibulum.</p>

<p>Curabitur auctor dolor nunc, et placerat tellus. In sed ipsum nec lorem pretium aliquam ut non ipsum. Nulla ut enim erat, posuere fermentum felis. Nunc gravida, urna eget dignissim egestas, nulla augue ultricies orci, vel viverra justo est quis dui. Donec ullamcorper dolor in odio dapibus euismod. Proin et dolor dui. Suspendisse in lobortis est. In cursus ante quis purus pulvinar eget condimentum dolor varius. Phasellus a velit nisi, et pellentesque tellus. Pellentesque sed erat eget ipsum vestibulum iaculis sed ut arcu. Nunc aliquet dignissim justo, quis scelerisque urna vestibulum vel. Praesent nisi dui, scelerisque ac feugiat at, vehicula sit amet mi. Quisque ac ullamcorper lacus. Duis ut sapien nec sem tristique ullamcorper. Nunc sed magna ut felis ornare pellentesque molestie iaculis purus.</p>

<p>Donec ut tortor metus, ut commodo leo. Aliquam erat volutpat. Phasellus pharetra, tortor ut sodales fringilla, elit est sodales orci, at commodo urna tellus a ipsum. Etiam id risus et risus dignissim mattis. Morbi mi erat, dictum vitae pellentesque et, ultrices in tortor. Proin dictum turpis eu turpis vestibulum rhoncus. Curabitur venenatis sapien dapibus tellus ultricies sit amet aliquam nibh sagittis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin ut lorem metus. Suspendisse ac leo nulla, quis tempus urna. Morbi elementum euismod lacus quis commodo. Duis luctus condimentum enim sed blandit. Maecenas enim nibh, egestas non porttitor sit amet, laoreet id nisl. Duis hendrerit lacinia nibh, vel sollicitudin dui aliquam quis. Nullam venenatis nisl id lorem bibendum nec commodo massa consequat.</p>

<p>Suspendisse vulputate fermentum neque, in faucibus ante ornare eget. Nunc laoreet, nunc non viverra molestie, neque mi cursus purus, sed dignissim ipsum ligula condimentum eros. Integer accumsan rhoncus vehicula. Aenean in aliquet lacus. Pellentesque quis nulla ac justo porta semper. Ut pulvinar dolor vel turpis commodo malesuada. Quisque tristique eleifend tincidunt. Sed id urna vitae justo mattis auctor. Etiam egestas ligula eget tellus sodales dictum. Maecenas sodales nisl a erat consequat condimentum. Mauris neque nunc, ornare eget consequat dictum, venenatis a leo. Phasellus sodales metus et tortor rhoncus nec hendrerit lorem fringilla.</p>

<p>Quisque aliquam ante at mauris fermentum eu convallis nunc blandit. Vivamus malesuada suscipit odio, in venenatis est interdum at. Cras venenatis aliquam est, sit amet lobortis quam mollis sit amet. Donec dictum orci convallis sapien tincidunt consequat. Vestibulum at mollis purus. Vivamus fermentum mauris sit amet nunc sagittis ut condimentum sem lobortis. Mauris eu massa mauris. Etiam aliquam augue quis metus venenatis quis commodo ligula blandit. Morbi vel mi dui, ut fermentum augue. Vestibulum commodo adipiscing lectus, ac venenatis leo venenatis a. Aenean tincidunt fermentum aliquet. Aliquam vitae dolor at arcu lobortis rutrum. In rutrum rutrum metus eu vulputate. Donec ullamcorper, tortor ac elementum tempor, leo quam aliquet nisl, ac imperdiet ligula justo sed eros. Phasellus in nulla metus, in ornare ante.</p>";
	     echo "</div>";
	     

        } else {
             echo "Error: User does not exist.";
        } 
} else {

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

echo "<div id='content-right'><div id='leaderboard' style='display:inline-block;background-color:black'>leaedr board<br>";

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
