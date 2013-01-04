<?php
session_start();
require('PHP/functionlist.php');
$totalpoints = getPoints($_SESSION['name']);
$IP = $_SERVER['REMOTE_ADDR'];
$IP = ip2long($IP);
if(array_key_exists('submit',$_POST)) {
        $input1 = $_POST['input1'];
  $input2 = $_POST['input2'];
	createMatch($input1, $input2, $_SESSION['name'], $IP);
	header('Location:bets.php?mid='.$newID);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<title>Fightan' /v/idya</title>
<link rel="shortcut icon" href="FV.ico" >
<link rel="stylesheet" type="text/css" href="CSS/newfightan.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
body
{
  text-align:center;
}

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
<?php
if(isset($_SESSION['loggedin'])) {
        updatePoints(1, $_SESSION['name']);
        echo "<div id='user'>$_SESSION[name] ($totalpoints) <img src='IS/menu_open.png' /> | <a href='PHP/signout.php'>Log Out</a></div>";

	if(isset($_GET['mid'])) {
             $match_ID = $_GET['mid'];
             $result = $mysqli->query("SELECT * FROM `bets_matches` WHERE `ID`=$match_ID");
                  $row = $result->fetch_array(MYSQLI_ASSOC);
             if($row['ID'] === $match_ID) {
                  if ($_SESSION['name'] === $row['Mod']) {
                       echo "You are the moderator";
                  }
                  else if ($IP == $row['IP']) {
                       echo "You have the same IP as the moderator";
                  } else {
                       echo $row['Input 1'] .$row['Input 2'] .$row['Mod']
                       ."<br />some input boxes for bets?";
                  }
             } else {
             echo "Error: Match does not exist in database.";
             }
        } else {
             echo "
             <form action='$_SERVER[PHP_SELF]' method='post'>
             <input type='text' name='input1'><br />
             VS<br />
             <input type='text' name='input2'><br />
             <input type='submit' name='submit' value='Submit' />";
        }
} else {
	echo "<a href='signuppage.php'>Register</a><br/>";
	echo "<a href='signinpage.php'>Log In</a>";
}
?>

</body>
</html>
