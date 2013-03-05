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

function doesUserExist($username) {
	global $mysqli;
	if($stmt = $mysqli->prepare("SELECT username FROM user WHERE username = ?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($user);
		$stmt->fetch();
		
		if(isset($user)) {
			return true;
		} else {
			return false;
		}
	}
}

function updateProfile($uid, $gravemail, $location, $lat, $long, $GGPO, $LIVE, $PSN) {
	global $mysqli;
	if($stmt = $mysqli->prepare("REPLACE INTO `user_meta` (`uid`, `gravemail`, `location`, `lat`, `long`, `GGPO`, `LIVE`, `PSN`) VALUES (?,?,?,?,?,?,?,?)")) {
		$stmt->bind_param("sssddsss", $uid, $gravemail, $location, $lat, $long, $GGPO, $LIVE, $PSN);
		$stmt->execute();
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

function createMatch($input1, $input2, $user, $ip, $event, $description, $featured, $img1, $img2) {
	global $mysqli;
	$matchID;
	if($stmt = $mysqli->prepare("INSERT INTO bets_matches (`Input 1`, `Input 2`, `Mod`, `IP`, `Event`, `Description`, `isfeatured`, `img1`, `img2`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
		$stmt->bind_param("sssisssss", $input1, $input2, $user, $ip, $event, $description, $featured, $img1, $img2);
		$stmt->execute();
		$matchID = $stmt->insert_id;
	}
	return $matchID;
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

function daysToSeconds($days) {
	return 86400 * $days;
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
	private $Timestamp;
	private $Event;
	private $Description;
	private $isFeatured;
	private $Img1;
	private $Img2;
	
	function __construct($mid) {
		$this->MatchID = $mid;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM bets_matches WHERE ID=?")) {
			$stmt->bind_param("i", $this->MatchID);
			$stmt->execute();
			$stmt->bind_result($matchid, $input1, $input2, $mod, $modip, $status, $winner, $timestamp, $event, $description, $isfeatured, $img1, $img2);
			$stmt->fetch();
			
			$this->MatchID = $matchid;
			$this->Input1 = $input1;
			$this->Input2 = $input2;
			$this->Mod = $mod;
			$this->ModIP = $modip;
			$this->Status = $status;
			$this->Winner = $winner;
			$this->Timestamp = $timestamp;
			$this->Event = $event;
			$this->Description = $description;
			$this->isFeatured = $isfeatured;
			$this->Img1 = $img1;
			$this->Img2 = $img2;
		}
	}
	
	public function getMatchID() { return $this->MatchID; }
	public function getInput1() { return $this->Input1; }
	public function getInput2() { return $this->Input2; }
	public function getMod() { return $this->Mod; }
	public function getModIP() { return $this->ModIP; }
	public function getStatus() { return $this->Status; }
	public function getWinner() { return $this->Winner; }
	public function getTimestamp() { return $this->Timestamp; }
	public function getEvent() { return $this->Event; }
	public function getDescription() { return $this->Description; }
	public function getFeatured() { return $this->isFeatured; }
	public function getImg1() { return $this->Img1; }
	public function getImg2() { return $this->Img2; }
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
	private $BetWinner;
	
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
										$this->Odds, $this->User1IP, $this->Status, $this->isPrivate, $this->User1Choice, $this->BetWinner);
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
	public function getBetWinner() { return $this->BetWinner; }
}

class UserInfo {
	
	private $UserID;
	private $Username;
	private $Password;
	private $Points;
	private $Email;
	private $AccountLevel;
	
		function __construct($username) {
		$this->Username = $username;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM user WHERE username=?")) {
			$stmt->bind_param("s", $this->Username);
			$stmt->execute();
			$stmt->bind_result($this->UserID, $this->Username, $this->Password, $this->Points, $this->Email,
										$this->AccountLevel);
			$stmt->fetch();
		}
	}
	
	public function getUserID() { return $this->UserID; }
	public function getUsername() { return $this->Username; }
	public function getPassword() { return $this->Password; }
	public function getPoints() { return $this->Points; }
	public function getEmail() { return $this->Email; }
	public function getAccountLevel() { return $this->AccountLevel; }
}

class UserMetaInfo {
	
	private $MetaID;
	private $UserID;
	private $GravEmail;
	private $Location;
	private $Latitude;
	private $Longitude;
	private $GGPO;
	private $LIVE;
	private $PSN;
	
		function __construct($uid) {
		$this->UserID = $uid;
		$this->getInfo();
	}
	
	private function getInfo() {
		global $mysqli;
		if($stmt = $mysqli->prepare("SELECT * FROM user_meta WHERE uid=?")) {
			$stmt->bind_param("s", $this->UserID);
			$stmt->execute();
			$stmt->bind_result($this->UserID, $this->GravEmail, $this->Location, $this->Latitude,
										$this->Longitude, $this->GGPO, $this->LIVE, $this->PSN);
			$stmt->fetch();
		}
	}
	
//	public function getMetaID() { return $this->MetaID; }
	public function getUserID() { return $this->UserID; }
	public function getGravEmail() { return $this->GravEmail; }
	public function getLocation() { return $this->Location; }
	public function getLatitude() { return $this->Latitude; }
	public function getLongitude() { return $this->Longitude; }
	public function getGGPO() { return $this->GGPO; }
	public function getLIVE() { return $this->LIVE; }
	public function getPSN() { return $this->PSN; }
}
?>