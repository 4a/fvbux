<?php
session_start();
if(isset($_SESSION['loggedin'])) {
	header('Location: players.php');
}

require('PHP/connect.php');
require('PHP/PasswordHash.php');

$errmail = "";
$erruser = "";
$errpass = "";
if(array_key_exists('submit',$_POST)) {
	$validated = true;

	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	if(preg_match("/^[A-Za-z0-9_-]{3,16}$/", $username) === 0) {
		$erruser = "Username must be 3-16 characters long and only contain alphanumeric characters, '_' and '-'";
		$validated = false;
	}
	
	if(preg_match("/^.{6,}$/", $password) === 0) {
		$errpass = "Password must be at least 6 characters";
		$validated = false;
	}

        if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email) === 0) {
		$errmail = "You must enter a valid e-mail address (name@domain.tld)";
		$validated = false;
	}

	if($stmt = $mysqli->prepare("SELECT COUNT(username) FROM user WHERE username=?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
	} else {
		echo "Database connection error; could not complete sign up: (" . $mysqli->errno . ") " . $mysqli->error;
		$validated = false;
	}
	
	if($count > 0) {
		$erruser = "Username already exists";
		$validated = false;
	}
	
	if($stmt = $mysqli->prepare("SELECT COUNT(email) FROM user WHERE email=?")) {
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
	} else {
		echo "Database connection error; could not complete sign up: (" . $mysqli->errno . ") " . $mysqli->error;
		$validated = false;
	}
	
	if($count > 0) {
		$errmail = "A username has already been registered with this e-mail. Reset password?";
		$validated = false;
	}

	if($validated) {
		$Hasher = new PasswordHash(8, FALSE);

		$hash = $Hasher->HashPassword($password);

		if(!($stmt = $mysqli->prepare("INSERT INTO user VALUES (?,?,?,?,?,?)"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		$id = null;
		$points = 100;
		$acclevel = "user";
		if (!$stmt->bind_param("ississ", $id, $username, $hash, $points, $email, $acclevel)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}	
		
		$id = $stmt->insert_id;
		if(($stmt = $mysqli->prepare("INSERT INTO user_meta (uid, gravemail) VALUES (?,?)"))) {
			$stmt->bind_param("is", $id, $email);
			$stmt->execute();
		}	
		
		$_SESSION["loggedin"] = "yes";
		$_SESSION['name'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['level'] = "user";
		header('Location:players.php');
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
</head>
<body>
<?php
include 'menu.php';
?>
<div class='signup'>
     <h2>Register an account</h2>

     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
     <div>E-mail</div>
     <input type="text" name="email" class="textinput">  
     <?php if($errmail != "") { echo "<div class='error'>" .  $errmail . "</div>"; } ?><br />

     <div>Username</div>
     <input type="text" name="username" class="textinput"> 
     <?php if($erruser != "") { echo "<div class='error'>" .  $erruser . "</div>"; } ?><br />
     
     <div>Password</div>
     <input type="password" name="password" class="textinput">
     <?php if($errpass != "") { echo "<div class='error'>" . $errpass . "</div>"; } ?><br />
     <input type="submit" name="submit" value="Submit" />
     </form>
</div>
</body>
</html>