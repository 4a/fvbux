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

/*
If the bets_matches table gets more colums then this class needs to be updated accordingly
Assuming new column is needed:
1. Needs its own private variable
2. Needs the result bound to another variable and added to the private variable
3. Needs a get public get method added so you can access the variable
*/
class MatchInfo {

	private $MatchID;
	private $Input1;
	private $Input2;
	private $Mod;
	private $ModIP;
	
	function __construct($mid) {
		$this->MatchID = $mid;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM bets_matches WHERE ID=?")) {
			$stmt->bind_param("i", $this->MatchID);
			$stmt->execute();
			$stmt->bind_result($matchid, $input1, $input2, $mod, $modip);
			$stmt->fetch();
			
			$this->MatchID = $matchid;
			$this->Input1 = $input1;
			$this->Input2 = $input2;
			$this->Mod = $mod;
			$this->ModIP = $modip;
		}
	}
	
	public function getMatchID() { return $this->MatchID; }
	public function getInput1() { return $this->Input1; }
	public function getInput2() { return $this->Input2; }
	public function getMod() { return $this->Mod; }
	public function getModIP() { return $this->ModIP; }
}
?>