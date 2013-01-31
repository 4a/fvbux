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
	width:496px;
}

.match
{
	height: 46px;
	width: 100%;
	background-color: white;
	border-style: solid;
	border-width: 1px;
	border-color: red;
	color: black;
	padding: 4px 4px 4px 4px;
}

.match img {
	float: left;
	width: 45px;
	height: 45px;
}

.match:hover
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
	<div class='match'>
	<img src='<?php echo $imgURL; ?>' alt='pic' >
	</div>
	<div class='match'>
	Hiya
	</div>
</div>
</body>

</html>