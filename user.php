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
        <div id='user-menu'>$_SESSION[name] ($totalpoints) <img src='IS/menu_open.png' /><br>$_SESSION[level]  <a href='PHP/signout.php'>Log Out</a></div> <img id='user-avatar' src='$gravurl' alt='Gravatar' /> </div>";}
