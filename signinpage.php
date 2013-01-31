<?php
session_start();
if(isset($_SESSION['loggedin'])) {
	header('Location: players.php');
}

$errlogin = "";
if(array_key_exists('submit',$_POST)) {
	require('PHP/connect.php');
	require('PHP/PasswordHash.php');

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(!($stmt = $mysqli->prepare("SELECT password, email, acclevel FROM user WHERE username=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s", $username)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$stmt->bind_result($passhash, $email, $acclevel);
	$stmt->fetch();
	$Hasher = new PasswordHash(8, FALSE);

	if($Hasher->CheckPassword($password, $passhash)) {
		$_SESSION["loggedin"] = "yes";
		$_SESSION['name'] = $username;
		$_SESSION['level'] = $acclevel;
		$_SESSION['email'] = $email;
		header('Location: players.php');
	} else {
		$errlogin = "Username and password combination is not valid";
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
.loginbox
{
position:relative;
height:384px;
width:640px;
margin:auto;
margin-top:40px;
background:#11183F;
border:1px solid #fff;
}

.signin
{
width:300px;
height:382px;
display:inline-block;
position:relative;
padding:0px 16px;
}

.separator
{
width:1px;
height:352px;
background:#fff;
display:inline-block;
position:absolute;
left:50%;
top:17px;
}

.register
{
width:300px;
height:382px;
display:inline;
position:absolute;
left:50%;
padding:0px 16px;
}

.textinput
{
width:280px;
}

</style>
</head>
<body>
<?php
include 'menu.php';
?>
<?php if($errlogin != "") { echo "<div style='color:red'>$errlogin</div><br />"; } ?>
<div class="loginbox">

<div class='signin'>
	<h2>Sign in</h2>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
	<div>Username</div>
	<input type="text" name="username" class="textinput"><br />

	<div style="margin-top:16px">Password</div><input type="password" name="password" class="textinput"><br />
	<input class='loginsubmit' type="submit" name="submit" value="Sign In" />
</div>

<div class='separator'></div>
	
<div class='register'>
	<h2>Register</h2>
	<p>Don't have an account?</p>
	<p><a href='signuppage.php'>Register</a> a new account</p>
</div>
		
</div>	
</body>
</html>
