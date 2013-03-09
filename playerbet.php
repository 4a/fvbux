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
		
		$winner = $BetInfo->getBetWinner();
		if ($winner === $user1) {
			$loser = $user2;
		} else {
			$loser = $user1;
		}	

		$Match = new MatchInfo($match_ID);
		$matchid = $Match->getMatchID();
		$input1 = $Match->getInput1();
		$input2 = $Match->getInput2();
		$mod = $Match->getMod();
		$modip = $Match->getModIP();

		if ($user1choice === $input1) {
			$user2choice = $input2;
			$user1img = $Match->getImg1();
			$user2img = $Match->getImg2();
		} else {
			$user2choice = $input1;
			$user1img = $Match->getImg2();
			$user2img = $Match->getImg1();
		}
			
		$IP = $_SERVER['REMOTE_ADDR'];
		$IP = ip2long($IP);

		$shareurl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

		if(array_key_exists('submit',$_POST)) {
			if(!isset($_SESSION['loggedin'])) {
				$errmsg = "You need to be <a href='signinpage.php'>logged in</a> to do that.";
			} else {
				$totalpoints = getPoints($_SESSION['name']);
				if (empty($user2)) {
					$user2 = $_SESSION['name'];
				}
				if ($totalpoints < $betvalue) {
					$errmsg = "You are too poor to participate in this bet.";
				}				
				if (($_SESSION['name'] === $mod) || ($IP === $modip && !$IPBYPASS)) {
					$errmsg = "You are the moderator ya cunt!";
				}
				if ($IP === $user1ip && !$IPBYPASS) {
					$errmsg = "You can't bet against yourself.";
				}
			}			
			if(!isset($errmsg)) {	
				$status = challengeBet($betid, $user2, $betvalue);
			}	
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
<script type="text/javascript" src="JS/jquery.zclip.js"></script>
<style>
body{
text-align:center;
}

#share
{
width:410px;
min-height:285px;
margin:40px auto;
background:#090b75 url('IS/share_bg.gif') repeat-x;
border-radius:5px;
border-top:1px solid #6d93f6;
}

input#url
{
height:27px;
width:260px;
padding:0px;
border:0px;
background:url('IS/url_sprite.gif');
text-align:left;
padding:0px 10px 0px 10px;
margin: auto 0px 10px;
color:#112683;
}

#zclip_button
{
height:25px;
width:25px;
background:url('IS/copy_sprite.gif');
display:inline-block;
position:relative;
top:9px;
border-top:1px solid #afd0f9;
border-bottom:1px solid #1824ae;
border-top-left-radius:5px;
border-bottom-left-radius:5px;
}

.pb_amount
{
font-size:30px;
font-weight:bold;
margin:22px auto 10px;
text-shadow: 0px 3px 2px rgba(0, 0, 0, .5);
}

.pb_choice
{
background:#3d4fcd url('IS/choice_bg.gif') repeat-x;
min-height:75px;
width:300px;
margin:auto;
-webkit-box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
-moz-box-shadow:    0px 5px 5px rgba(0, 0, 0, 0.2);
box-shadow:         0px 5px 5px rgba(0, 0, 0, 0.2);
border-top:1px solid #aecffc;
border-bottom:1px solid #262acb;
}

.pb_choice p
{
font-size:35px;
font-weight:bold;
display:table-cell;
vertical-align: middle;
text-align:center;
height:75px;
width:200px;
overflow:hidden;
}

.pb_choice img
{
width:68px;
height:75px;
float:left;
}
</style>
</head>

<body>
<?php
include 'menu.php';
include 'user.php';
if(isset($errmsg)) {
	echo "<div class='error'>" . $errmsg . "</div>";
}
?>

<?php
	if ($status === "open") {
		if ( (isset($_SESSION['loggedin'])) && ($user1 === $_SESSION['name']) ){ /* logged in as bet creator. share url page */
			echo "<div id='share'>";
			echo "<div class='pb_amount'>You have bet <span class='fvbux'>$</span>" . $betvalue . " on</div>";
			echo "<div class='pb_choice'>";
			if(!empty($user1img)){echo "<img src='". $user1img ."'/>";}
			echo "<p>". $user1choice ."</p></div>";
			echo "<br>No one has bet against you yet.<br>";
			echo "Share URL <div id='zclip_button' href='#'></div>"; 
			echo "<input id='url' name='share_url' value='" . $shareurl . "' readonly onClick='this.select()'/>";
			echo "<div id='success' class='hidden'>Copied to clipboard</div>";	
			echo "<script type='text/javascript'>
				$(document).ready(function(){
				$('#zclip_button').zclip({
				path:'JS/ZeroClipboard.swf',
				copy:$('input#url').val(),
				beforeCopy:function(){
				$('input#url').css('background-position','0px 27px');
				$(this).css('background-position','0px 25px');
				$(this).css('border-bottom','1px solid #afd0f9');
				$(this).css('border-top','1px solid #1824ae');
				$('#success').hide();
				},
				afterCopy:function(){
				$('input#url').css('background-position','0px 0px');
				$(this).css('background-position','0px 0px');
				$(this).css('border-top','1px solid #afd0f9');
				$(this).css('border-bottom','1px solid #1824ae');
				$('#success').fadeIn(1000);
				}
				});
				});
				</script>";
			echo "<br /><br /><form action='cancelbet.php' method='POST' onsubmit=\"return confirm('Erase this bet?')\" />
				<input type='hidden' name='betid' value='" . $_GET['bid'] . "'>
				<input type='image' src='IS/cancel.png' style='margin-bottom:20px' name='submit'>
				</form>";		
			echo "</div>";
		}
		
		else { /* not logged in as bet creator */
			echo $user1 . " is betting " . $betvalue . " on " . $user1choice . " in the match-up:";
			echo "<h1>" . $input1 . "</h1>";
			echo "<h4>VS</h4>";
			echo "<h1>" . $input2 . "</h1>";
			echo "where the winner is chosen by " . $mod . ".";
			echo "<br>Would you like to bet " . $betvalue . " on " . $user2choice . "?";
			echo "<form action='$_SERVER[REQUEST_URI]' method='post'>
				<input type='submit' name='submit' value='Place Bet' />";
		}
	}
	
	else if ($status === "locked") { /* winner not determined. bet challenged */
		echo "This bet is locked.<br>";
		echo $user2 . " agreed to bet " . $betvalue . " against " . $user1 . " in the match-up:";
		echo "<h1>" . $input1 . "</h1>";
		echo "<h4>VS</h4>";
		echo "<h1>" . $input2 . "</h1>";
		echo "where the winner is chosen by " . $mod . ".";
	}

	else { /* winner selected. bet status is closed. */
		echo "This match has ended.<br>";
		echo $winner ." stole <span class='fvbux'>$</span>". $betvalue ." from ". $loser;
	}
?>

</body>
</html>
