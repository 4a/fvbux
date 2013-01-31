<?php
session_start();
require('PHP/connect.php');
require('PHP/functionlist.php');
if($_SESSION['level'] != 'admin') {
	header('Location: players.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST['changepoints-submit'])) {

		if(empty($_POST['addorminus'])) {
			$errmsg = "Add or minus not selected";
		}
	
		if(empty($_POST['amount'])) {
			$errmsg = "Amount value not given";
		}
	
		if(!preg_match('/^\d+$/', $_POST['amount'])) {
			$errmsg = "Amount is not numeric value";
		}

		if(empty($_POST['username'])) {
			$errmsg = "Username not entered";
		} else {
			if(!doesUserExist($_POST['username'])) {
				$errmsg = "Username entered does not exist";
			}
		}
		
		if(!isset($errmsg)) {
			if($_POST['addorminus'] == "add") {
				updatePoints($_POST['amount'], $_POST['username']);
			} else {
				minusPoints($_POST['amount'], $_POST['username']);
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
<script type="text/javascript" src="JS/idtabs.js"></script>

</head>

<body>
<?php
include('menu.php');
include('user.php');
?>
<?php if(isset($errmsg)) echo "<div id='error'>" . $errmsg . "</div>"; ?>
<div id='changeuserpoints'>
<h2>Change User's Points</h2>
<form name='changepoints' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
Username: <input type='text' name='username' /><br />
Add/Minus: Add<input type='radio' name='addorminus' value='add'/>&nbsp;Minus<input type='radio' name='addorminus' value='minus'/><br />
Amount: <input type='text' name='amount' /><br/>
<input type='submit' name='changepoints-submit' />
</form>	
</div>

</body>
</html>
