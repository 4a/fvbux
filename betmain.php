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
height:353px;
width:640px;
overflow:hidden;
position:relative;
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
		<div style="position:absolute;z-index:99999;bottom:0;height:50px;width:640px;background:rgba(0, 0, 1, 0.8);">Placeholder</div>
		<img style="width:50%;height:353px" src="IS/chrisg.png"/>
		<img style="position:absolute;right:0px;width:50%;height:353px" src="IS/fchamp.png"/>
		<div style="z-index:9999;position:absolute;top:0;left:0"><img src="IS/VS.png" width='640px'/></div>
		</div>

		<div id='matchesBox'>
	<?php
	if($stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod`, `Timestamp` FROM `bets_matches` 
	WHERE status = 'open' ORDER BY `ID` DESC LIMIT 10")) {
	$stmt->execute();
	$stmt->bind_result($matchNo, $name1, $name2, $mod, $timestamp);
	
	$resultset = Array();
	while($stmt->fetch()) {
		$resultset[] = array(
			"ID"=>$matchNo,
			"Input1"=>$name1,
			"Input2"=>$name2,
			"Mod"=>$mod,
			"Timestamp"=>$timestamp,
			);
	}
	
	foreach($resultset as $result) {
		/* Need the user meta table and link the <img> tag to their avatar 
			And also fill in the missing info when the sql tables are updated with it*/
		$currenttime = strtotime('now');
		$timelimit = daysToSeconds(1);
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
			$UserInfo = new UserInfo($result['Mod']);
			/* using user email until gravatar field exists */
			$email = $UserInfo->getEmail();
			$MatchImage->setEmail($email);
			$MatchImage->setSize(45);
			$imgURL = $MatchImage->getAvatar();	
			echo "
			<a href='bets.php?mid=" . $result['ID'] . "'>
			<div class='matchContainer'>
				<div class='match'>
				<img src='" . $imgURL . "' alt='pic' >
				<div>Event Name Here</div>
				<div>" . $result['Input1'] . " vs " . $result['Input2'] . "</div>
				</div>
				
				<div class='matchInfo'>
				<div>Mod: ". $result['Mod'] . "</div>
				<div>Info: Info Goes Here</div>
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
 $UserInfo = new UserInfo($leadname);
 $uid = $UserInfo->getUserID();
 $UserMeta = new UserMetaInfo($uid);
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
