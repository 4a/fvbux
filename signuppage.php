<?php
session_start();
if(isset($_SESSION['loggedin'])) {
  header('Location: players.php');
}

require('PHP/connect.php');
require('PHP/PasswordHash.php');

$erruser = "";
$errpass = "";
if(array_key_exists('submit',$_POST)) {
	$validated = true;

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(preg_match("/^[A-Za-z0-9_-]{3,16}$/", $username) === 0) {
		$erruser = "Username must be 3-16 characters long and only contain alphanumeric characters, '_' and '-'";
		$validated = false;
	}
	
	if(preg_match("/^.{6,}$/", $password) === 0) {
		$errpass = "Password must be at least 6 characters";
		$validated = false;
	}
	
	if($stmt = $mysqli->prepare("SELECT COUNT(username) FROM user WHERE username=?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
	} else {
		echo "Database connection error; could not complete sign ip: (" . $mysqli->errno . ") " . $mysqli->error;
		$validated = false;
	}
	
	if($count > 0) {
		$erruser = "Username already exists";
		$validated = false;
	}
	
	if($validated) {
		$Hasher = new PasswordHash(8, FALSE);

		$hash = $Hasher->HashPassword($password);
		echo "Hash: " . $hash . "<br />";

		$check = $Hasher->CheckPassword($password, $hash);
		if($check) {
			echo "Check: " . $check . "<br />";
		}

		if(!($stmt = $mysqli->prepare("INSERT INTO user VALUES (?,?,?,?)"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		$id = null;
		$points = 100;
		if (!$stmt->bind_param("issi", $id, $username, $hash, $points)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$_SESSION["loggedin"] = "yes";
		$_SESSION['name'] = $username;
		header('Location:players.php');
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
Sign Up:
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
Username: <input type="text" name="username" > <?php if($erruser != "") { echo $erruser; } ?><br />
Password: <input type="password" name="password" > <?php if($errpass != "") { echo $errpass; } ?><br />
<input type="submit" name="submit" value="Submit" />

</form>
</body>
</html>
