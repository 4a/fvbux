<?php
session_start();
require('PHP/connect.php');
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
#user
{
 display:block;
 position:absolute;
 top:15px;
 right:30px;
 line-height:22px;
}

#matchesBox
{
 height:auto;
 width:492px;
 margin:auto;
}

.matchContainer
{
 height: 53px;
 width: 100%;
 background-color: white;
 border-style: solid;
 border-width: 3px;
 border-color: grey;
 color: black;
 overflow:hidden;
 position:relative;
 transition: all 300ms ease-out;
 -moz-transition: all 300ms ease-out;
 -webkit-transition: all 300ms ease-out;
}

.match
{
 width:50%;
 min-height:100%;
 float:left;
 padding: 4px 4px 4px 4px;
}

/* since the widths of these divs is 50% adding a border between the match div and the info div will create a line break. if you want a border it would be better to set the widths to a pixel value that is half of the width of the container minus the width of the border you want. */

.matchInfo
{
 width:50%;
 min-height:100%;
 margin-left: 50%;
 border-left: solid 1px grey;
 padding: 4px 4px 4px 4px;
}

.match img {
 float: left;
 width: 45px;
 height: 45px;
 padding-right: 3px;
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
</style>
</head>

<body>
<?php 
include('user.php'); 

$MatchImage = new TalkPHP_Gravatar();
$MatchImage->setEmail($_SESSION['email']);
$MatchImage->setSize(45);
$imgURL = $MatchImage->getAvatar();

?>
<div id='matchesBox'>
<?php
if($stmt = $mysqli->prepare("SELECT `ID`, `Input 1`, `Input 2`, `Mod`, `Timestamp` FROM `bets_matches` 
WHERE status = 'open' ORDER BY `ID` DESC LIMIT 10")) {
	$stmt->execute();
	$stmt->bind_result($matchNo, $name1, $name2, $mod, $timestamp);
	
	$resultset = Array();
	while($stmt->fetch()) {
		$resultset[] = array(
			"ID" 				=> $matchNo,
			"Input1" 		=> $name1,
			"Input2"		=> $name2,
			"Mod"			=> $mod,
			"Timestamp" 	=> $timestamp,
			);
	}
	
	foreach($resultset as $result) {
		/* Need the user meta table and link the <img> tag to their avatar 
			And also fill in the missing info when the sql tables are updated with it*/
		$currenttime = strtotime('now');
		$timelimit = daysToSeconds(1);
		$timestamp = strtotime($timestamp);
		
		if(($currenttime - $timestamp) > $timelimit) {
			$ID = $result['ID'];
		
			/* Change status of bets_matches and any bets that are linked to that ,atch to 'timeout' */
			if($stmt1 = $mysqli->prepare("UPDATE `bets_matches` SET `status` = 'timeout' WHERE `ID` = ?")) {

				$stmt1->bind_param("i", $ID);
				$stmt1->execute();
			} else {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if($stmt2 = $mysqli->prepare("UPDATE `bets_money` SET `status`='timeout' WHERE `match`=?")) {
				$stmt2->bind_param("i", $ID);
				$stmt2->execute();
            } else {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
		} else {
			echo "
			<a href='bets.php?" . $result['ID'] . "'>
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

<!--
<div id='matchesBox'>
	<div class='matchContainer'>
		<div class='match'>
		<img src='<?//php echo $imgURL; ?>' alt='pic' >
		<div>Evo</div>
		<div>Bob vs Jim</div>
		</div>
		
		<div class='matchInfo'>
		<div>Mod: Joe</div>
		<div>Info: Losers Bracket Semi-Finals</div>
		</div>
	</div>
	<div class='matchContainer'>
		<div class='match'>
		Hiya
		</div>
		
		<div class='matchInfo'>
		</div>
	</div>			
</div>
-->
</body>

</html>
