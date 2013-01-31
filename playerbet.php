<?php
session_start();
require('PHP/functionlist.php');

if(isset($_GET['bid']))
{
if(ctype_digit($_GET['bid'])) {
$BetInfo = new BetInfo($_GET['bid']);
                $betid = $BetInfo->getBetID();
                $match_ID = $BetInfo->getMatchID();
                $user1 = $BetInfo->getUser1();
                $user2 = $BetInfo->getUser2();
                $betvalue = $BetInfo->getBetValue();
                $user1ip = $BetInfo->getUser1IP();
                $status = $BetInfo->getStatus();
                $isprivate = $BetInfo->isPrivate();
                $user1choice = $BetInfo->getUser1Choice();

                $Match = new MatchInfo($match_ID);
                $matchid = $Match->getMatchID();
                $input1 = $Match->getInput1();
                $input2 = $Match->getInput2();
                $mod = $Match->getMod();
                $modip = $Match->getModIP();
                
                if ($user1choice === $input1) {
                  $user2choice = $input2;
                } else {
                  $user2choice = $input1;
                }

                if(isset($_SESSION['loggedin'])) {
                $totalpoints = getPoints($_SESSION['name']);
                if (empty($user2)) {
                  $user2 = $_SESSION['name'];}
                }
                
                $IP = $_SERVER['REMOTE_ADDR'];
                $IP = ip2long($IP);

                $shareurl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

                if(array_key_exists('submit',$_POST)) {
$status = challengeBet($betid, $user2, $betvalue);
                }
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
body{
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
$IPBYPASS = TRUE;
if(isset($_SESSION['loggedin']))
{

 if ($status === "open")
 {
  if (($_SESSION['name'] === $mod) || ($IP === $modip && !$IPBYPASS))
  {
   echo "You can't bet on match-ups where you are the moderator.";
  }

  else if (($user1 !== $_SESSION['name']) && ($IP === $user1ip && !$IPBYPASS))
  {
   echo "You can't bet against yourself.";
  }

  else if ($user1 === $_SESSION['name'])
  {
   echo "You have bet " . $betvalue . " on " . $user1choice;
   echo "<br>No one has bet against you yet.<br>";
   echo "Share URL: <input name='share_url' value='" . $shareurl . "'>";
   echo "<br /><br /><form action='cancelbet.php' method='POST'>
			<input type='hidden' name='betid' value='" . $_GET['bid'] . "'>
			<input type='image' src='IS/tick.png' name='submit'>
			</form>";
	echo "<br />(REPLACE TICK WITH PROPER 'CANCEL BET' IMAGE OR SOMETHING)";
  }

  else if ($totalpoints < $betvalue)
  {
   echo "You are too poor to participate in this bet.";
  }

  else
  {
  echo $user1 . " is betting " . $betvalue . " on " . $user1choice . " in the match-up:";
  echo "<h1>" . $input1 . "</h1>";
  echo "<h4>VS</h4>";
  echo "<h1>" . $input2 . "</h1>";
  echo "where the winner is chosen by " . $mod . ".";
  echo "<br>Would you like to bet " . $betvalue . " on " . $user2choice . "?";
  echo "
<form action='$_SERVER[REQUEST_URI]' method='post'>
<input type='submit' name='submit' value='Place Bet' />
";
  }

 }

 else if ($status === "locked")
 {
  echo "This bet is locked.<br>";
  echo $user2 . " agreed to bet " . $betvalue . " against " . $user1 . " in the match-up:";
  echo "<h1>" . $input1 . "</h1>";
  echo "<h4>VS</h4>";
  echo "<h1>" . $input2 . "</h1>";
  echo "where the winner is chosen by " . $mod . ".";
 }

 else
 {
  echo "This match has ended.";
 }

}

else
{
 echo "You have to be logged in.";
}

?>

</body>
</html>
