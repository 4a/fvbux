<?php
session_start();
require('PHP/functionlist.php');

if(isset($_GET['bid'])) {
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
body{
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
echo $user1 . " is betting " . $betvalue . " on " . $user1choice . " in the match-up:";
echo "<h1>" . $input1 . "</h1>";
echo "<h4>VS</h4>";
echo "<h1>" . $input2 . "</h1>";
echo "where the winner is chosen by " . $mod . ".";
echo "<br>Would you like to bet " . $betvalue . " on " . $user2choice . "?";
?>

</body>
</html>
