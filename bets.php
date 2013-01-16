<?php
session_start();
require('PHP/functionlist.php');
if(isset($_SESSION['loggedin'])) {
$totalpoints = getPoints($_SESSION['name']);  }
$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
if(array_key_exists('submit',$_POST)) {
        $input1 = $_POST['input1'];
	$input2 = $_POST['input2'];
	createMatch($input1, $input2, $_SESSION['name'], $IP);
	header('Location:bets.php?mid='.$newID);
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
/* $IPBYPASS is used to get around the ip check so you are able to test bet creation locally */
$IPBYPASS = TRUE;

if(isset($_SESSION['loggedin'])) 
{
 updatePoints(1, $_SESSION['name']);
 if(isset($_GET['mid']) and !empty($_GET['mid']) and ctype_digit($_GET['mid'])) 
 {
  $match_ID = $_GET['mid'];
  $match_ID = $mysqli->real_escape_string($match_ID); 
  $Match = new MatchInfo($match_ID);
  $matchid = $Match->getMatchID();
  $input1 = $Match->getInput1();
  $input2 = $Match->getInput2();
  $mod = $Match->getMod();
  $modip = $Match->getModIP();
  if($matchid == $match_ID)
  {
   if ($_SESSION['name'] === $mod)
   {
   echo "<h1>" . $input1 . "</h1>";
   echo "<h4>VS</h4>";
   echo "<h1>" . $input2 . "</h1>";
   echo "You are the moderator";
   }
   else if ($IP == $modip and !$IPBYPASS) 
   {
    echo "<h1>" . $input1 . "</h1>";
    echo "<h4>VS</h4>";
    echo "<h1>" . $input2 . "</h1>";
    echo "You have the same IP as the moderator";
   } 
   else
   {
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

    while ($stmt->fetch())
    {
    echo $i++ .". <a href='playerbet.php?bid=". $betNo ."'> ". $betvalue ." FVBux on ". $user1choice ."</a>
         [<a href='players.php?user=". $user1name ."'>". $user1name ."</a>]<br>";
    }

    echo "</div>";
/* End list of open bets */

    echo "<br />Select a bet from the list or"
    ."<br /><a href='createbet.php?mid=$match_ID'><img src='IS/createbet.jpg'></a>";
   }
  } 
  else
  {
   echo "Error: Match does not exist in database.<br>
   <form action='$_SERVER[PHP_SELF]' method='post'>
   <input type='text' name='input1'><br />
   VS<br />
   <input type='text' name='input2'><br />
   <input type='submit' name='submit' value='Submit' />";
  }
 }
 else 
 {
  echo "
  This is the submission form for creating and moderating a match-up.
  As the moderator, you cannot bet on an outcome;
  however, you will have the opportunity to earn fvbux based on the amount of people who have participated in your match-up.
  <form action='$_SERVER[PHP_SELF]' method='post'>
  <input type='text' name='input1'><br />
  VS<br />
  <input type='text' name='input2'><br />
  <input type='submit' name='submit' value='Submit' />";
 }
}
else 
{
 echo "<a href='signuppage.php'>Register</a><br/>";
 echo "<a href='signinpage.php'>Log In</a>";
}
?>

</body>
</html>
