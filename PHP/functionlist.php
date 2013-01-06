<?php
require('connect.php');

function getPoints($user) {
	global $mysqli;
	
	if($stmt = $mysqli->prepare("SELECT points FROM user WHERE username=?")) {
		$stmt->bind_param("s", $user);
		$stmt->execute();
		$stmt->bind_result($points);
		$stmt->fetch();
		return $points;
	}
}

function updatePoints($winnings, $user) {
	global $mysqli;
	if($stmt = $mysqli->prepare("UPDATE user SET points = points + ? WHERE username = ?")) {
		$stmt->bind_param("is", $winnings, $user);
		$stmt->execute();
	}
}

function createMatch($input1, $input2, $user, $ip) {
	global $mysqli;
	global $newID;
	if($stmt = $mysqli->prepare("INSERT INTO bets_matches (`Input 1`, `Input 2`, `Mod`, `IP`) VALUES (?, ?, ?, ?)")) {
		$stmt->bind_param("sssi", $input1, $input2, $user, $ip);
		$stmt->execute();
		$newID = $stmt->insert_id;
	}
}

function createBet($match, $user, $value, $ip) {
	global $mysqli;
	if($stmt = $mysqli->prepare("INSERT INTO bets_money (`match`, `username 1`, `value`, `IP`) VALUES (?, ?, ?, ?)")) {
		$stmt->bind_param("isii", $match, $user, $value, $ip);
		$stmt->execute();
	}
	updatePoints($value, $user);
}

function challengeBet($match, $user, $ip) {
	global $mysqli;
	if($stmt = $mysqli->prepare("UPDATE bets_money (`match`, `username 1`, `value`, `IP`) VALUES (?, ?, ?, ?)")) {
		$stmt->bind_param("sii", $user, $ip);
		$stmt->execute();
	}
	updatePoints($value, $user);
}
?>