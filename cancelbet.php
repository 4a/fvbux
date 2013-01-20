<?php
session_start();
require('PHP/connect.php');
require('PHP/functionlist.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$BetInfo = new BetInfo($_POST['betid']);
	$betstatus = $BetInfo->getStatus();
	
	if($betstatus == "open") {
		$betcreator = $BetInfo->getUser1();
		
		if($_SESSION['name'] == $betcreator) {
			global $mysqli;
			
			/* Refund user their points they bet with */
			$betvalue = $BetInfo->getBetValue();
			if($stmt = $mysqli->prepare("UPDATE user SET points = points + ? WHERE username = ?")) {
				$stmt->bind_param("is", $betvalue, $betcreator);
				$stmt->execute();
			}
			
			/* Delete row in bets_money of given bet ID */
			if($stmt = $mysqli->prepare("DELETE FROM bets_money WHERE ID = ?")) {
				$stmt->bind_param("i", $_POST['betid']);
				$stmt->execute();
			}
			
		}
	}
	
	header('Location: players.php');
}


?>