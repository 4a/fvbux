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
<style>
body
{
  text-align:center;
}  

.editbox
{
	text-align:left;
	position:relative;
	width:440px;
	margin:auto;
	margin-top:40px;
	background:#0648CD;
	border:1px solid #fff;
	padding:20px;
	padding-top:0px;
	padding-bottom: 0px;
}

input[type="radio"] {
	display:none;
}

input[type="radio"] + label span {
	vertical-align: middle;
	display:inline-block;
	width: 50px;
	height: 50px;
	background: url(IS/radio-sheet.png) -50px top no-repeat;
	cursor: pointer;
}

input[type="radio"]:checked + label span {
	background: url(IS/radio-sheet.png) left top no-repeat;
}

.slipColumn {
	border: 1px solid #0648CD;
	height: 50px;
}

.slipColumn .playerName {
	text-align: center;
	height: 100%;
	border-style: solid;
	border-width: 0px 1px 0px 0px; 
	border-color: #0648CD;
	color: #3377FF;
	font-size: 3em;
	background-color: #8CCBF5;
	overflow: hidden;
}

.slipColumn .radioContainer {
	min-width: 50px;
	min-width: 50px;
	width: 50px;
	float: right;
	background-color: white;
}

.valueContainer {
	height: 30px;
	margin-top: 15px;
	margin-bottom: 15px;
}

.valueContainer .valueName {
	text-align: center;
	height: 100%;
	font-size: 1.5em;
	font-style: bold;
}

.valueContainer .valueInput {
	float: right;
	height: 100%;
	font-size: 1.7em;
	font-style: bold;
}
</style>
</head>
<body>
<?php
include 'menu.php';
include 'user.php';
?>

<div id='bettingslip'>
	<div class='editbox'>
		<div class="slipColumn">
			<div class="radioContainer"><input type="radio" id="r1" name="winner" />
			<label for="r1"><span></span></label></div>
			<div class="playerName">Daigo</div>
		</div>
		<div class="slipColumn">
			<div class="radioContainer"><input type="radio" id="r2" name="winner" />
			<label for="r2"><span></span></label></div>
			<div class="playerName">Mago</div>
		</div>
		<div class="valueContainer">
			<div class="valueInput">$ <input type="text" name="betamount" /></div>
			<div class="valueName">Bet Amount</div>
		</div>
	</div>
</div>
</body>
</head>
</html>