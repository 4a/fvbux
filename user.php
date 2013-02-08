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
        <div id='user-menu'>
	<span>". $_SESSION['name'] ."<img src='IS/menu_open.png' /></span>
        	<div class='user-dropdown' style='display:none'>";
        if ($_SESSION['level'] === "admin") {
        echo "<div><a href='adminpanel.php'>Admin Panel</a></div>";}
        echo " 
        	<div><a href='noteventhubs.php'>Account Settings</a></div>
		<div><a href='players.php?user=". $_SESSION['name'] ."'>My Profile</a></div> 
        	<div><a href='PHP/signout.php'>Log Out</a></div>
        	</div>
        <br><span class='fvbux'>$</span>". $totalpoints ."&nbsp;	
        </div>	
        <a href='players.php?user=". $_SESSION['name'] ."'><img id='user-avatar' src='$gravurl' alt='Gravatar' /></a>
        </div>";
        
        echo "
	<script type='text/javascript'>
	$(document).ready(function () {
	$('#user-menu span').click(function () {
	//alert('test');
	$('.user-dropdown').toggle();
	});
	});
	</script>";

        } else {
        echo "
        <div id='user'>
        <div id='user-menu'><a href='signinpage.php'>Log In</a></div>
        </div>";
        }   