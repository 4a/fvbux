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
<link rel="stylesheet" type="text/css" href="CSS/tempstyles.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="JS/idtabs.js"></script>
</head>
<body>
<?php
include('menu.php');
include('user.php');
?>
<div id="mainbox">

<?php
if(isset($_GET['user']) and !empty($_GET['user']))
{
 $username = $_GET['user'];
 $username = $mysqli->real_escape_string($username);
 $result = $mysqli->query("SELECT * FROM user WHERE username='$username'");
 $row = $result->fetch_array(MYSQLI_ASSOC);
 
 if($row['username'] === $username) 
 {
  $proGravatar = new TalkPHP_Gravatar();
  $proGravatar->setEmail($row['email']);
  $proGravatar->setSize(200);
  $progravurl = $proGravatar->getAvatar();
  echo "<div id='content-left'>";
  echo "<div id='content-title'>" . $username;
  
  if (isset($_SESSION['loggedin']) && ($username === $_SESSION['name'])) 
  {
   echo "[<a href='http://en.gravatar.com/gravatars/new/'>Edit</a>]";
  }

  echo "</div>";

  /*avatar section*/
  echo "<div id='avatar-border'><img src='". $progravurl ."' alt='Gravatar' /></div>";
  echo "</div>";
  echo "
        <div id='bio' class='usual'>
        <ul>
        <li><a href='#bio' class='selected'>Bio</a></li>
        </ul>
        </div>
       ";
  echo "<div id='content-center'>";
  echo "
        <div id='bio1'>
        <p>
        <img src='IS/wrap.gif' style='float:left;align:left;width:205px;height:160px'>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Maecenas vel sodales ipsum. 
        Vestibulum id purus quam. 
        Sed non ligula vitae est aliquet euismod. 
        Vivamus semper dui congue metus fermentum volutpat. 
        In nec justo risus, eu pretium neque. 
        Quisque rhoncus mi dui. 
        Morbi feugiat tempor est a posuere. 
        Nulla elementum leo eu felis tincidunt non auctor tortor hendrerit. 
        Duis accumsan porttitor ante at dapibus. 
        Proin at turpis vitae erat aliquet accumsan. 
        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
        Praesent pharetra, enim vitae accumsan mattis, velit elit scelerisque nisl, vitae sollicitudin lorem libero id orci.
        Vivamus molestie massa non ante ullamcorper mollis. 
        Phasellus pulvinar tortor quis nulla fringilla vestibulum.
        </p>
        </div>
       ";
  echo "</div>";

  echo "
        <div id='usual1' class='usual'>
        <div id='tabs'>
        <ul>
        <li><a href='#tab1'>Bets?</a></li>
        <li><a href='#tab2'>Games?</a></li>
        </ul>
        </div>
       ";
             
  echo "<div id='content-bottom'>";

  echo "<div id='tab1'><p>";
  $stmt = $mysqli->prepare("SELECT `ID`, `value`, `user1choice` FROM `bets_money` WHERE (`username 1`=? AND `status`='open' AND `private`=0) ");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($betNo, $betvalue, $user1choice);

  echo "Bet against me!";
  while ($stmt->fetch())
  {
   echo "<br><a href='playerbet.php?bid=" . $betNo . "'>I'm betting " . $betvalue . " FVbux on " . $user1choice . "</a>";
  }

  echo "</p>";

  echo "<p>
        History:
       ";
  $stmt = $mysqli->prepare("SELECT `value` FROM `bets_money` WHERE (`winner`=?) ");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($winnings);
  while ($stmt->fetch())
  {
   echo "<br>I won " . $winnings . " FVbux";
  }

  echo "</p>";

  echo "<p>
        Moderating:
       ";

  $stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2` FROM `bets_matches` WHERE `Mod`=? ");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($matchNo, $input1, $input2);
  while ($stmt->fetch())
  {
   echo "<br><a href='bets.php?mid=" . $matchNo . "'>" . $input1 . " VS " . $input2 . "</a>";
  }

  echo "
        </p>
        </div>
       ";

  echo "
        <div id='tab2'>
        <p>
        Suspendisse vulputate fermentum neque, in faucibus ante ornare eget. 
        Nunc laoreet, nunc non viverra molestie, neque mi cursus purus, sed dignissim ipsum ligula condimentum eros. 
        Integer accumsan rhoncus vehicula. 
        Aenean in aliquet lacus. 
        Pellentesque quis nulla ac justo porta semper. 
        Ut pulvinar dolor vel turpis commodo malesuada. 
        Quisque tristique eleifend tincidunt.
        Sed id urna vitae justo mattis auctor. 
        Etiam egestas ligula eget tellus sodales dictum. 
        Maecenas sodales nisl a erat consequat condimentum. 
        Mauris neque nunc, ornare eget consequat dictum, venenatis a leo. 
        Phasellus sodales metus et tortor rhoncus nec hendrerit lorem fringilla.
        </p>

        <p>
        Quisque aliquam ante at mauris fermentum eu convallis nunc blandit. 
        Vivamus malesuada suscipit odio, in venenatis est interdum at. 
        Cras venenatis aliquam est, sit amet lobortis quam mollis sit amet. 
        Donec dictum orci convallis sapien tincidunt consequat.
        Vestibulum at mollis purus. 
        Vivamus fermentum mauris sit amet nunc sagittis ut condimentum sem lobortis. 
        Mauris eu massa mauris. 
        Etiam aliquam augue quis metus venenatis quis commodo ligula blandit. 
        Morbi vel mi dui, ut fermentum augue. 
        Vestibulum commodo adipiscing lectus, ac venenatis leo venenatis a. 
        Aenean tincidunt fermentum aliquet. Aliquam vitae dolor at arcu lobortis rutrum. 
        In rutrum rutrum metus eu vulputate. 
        Donec ullamcorper, tortor ac elementum tempor, leo quam aliquet nisl, ac imperdiet ligula justo sed eros. 
        Phasellus in nulla metus, in ornare ante.
        </p>
        </div>
       ";
  echo "
        <script type='text/javascript'>
        $('#usual1 ul').idTabs();
        </script>
       "; 
       
  echo "</div>";

  echo "</div>";
 }

 else 
 {
  echo "Error: User does not exist.";
 }

}

else
{
 if(isset($_SESSION['loggedin'])) 
 {
  echo "
        <div id='fvbux'>You have <br><span class='fvbux'>$</span>" . $totalpoints . "</div>
        <div id='create'><a href='bets.php'>Create new match</a></div>
       ";
 } 
 else 
 {
  echo "<a href='signuppage.php'>Register</a><br/>";
  echo "<a href='signinpage.php'>Log In</a>";
 }

}

echo "<div id='content-right'><div id='leaderboard'>leaedr board<br>";

$stmt = $mysqli->prepare("SELECT username, points FROM user ORDER BY points DESC LIMIT 10");
$stmt->execute();
$stmt->bind_result($leadname, $leadpoints);
$rank = 1;
$lastpoints = 0;

while ($stmt->fetch())
{
 if (($lastpoints - $leadpoints) > 0) {$rank++;}
 if ($rank === 1) {$highest = $leadpoints;}

 echo
  $rank .". <a href='players.php?user=". $leadname ."'>". $leadname ."</a>
  <div style='
  position: relative;
  display: block;
  height: 20px;
  line-height: 20px;
  margin: 3px 0px 5px 0px;
  /*background: #71B7E6;*/
  background: #48779A;
  color: white;
  font-weight:normal;
  text-shadow: black 1px 1px 0px;
  overflow: hidden;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
  min-width:25px;
  width:". round(($leadpoints / $highest) * 95) ."%'>
  <span class='fvbux'>$</span>". $leadpoints ."
  </div>";

 $lastpoints = $leadpoints;
}
echo "</div>";

echo "<div id='matches'>stuff to bet on | <a href='bets.php'>Create new match</a><br>";

$stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod` FROM `bets_matches` ORDER BY `ID` DESC LIMIT 50");
$stmt->execute();
$stmt->bind_result($matchNo, $name1, $name2, $mod);
$i = 1;

while ($stmt->fetch())
{
 echo $i++ .". <a href='bets.php?mid=". $matchNo ."'> ". $name1 ." VS ". $name2 ."</a> [Moderator: ". $mod ."]<br>";
}

echo "</div></div>";
?>
</div>
</body>
</html>
