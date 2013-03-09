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
<script src="JS/s3Slider.js" type="text/javascript"></script>
<style>
#content
{
margin:auto;
margin-top:40px;
width:970px;
overflow:hidden;
}

.matches
{
width:640px;
float:left;
}

#matchesBox
{
 height:auto;
 width:634px;
 margin:auto;
 margin-top:40px;
 margin-bottom:100px;
 border: 3px solid grey;
 border-bottom: 0px;
}

.matchContainer
{
 height: 53px;
 width: 100%;
 background-color: white;
 border-bottom: 3px solid grey;
 color: black;
 overflow:hidden;
 position:relative;
 transition: all 200ms ease-out;
 -moz-transition: all 200ms ease-out;
 -webkit-transition: all 200ms ease-out;
}

.match
{
 width:50%;
 min-height:100%;
 float:left;
 padding: 4px;
}

.matchInfo
{
 width:50%;
 min-height:100%;
 margin-left: 50%;
 border-left: solid 3px grey;
 padding: 4px;
}

.match img 
{
 float: left;
 width: 45px;
 height: 45px;
 padding-right: 4px;
}

.match .eventName
{
}

.match .competitors
{
 font-size: 1.4em;
}

.matchContainer:hover
{
 background-color: #297EFF;
 color: white;
}

.sidebar
{
width:308px;
float:right;
}

.col_header
{
background-image: url(IS/headerbg.png);
height:25px;
line-height:25px;
padding-left:15px;
font-weight:bold;
}

.col_block
{
background: rgba(0, 0, 1, 0.4);
border-radius: 5px;
overflow:hidden;
padding-bottom:5px;
margin-bottom:40px;
}

.col_block a
{
color:#989eae;
font-family: Trebuchet, arial, sans-serif;
}

.col_block a:hover
{
color:#d24d04;
}

.lb-rank
{
padding-top:5px;
}

.lb-left
{
width:55px;
margin-left:5px;
font-size:45px;
text-align:center;
float:left;
}

.lb-left img
{
float:left;
}

.lb-right
{
margin-left:55px;
height:50px;
width:250px;
padding-top:5px;
}

.lb-right a
{
font-size:16px;
}

.featured
{
height:350px;
width:640px;
overflow:hidden;
position:relative;
background: #000;
}

#s3slider {
    width: 640px; /* important to be same as image width */
    height: 350px; /* important to be same as image height */
    position: relative; /* important */
}
 
#s3sliderContent {
    width: 640px; /* important to be same as image width or wider */
    position: absolute; /* important */
    top: 0px; /* important */
	right:0px;
	margin:0px;
	padding:0px;
}
 
.s3sliderImage {
	position:relative;
    display: none; /* important */
}
 
.s3sliderImage span {
    position: absolute; /* important */
    left: 0;
    font: 15px/20px Arial, Helvetica, sans-serif;
    padding: 10px 13px;
    width: 640px;
	height:75px;
    background-color: #000;
    filter: alpha(opacity=90); /* here you can set the opacity of box with text */
    -moz-opacity: 0.9; /* here you can set the opacity of box with text */
    -khtml-opacity: 0.9; /* here you can set the opacity of box with text */
    opacity: 0.9; /* here you can set the opacity of box with text */
    color: #fff;
    display: none; /* important */
    bottom: 0px; /*
        if you put top: 0;  -> the box with text will be shown 
                                at the top of the image
        if you put bottom: 0;  -> the box with text will be shown 
                                at the bottom of the image
    */
}
 
.clear {
    clear: both;
}
</style>
</head>
<body>
<?php
include('menu.php');
include('user.php');

$MatchImage = new TalkPHP_Gravatar();
?>

<div id='content'>

	<div class='matches'>
		<div class="featured">
<div id='s3slider'>
	<ul id='s3sliderContent'>
<?php

if($stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod`, `Event`, `Description`, `img1`, `img2` FROM `bets_matches` 
	WHERE `isfeatured` = 'yes' AND `status` = 'open' ORDER BY `ID` DESC LIMIT 10")) {
	$stmt->execute();
	$stmt->bind_result($matchNo, $name1, $name2, $mod, $event, $description, $img1, $img2);
	while ($stmt->fetch()) {
		echo " 
		<li class='s3sliderImage'>
		<div>
		<img style='width:50%;height:350px' src='". $img1 ."'/>
		<img style='position:absolute;right:0px;width:50%;height:350px' src='". $img2 ."'/>
		<div style='z-index:9999;position:absolute;top:0;left:0'><a href='bets.php?mid=". $matchNo ."'><img src='IS/VS.png'/></a></div>
		</div>	
        <span>"
		. $event 
		."<br>"
		. $description
		."</span>
        </li>
		";
	}
}
?>	
		<div class='clear s3sliderImage'></div>
    </ul>
</div>
<script type='text/javascript'>
$(document).ready(function() { 
    $('#s3slider').s3Slider({
        timeOut: 6000
    });
});
</script>
<!--	
		<div style="position:absolute;z-index:99999;bottom:0;height:50px;width:640px;background:rgba(0, 0, 1, 0.8);">Placeholder</div>
		<img style="width:50%;height:353px" src="IS/chrisg.png"/>
		<img style="position:absolute;right:0px;width:50%;height:353px" src="IS/fchamp.png"/>
		<div style="z-index:9999;position:absolute;top:0;left:0"><img src="IS/VS.png" width='640px'/></div>
-->		
		</div>
<a href='creatematch.php'>New Match</a>
		<div id='matchesBox'>
		<?php
	if($stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod`, `Timestamp`, `Event`, `Description` FROM `bets_matches` 
	WHERE status = 'open' ORDER BY `ID` DESC LIMIT 10")) {
	$stmt->execute();
	$stmt->bind_result($matchNo, $name1, $name2, $mod, $timestamp, $event, $description);
	
	$resultset = Array();
	while($stmt->fetch()) {
		$resultset[] = array(
			"ID"=>$matchNo,
			"Input1"=>$name1,
			"Input2"=>$name2,
			"Mod"=>$mod,
			"Timestamp"=>$timestamp,
			"Event"=>$event,
			"Description"=>$description
			);
	}
	
	foreach($resultset as $result) {
		/* Need the user meta table and link the <img> tag to their avatar 
			And also fill in the missing info when the sql tables are updated with it*/
		$currenttime = strtotime('now');
		$timelimit = daysToSeconds(3);
		$timestamp = strtotime($result['Timestamp']);
		
		if(($currenttime - $timestamp) > $timelimit) {
			$ID = $result['ID'];
		
			/* Change status of bets_matches and any bets that are linked to that match to 'timeout' */
			if($stmt1 = $mysqli->prepare("UPDATE `bets_matches` SET `status` = 'timeout' WHERE `ID` = ?")) {
				$stmt1->bind_param("i", $result['ID']);
				$stmt1->execute();
			} else {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}			
			if($stmt2 = $mysqli->prepare("UPDATE `bets_money` SET `status`='timeout' WHERE `match`=?")) {
				$stmt2->bind_param("i", $result['ID']);
				$stmt2->execute();
            		} else {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
		} else {
			$MetaInfo = new UserMetaInfo($result['Mod']);
			$email = $MetaInfo->getGravEmail();
			$MatchImage->setEmail($email);
			$MatchImage->setSize(45);
			$imgURL = $MatchImage->getAvatar();	
			$dscrpt = substr($result['Description'],0,40);//truncates the match description to fit in the box.
			echo "
			<a href='bets.php?mid=" . $result['ID'] . "'>
			<div class='matchContainer'>
				<div class='match'>
				<img src='" . $imgURL . "' alt='pic' >
				<div>". $result['Event'] . "</div>
				<div>" . $result['Input1'] . " vs " . $result['Input2'] . "</div>
				<div>Mod: ". $result['Mod'] . "</div>
				</div>
				
				<div class='matchInfo'>
				<div>Created: ". date('j<\s\up>S</\s\up> F Y',strtotime($result['Timestamp'])) . "</div>
				<div>Info: ". $dscrpt . "</div>
				</div>
			</div>
			</a>";
		}
	}

	}
	?>
	</div>

</div>

	
	<div class="sidebar">
<?php
 if(isset($_SESSION['loggedin'])) 
 {
  echo "	
	<div class='col_block'>
	<div class='col_header'>Your FV Bux</div>
	<br/>
	<div id='fvbux'>
	<span class='fvbux'>$</span>" . $totalpoints . "</div><br/></div>";
}
?>	
	
<div class='col_block'>
<div class='col_header'>Leader Board</div>
<br/>
<?php
$stmt = $mysqli->prepare("SELECT username, points FROM user ORDER BY points DESC LIMIT 10");
$stmt->execute();
$stmt->bind_result($leadname, $leadpoints);
$rank = 1;
$lastpoints = 0;
$resultset = Array();
while($stmt->fetch()) {
		$resultset[] = array(
			"leadname"=>$leadname,
			"leadpoints"=>$leadpoints
			);
	}
	
foreach($resultset as $result) {
 $leadname = $result['leadname']; 
 $leadpoints = $result['leadpoints'];
 if (($lastpoints - $leadpoints) > 0) {$rank++;}
 if ($rank === 1) {$highest = $leadpoints;}
 $UserMeta = new UserMetaInfo($leadname);
 $email = $UserMeta->getGravEmail();
 $MatchImage->setEmail($email);
 $MatchImage->setSize(50);
 $imgURL = $MatchImage->getAvatar();	
 
 echo
  "
  <div class='lb-rank' style='background:url(IS/rank-". $rank .".png) no-repeat'>
  <div class='lb-left'><a href='players.php?user=". $leadname ."'><img src='" . $imgURL . "' alt='pic' /></a></div> 
  <div class='lb-right'>
  <a href='players.php?user=". $leadname ."'>
  ". $leadname ."</a>
  <div style='
  position: relative;
  padding-left:5px;
  display: block;
  height: 20px;
  line-height: 20px;
  margin: 3px 0px 5px 0px;
  /*background: #71B7E6;
  background: #48779A;*/
  background: url(IS/headerbg.png);
  color: white;
  font-weight:bold;
  font-size:15px;
  text-shadow: black 2px 2px 1px;
  overflow: hidden;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
  min-width:25px;
  width:". round(($leadpoints / $highest) * 95) ."%'>
  <span class='fvbux'>$</span>". $leadpoints ."
  </div>
  </div>
  </div>";

 $lastpoints = $leadpoints;
}
?>
</div>

	</div>
</div>
</body>
</html>
