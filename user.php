<?php
include('PHP/TalkPHP_Gravatar.php');
if(isset($_SESSION['loggedin'])) {
	$totalpoints = getPoints($_SESSION['name']);	
	$Gravatar = new TalkPHP_Gravatar();
	$Gravatar->setEmail($_SESSION['email']);
	$Gravatar->setSize(40);
	$gravurl = $Gravatar->getAvatar();	
	echo "
        <div id='user'>
        $_SESSION[level]<br>
        <img src='$gravurl' alt='Gravatar' /> $_SESSION[name] ($totalpoints) <img src='IS/menu_open.png' /> | <a href='PHP/signout.php'>Log Out</a></div>";}
