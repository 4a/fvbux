<?php
session_start();
require('PHP/connect.php');
require('PHP/functionlist.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$Match = new MatchInfo($_POST['matchid']);
	$mod = $Match->getMod();

	if($_SESSION['name'] == $mod) {
		$status = $Match->getStatus();

		if($status == "open" || $status == "locked") {
			/* Updating bets_matches:
				Changing the winner column and the status column
			*/
			global $mysqli;
			if($stmt = $mysqli->prepare("UPDATE bets_matches SET winner=?, status='closed' WHERE ID=?") {
				$stmt->bind_param("si", $_POST['winner'], $_POST['matchid']);
				$stmt->execute();
			}

		}

	}

}

?>