<?php
session_start();
require('PHP/functionlist.php');

$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);

if(array_key_exists('submit',$_POST)) {
	$featured = isset($_POST['featured']) ? 'yes' : 'no';
	$img1 = "";
	$img2 = "";
	$description = $_POST['description'];
    if(!empty($_POST['input1'])) {
		$submitinput1 = $_POST['input1'];
	} else {
		$errmsg = "You didn't fill in the first betting choice.";
	}
    if(!empty($_POST['input2'])) {
		$submitinput2 = $_POST['input2'];
	} else {
		$errmsg = "You didn't fill in the second betting choice.";
	}
	if(empty($_POST['input1']) && empty($_POST['input2'])) {
		$errmsg = "You didn't submit any choices to bet on.";
	}
	if(!empty($_POST['event'])) {
		$event = $_POST['event'];
	} else {
		$errmsg = "You didn't fill in the event name.";
	}
	if(isset($_POST['featured'])){
		if(!preg_match("/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|gif|png)$/i", $_POST['img1'])
		|| !preg_match("/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|gif|png)$/i", $_POST['img2'])) {
			$errmsg = "Invalid image url submitted.";
		}
		if(empty($_POST['img1']) || empty($_POST['img2'])) {
			$errmsg = "Featured matches require images of each choice.";
		}
	$img1 = $_POST['img1'];	
	$img2 = $_POST['img2'];
	}
	if(!isset($_SESSION['loggedin'])) {
		$errmsg = "You need to be <a href='signinpage.php'>logged in</a> to do that.";
	}
	if(!isset($errmsg)) {
	$newMID = createMatch($submitinput1, $submitinput2, $_SESSION['name'], $IP, $event, $description, $featured, $img1, $img2);
	header('Location:bets.php?mid='.$newMID);}
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
#form_create
{
background:#070419 url('IS/form_BG.gif') repeat-x 0px 0px;
border-bottom:#2700fc 1px solid;
border-radius:5px;
width:660px;
margin:40px auto;
text-align:center;
}

.form_head
{
background:url('IS/form_head.gif') repeat-x;
height:23px;
width:100%;
border-top-left-radius:5px;
border-top-right-radius:5px;
border-top:#9c8fd5 1px solid;
}

#form_create input[type='text'], textarea
{
color:#fff;
font-weight:bold;
font-family:arial;
background:black;
border:0px;
border-radius:5px;
text-align:center
}

.form_text
{
margin:10px;
}

.form_box
{
width:155px;
height:22px;
position:relative;
}

.form_boxinput
{
bottom:30px;
}

.form_boxleft
{
right:15px;
}

.form_boxright
{
left:15px;
}

.form_event
{
margin:5px auto auto auto;
width:245px;
height:32px;
font-size:20px;
}

.form_description
{
margin:5px auto 15px auto;
max-width:225px;
min-width:225px;
min-height:70px;
text-align:left;
padding:5px 10px;
}

.form_featured
{
font-size:15px;
}

.form_submit
{
margin:20px auto 40px auto;
background: url('IS/submit.png') no-repeat;
border:none;
width:83px;
height:31px;
cursor:pointer;
}

.form_box:focus, .form_event:focus, .form_description:focus
{
outline: #2700fc auto;
}

::-webkit-input-placeholder { /* WebKit browsers */
    color:    #5f5f5f;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #5f5f5f;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #5f5f5f;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    color:    #5f5f5f;
}

</style>
</head>
<body>
<?php
include 'menu.php';
include 'user.php';
if(isset($errmsg)) {echo "<div class='error'>" . $errmsg . "</div>";}
?>
<div id='form_create'>
	<div class='form_head'></div>
	
	<div class='form_text'>
		This is the submission form for creating and moderating a matchup.
		<br>As the moderator, you will not be able to bet on this match.
		<br>You will, however, earn ten FVBUX for every completed bet.
	</div>
	
	<form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post'>
		<div>
			<input class='form_event' type='text' name='event' placeholder='EVENT TITLE' autocomplete='off'><br>
			<textarea class='form_description' name='description' placeholder='Description'></textarea><br>
		</div>
		
		<div>
			<input class='form_box form_boxinput form_boxleft' type='text' name='input1' placeholder='SCRUBLORD 1' autocomplete='off'>
			<img src='IS/VS2.png' alt='VS'/>
			<input class='form_box form_boxinput form_boxright' type='text' name='input2' placeholder='SCRUBLORD 2' autocomplete='off'><br>
		</div>
		
		<div class='form_featured'>
			<input class='form_box form_boxleft' type='text' name='img1' placeholder='Paste Image URL Here' autocomplete='off'>
			Featured?<input class='featured' type='checkbox' name='featured' title='Your matchup will be featured on the front page. Two images are required for featured matches.'>
			<input class='form_box form_boxright' type='text' name='img2' placeholder='Paste Image URL Here' autocomplete='off'><br>
		</div>

		<input class='form_submit' type='submit' name='submit' value=''/>
	</form>	
</div>
</body>
</html>
