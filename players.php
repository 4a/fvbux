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
/* these usual classes are for the tabs like "bets, games" */
#prfl_tabs
{
/* Fallback */
	background:#575d6c;
/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#575d6c), to(#9fa2b3));
/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #9fa2b3, #575d6c);
/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #9fa2b3, #575d6c);
/* IE 10 */
	background: -ms-linear-gradient(top, #9fa2b3, #575d6c);
/* Opera 11.10+ */
	background: -o-linear-gradient(top, #9fa2b3, #575d6c);
width:100%;
height:30px;
position:relative;
-moz-box-shadow: 0 3px 10px 0 #000, inset 0 5px 10px 1px #222;
-webkit-box-shadow: 0 3px 10px 0 #000, inset 0 5px 10px 1px #222;
box-shadow: 0 3px 10px 0 #000, inset 0 5px 10px 1px #222;
}

.usual ul {
margin:0px;
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
font: 10px Trebuchet, arial, sans-serif;
line-height:10px;
color: #ccc;
}

.usual ul a:hover {
color: #FFF;
margin-bottom: 0;
  }

.usual ul a.selected {
margin-bottom: 0;
color:#fff;
cursor: default;
}

#prfl_container
{
max-width:580px;
min-height:375px;
margin:40px auto;
background:#2e2d8b;
/* Safari 4-5, Chrome 1-9 */
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#2e2d8b), to(#423f96));
  
  /* Safari 5.1, Chrome 10+ */
  background: -webkit-linear-gradient(top, #423f96, #2e2d8b);
  
  /* Firefox 3.6+ */
  background: -moz-linear-gradient(top, #423f96, #2e2d8b);
  
  /* IE 10 */
  background: -ms-linear-gradient(top, #423f96, #2e2d8b);
  
  /* Opera 11.10+ */
  background: -o-linear-gradient(top, #423f96, #2e2d8b);
border-radius:5px;
border-top:1px solid #a888d5;
border-bottom:1px solid #1a198b;
position:relative;
}

#prfl_top
{
margin:15px;
min-height:108px;
}

.prfl_avatar img
{
border:4px solid #8885dc;
border-radius:5px;
float:left;
}

.prfl_name
{
font-size:30px;
font-weight:bold;
}

#prfl_bottom
{
position:relative;
margin:15px;
max-width:920px;
min-height:230px;
background:#202020;
border-radius:5px;
border-top:1px solid #1a198b;
border-bottom:1px solid #a888d5;
overflow:hidden;
-moz-box-shadow: inset 0 5px 10px 1px #000;
-webkit-box-shadow: inset 0 5px 10px 1px #000;
box-shadow: inset 0 5px 10px 1px #000;
}
</style>
</head>
<body>
<?php
include('menu.php');
include('user.php');
?>
<div id="prfl_container">
	<?php
	if(isset($_GET['user']) and !empty($_GET['user'])) {
		$username = $_GET['user'];
		if(doesUserExist($username)) {
			$user = New UserInfo($username);
			$profilename = $user->getUsername();
			$points = $user->getPoints();
			$meta = New UserMetaInfo($username);
			$gravemail = $meta->getGravEmail();
			$location = $meta->getLocation();
			if ( isset($_SESSION['loggedin']) && ( !(empty($_SESSION['lat']) || empty($_SESSION['long'])) ) ) {
				$mylat = $_SESSION['lat'];
				$mylong = $_SESSION['long'];
				$lat = $meta->getLatitude();
				$long = $meta->getLongitude();
				if ( !(empty($lat) || empty($long)) ) {
				$distance = distance($mylat, $mylong, $lat, $long, FALSE);
				$latency = 1000 * $distance / 299792.458;
				$distance = round($distance) ."km from you (". round($latency) ." ms)";
				} else {
				$distance = "";
				}
			} else {
			$distance = "";
			}
			$proGravatar = new TalkPHP_Gravatar();
			$proGravatar->setEmail($gravemail);
			$proGravatar->setSize(100);
			$progravurl = $proGravatar->getAvatar();
		} else {
			$profilename = "User not found";
		}
	} else {
		header('Location: betmain.php');
	}
	?> 
	<div id='prfl_top'>
	
		<div class='prfl_avatar'>
			<img src='<?php echo $progravurl ?>' alt='Gravatar' />
		</div>
		
		<div class='prfl_name'>
			<?php echo $profilename ?>
			<br>
			<?php echo $location ?>
			<br>
			<?php echo $distance ?>
			<br>
			<span class='fvbux'>$</span><?php echo $points ?>
		</div>
		
	</div>
	
	<div id='prfl_bottom'>
	<div id='prfl_tabs' class='usual'>
		<div id='tabs'>
		<ul>
			<li><a href='#tab1'>BETS</a></li>
			<li><a href='#tab2'>INFO</a></li>
		</ul>
	</div>

	<div id='content-bottom'>
		<div id='tab1'>
		</div>
    
		<div id='tab2'>
		</div>
    
		<script type='text/javascript'>
			$('#prfl_tabs ul').idTabs();
		</script>
	</div>
	</div>
</div>

</body>
</html>