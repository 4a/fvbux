<?php
require('connect.php');

/* $IPBYPASS is used to get around the ip check so you are able to test bet creation locally */
$IPBYPASS = TRUE;

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

function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;
 
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
 
	return ($miles ? ($km * 0.621371192) : $km);
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
	$input1 = strip_tags($input1);
	$input2 = strip_tags($input2);
	$event = strip_tags($event);
	$description = strip_tags($description);
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

function matchTimeout() {
global $mysqli;
/* select match id's from open or locked matches older than 1 day */
if($stmt = $mysqli->prepare("SELECT `ID` FROM `bets_matches` WHERE (`status` = 'open' OR `status` = 'locked') AND `timestamp` < now() - interval 1 day")) {
	$stmt->execute();
	$matchNos = array();
	$stmt->bind_result($matchNo);

	while ( $stmt->fetch() ) {
		$matchNos[] = $matchNo;
	}

	foreach($matchNos as $id) {
	/* Change status of bets_matches to 'timeout' */
		if($stmt1 = $mysqli->prepare("UPDATE `bets_matches` SET `status` = 'timeout' WHERE `ID` = ?")) {
			$stmt1->bind_param("i", $id);
			$stmt1->execute();
		} else {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
	/* Select bet values and names from bets_money  */
		if($stmt = $mysqli->prepare("SELECT `value`, `username 1`, `username 2` FROM bets_money WHERE `match`=?")) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$refunds = Array();
			$stmt->bind_result($betvalues, $user1, $user2);
			
			while( $stmt->fetch() ) {
				$refunds[] = array( 'user1' => $user1, 'user2' => $user2, 'betvalue' => $betvalues);
			}
	/* Calculate sum of user's bets for less mysql queries */
			$sum = array_reduce($refunds, function($result, $item) {
				if (!isset($result[$item['user1']])) $result[$item['user1']] = 0;
				if (!isset($result[$item['user2']])) $result[$item['user2']] = 0;
				$result[$item['user1']] += $item['betvalue'];
				$result[$item['user2']] += $item['betvalue'];
				return $result;
			}, array());

	/* Refund betvalues to usernames in user */			
			foreach ($sum as $user => $value) {					
			if(!empty($user) && $stmt = $mysqli->prepare("UPDATE user SET `points` = points + ? WHERE `username`=?")) {
				$stmt->bind_param("is", $value, $user);
				$stmt->execute();
				echo $user ." refunded ". $value ." FVBUX.<br>";
				}
			}			
		}
		
	/* Change status of any bets that are linked to that match to 'timeout' */ 		
		if($stmt2 = $mysqli->prepare("UPDATE `bets_money` SET `status`='timeout' WHERE `match`=?")) {
			$stmt2->bind_param("i", $id);
			$stmt2->execute();
		} else {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}	
	}

	}
}
?>