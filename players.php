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
<script type="text/javascript" src="JS/idtabs.js"></script>
<style>
#mainbox
{
max-width:100%;
min-width:777px;
margin-top:30px;
overflow:visible;
}
#user
{
  display:block;
  position:absolute;
  top:15px;
  right:30px;
  line-height:22px;
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
border:2px solid #2F2F88;
border-radius: 2px;
}

#content-left
{
position:absolute;
top:-29px;
left:0px;
z-index:10;
}

#avatar-border
{
width:202px;
height:202px;
border:3px solid #2F2F88;
text-align: center;
margin: auto;
border-radius: 5px;
background: #2F2F88;
box-shadow: .2em .2em .3em rgba( 0, 0, 0, 0.45 );
}

#avatar-border img
{
margin: 1px;
border-radius: 5px;
}

#bio
{
display:inline-block;
position:relative;
left:168px;
}

.usual li {
list-style: none;
float: left;
text-shadow: black 1px 1px 2px;
}

.usual ul a {
display: block;
padding: 6px 10px;
text-decoration: none!important;
margin-right: 5px;
margin-left: 0;
font: 10px Trebuchet, arial, sans-serif;
line-height:10px;
color: white;
background: transparent;

}

.usual ul a:hover {

  color: #FFF;
background: #11183F;
border-bottom: 1px solid #11183F;
margin-bottom: 0;
border-top-right-radius:5px;
border-top-left-radius:5px;
  }

.usual ul a.selected {
margin-bottom: 0;
  color:#FFF;
/*  background:#2F2F88; */
  background:#11183F;
border-bottom: 1px solid #11183F;
cursor: default;
border-top-right-radius:5px;
border-top-left-radius:5px;
}

p
{
padding:10px;
margin:0px;
}

#content-center
{
position:relative;
top:-3px;
/*max-width:595px;   */
max-width:695px;
min-width:383px;
min-height:170px;
left:0px;
margin-right:270px;
background:#11183F;
border-radius: 10px;
box-shadow: .2em .2em .3em rgba( 0, 0, 0, 0.45 );
z-index:0;
}

#content-title
{
/*background:#2F2F88;*/
text-align:left;
color:#fff;
font-family: Trebuchet, arial, sans-serif;
font-size: 25px;
font-weight: normal;
text-shadow: #388CC8 1px 1px 2px;
letter-spacing: .025em;
line-height: 30px;
margin-left: 5px;
padding: 0;
max-width:200px;
}

#content-right
{
float:right;
position:absolute;
top:0px;
right:0px;
max-width:255px;
}

#tabs
{
display:inline-block;
position:relative;
left:-40px;
top:13px;
}

#content-bottom
{
  margin-top:10px;
  max-width:695px;
  min-width:383px;
  min-height:270px;
  left:0px;
  margin-right:270px;
  background:#11183F;
  border-radius: 10px;
  border-top-left-radius:0px;
  box-shadow: .2em .2em .3em rgba( 0, 0, 0, 0.45 );
}

#leaderboard
{
position:relative;
width:255px;
display:inline-block;
background: rgba(0, 0, 0, 0.6);
border-radius: 10px;
border:5px solid #000;
}

#matches
{
position:relative;
width:255px;
display:inline-block;
background: rgba(0, 0, 0, 0.6);
border-radius: 10px;
margin:20px 0px 0px 0px;
border:5px solid #000;
}

</style>
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
        <div id='fvbux'>You have <br>
        $totalpoints
        <br>FVBux</div>
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
  font-weight:bold;
  text-shadow: black 1px 1px 0px;
  overflow: hidden;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
  min-width:25px;
  width:". round(($leadpoints / $highest) * 95) ."%'>
  ". $leadpoints ." FVBux
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
