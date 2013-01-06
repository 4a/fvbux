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
		header('Location: ../players.php');
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
<link rel="shortcut icon" href="../FV.ico" >
<link rel="stylesheet" type="text/css" href="../CSS/newfightan.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
#user
{
  display:block;
  position:fixed;
  top:15px;
  right:30px;
}
#fvbux
{
  display:block;
  text-align:center;
}
#create
{
  text-align:center;
}
</style>
</head>
<body>
<?php
include 'menu.php';
?>
<?php if($errlogin != "") { echo "<div style='color:red'>$errlogin</div><br />"; } ?>
Sign in:
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
Username: <input type="text" name="username" ><br />
Password: <input type="password" name="password" ><br />
<input type="submit" name="submit" value="Submit" />
</body>
</html>
