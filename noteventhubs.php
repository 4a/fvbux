<?php
session_start();
require('PHP/connect.php');
require('PHP/functionlist.php');
if(!$_SESSION['loggedin']) {
	header('Location: players.php');
}
$UserInfo = new UserInfo($_SESSION['name']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {	
		if(!isset($errmsg)) {
				updateProfile($_SESSION['name'], $_POST['gravemail'], $_POST['location'], $_POST['lat'], $_POST['long'], $_POST['GGPO'], $_POST['LIVE'], $_POST['PSN']);	
$_SESSION['email'] = $_POST['gravemail'];				
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
<script src="JS/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="JS/geocode.js" type="text/javascript"></script>
<style>
/* Autocomplete
----------------------------------*/
.ui-autocomplete { position: absolute; cursor: default; }       
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }

/* workarounds */
* html .ui-autocomplete { width:1px; } /* without this, the menu expands to 100% in IE6 */

/* Menu
----------------------------------*/
.ui-menu {
        list-style:none;
        padding: 2px;
        margin: 0;
        display:block;
		background:white;
		color:black;
}
.ui-menu .ui-menu {
        margin-top: -3px;
}
.ui-menu .ui-menu-item {
        margin:0;
        padding: 0;
        width: 100%;
}
.ui-menu .ui-menu-item a {
        text-decoration:none;
        display:block;
        padding:.2em .4em;
        line-height:1.5;
        zoom:1;
}

.ui-menu .ui-menu-item a.ui-state-hover,
.ui-menu .ui-menu-item a.ui-state-active {
        margin: -1px;
}

/* Interaction states
----------------------------------*/

.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 0px solid #59b4d4; background: #0078a3 url(images/ui-bg_glass_40_0078a3_1x400.png) 50% 50% repeat-x; font-weight: normal; color: #ffffff; }

.editbox
{
position:relative;
width:640px;
margin:auto;
margin-top:40px;
background:#11183F;
border:1px solid #fff;
padding:20px;
padding-top:0px;
}

</style>
</head>

<body>
<?php
include('menu.php');
include('user.php');
$useravatar = new TalkPHP_Gravatar();
$useravatar->setEmail($_SESSION['email']);
$useravatar->setSize(80);
$imgURL = $useravatar->getAvatar();
$UserMeta = new UserMetaInfo($_SESSION['name']);
?>
<div style='margin:auto;width:640px;'>
<?php if(isset($errmsg)) echo "<div id='error'>" . $errmsg . "</div>"; ?>

<form name='profedit' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>

<div class='editbox' id='profedit_avatar'>
	<h2>Avatar</h2>

	<img style="float:left" src='<?php echo $imgURL; ?>' alt='avatar' >

	<div style="margin-left:100px">
		<label>Gravatar Email</label><br/>
		<input type='text' name='gravemail' value='<?php echo $UserMeta->getGravEmail(); ?>'>

		<br /><a href='https://en.gravatar.com/gravatars/new/' target='_blank'>Change your avatar at Gravatar.com</a>
		<div>(It may take a few minutes for your avatar changes to take effect)</div>
	</div>
</div>

<div class='editbox' id='profedit_gamenames'>
	<h2>Game Network IDs</h2>

	<label>GGPO</label><br/>
	<input type='text' name='GGPO' value='<?php echo $UserMeta->getGGPO(); ?>'><br/>

	<label>LIVE</label><br/>
	<input type='text' name='LIVE' value='<?php echo $UserMeta->getLIVE(); ?>'><br/>

	<label>PSN</label><br/>
	<input type='text' name='PSN' value='<?php echo $UserMeta->getPSN(); ?>'><br/>
</div>

<div class='editbox' id='profedit_email'>
	<h2>Account Info</h2>

	<label>Email (Private)</label><br/>
	<span style='font-style:italic'><?php echo $UserInfo->getEmail(); ?></span><input class='hidden' type='text' name='email' value='<?php echo $UserInfo->getEmail(); ?>'><br/><br/>

	<label>Location (Public)</label><br/>
	<input name='location' type="text" value='<?php echo $UserMeta->getLocation(); ?>' /><br />
	<span>This is what will be displayed in your profile.</span><br/><br/>

	<label>Location (Private)</label><br/>
	<input class='noEnterSubmit' id="address" type="text"/><br />
	<span>This is what will be used for calculating distance from other players. Only latitude and longitude will be stored.</span><br/>

    <br/><div id="map_canvas" style="width:640px; height:360px;"></div>
    
	<div class=''>
	<label>latitude</label><br/>
	<input id="latitude" name='lat' type="text" value='<?php echo $UserMeta->getLatitude(); ?>' /><br/>
    
	<label>longitude</label><br/>
	<input id="longitude" name='long' type="text" value='<?php echo $UserMeta->getLongitude(); ?>' /><br/>
	</div>	

</div>	

<input class='' type='submit' name='profedit-save' value='Save Changes'/>
</form>	
</div>

</div>
<script type="text/javascript">
$('.noEnterSubmit').keypress(function(e){
    if ( e.which == 13 ) return false;
    //or...
    if ( e.which == 13 ) e.preventDefault();
});
</script>
</body>
</html>