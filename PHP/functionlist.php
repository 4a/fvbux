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

function minusPoints($value, $user) {
	global $mysqli;
	if($stmt = $mysqli->prepare("UPDATE user SET points = points - ? WHERE username = ?")) {
		$stmt->bind_param("is", $value, $user);
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

function createBet($match, $user, $value, $ip, $private = 0, $user1choice) {
	global $mysqli;
	$betID;
	$status = "open";
	if($stmt = $mysqli->prepare("INSERT INTO bets_money (`match`, `username 1`, `value`, `IP`, `status`, `private`, `user1choice`) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
		$stmt->bind_param("isiisis", $match, $user, $value, $ip, $status, $private, $user1choice);
		$stmt->execute();
		$betID = $stmt->insert_id;
	}
	$value = $value * -1;
	updatePoints($value, $user);
	return $betID;
}

function challengeBet($betid, $user, $value) {
	global $mysqli;
	$status = "locked";
	if($stmt = $mysqli->prepare("UPDATE bets_money SET `username 2`=?, `status`=? WHERE (`ID`=? AND `status`='open') ")) {
		$stmt->bind_param("ssi", $user, $status, $betid);
		$stmt->execute();
                $affectedrows = $stmt->affected_rows;
	}
	if ($affectedrows > 0){
                $value = $value * -1;
	        updatePoints($value, $user);
        }
	return $status;
}

function checkPoints($user, $betamount) {
	global $mysqli;
	if($stmt = $mysqli->prepare("SELECT points FROM user WHERE username = ?")) {
		$stmt->bind_param("s", $user);
		$stmt->execute();
		$stmt->bind_result($userpoints);
		$stmt->fetch();
		
		if($userpoints >= $betamount) {
			return true;
		} else {
			return false;
		}
	}
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
	private $Status;
	private $Winner;
	
	function __construct($mid) {
		$this->MatchID = $mid;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM bets_matches WHERE ID=?")) {
			$stmt->bind_param("i", $this->MatchID);
			$stmt->execute();
			$stmt->bind_result($matchid, $input1, $input2, $mod, $modip, $status, $winner);
			$stmt->fetch();
			
			$this->MatchID = $matchid;
			$this->Input1 = $input1;
			$this->Input2 = $input2;
			$this->Mod = $mod;
			$this->ModIP = $modip;
			$this->Status = $status;
			$this->Winner = $winner;
		}
	}
	
	public function getMatchID() { return $this->MatchID; }
	public function getInput1() { return $this->Input1; }
	public function getInput2() { return $this->Input2; }
	public function getMod() { return $this->Mod; }
	public function getModIP() { return $this->ModIP; }
	public function getStatus() { return $this->Status; }
	public function getWinner() { return $this->Winner; }
}

class BetInfo {

	private $BetID;
	private $MatchID;
	private $User1;
	private $User2;
	private $BetValue;
	private $Odds;
	private $User1IP;
	private $Status;
	private $isPrivate;
	private $User1Choice;
	
	function __construct($betID) {
		$this->BetID = $betID;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM bets_money WHERE ID=?")) {
			$stmt->bind_param("i", $this->BetID);
			$stmt->execute();
			$stmt->bind_result($this->BetID, $this->MatchID, $this->User1, $this->User2, $this->BetValue,
										$this->Odds, $this->User1IP, $this->Status, $this->isPrivate, $this->User1Choice);
			$stmt->fetch();
		}
	}
	
	public function getBetID() { return $this->BetID; }
	public function getMatchID() { return $this->MatchID; }
	public function getUser1() { return $this->User1; }
	public function getUser2() { return $this->User2; }
	public function getBetValue() { return $this->BetValue; }
	public function getOdds() { return $this->Odds; }
	public function getUser1IP() { return $this->User1IP; }
	public function getStatus() { return $this->Status; }
	public function isPrivate() { return $this->isPrivate; }
	public function getUser1Choice() { return $this->User1Choice; }
}
?>
