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

			global $mysqli;
                        /* Updating bets_matches:
				Changing the winner column and the status column
			*/
			if($stmt = $mysqli->prepare("UPDATE bets_matches SET winner=?, status='closed' WHERE ID=?")) {
				$stmt->bind_param("si", $_POST['winner'], $_POST['matchid']);
				$stmt->execute();
			}
			/* Updating user:
				Select betvalues and names from open bets in bets_money
				Refund betvalues to usernames in user
			*/
			if($stmt = $mysqli->prepare("SELECT `value`, `username 1` FROM bets_money WHERE (`match`=? AND `status`='open')")) {
				$stmt->bind_param("i", $_POST['matchid']);
				$stmt->execute();
				$refunds = Array();
				$stmt->bind_result($betvalues, $users);
                                while( $stmt->fetch() ) {
                                	$refunds[] = array( 'user' => $users, 'betvalue' => $betvalues);
                                }
			/* Calculate sum of user's bets for less mysql queries */
								$sum = array_reduce($refunds, function($result, $item) {
									if (!isset($result[$item['user']])) $result[$item['user']] = 0;
									$result[$item['user']] += $item['betvalue'];
									return $result;
								}, array());

			/* Refund betvalues to usernames in user */			
			foreach ($sum as $user => $value) {	
                                	if($stmt = $mysqli->prepare("UPDATE user SET points = points + ? WHERE username=?")) {
                                	$stmt->bind_param("is", $value, $user);
                                	$stmt->execute();
									/* test open bet refund */
                                	//echo "No challengers! Refunded ". $value ." FVBUX to ". $user ."'s points.<br>";
                                	}
                                }
			}
			/* Updating bets_money:
				Changing the winner column to username 1 where user1choice is the winner
			*/
			if($stmt = $mysqli->prepare("UPDATE bets_money SET `winner`=`username 1` WHERE (`user1choice`=? AND `match`=? AND `status`='locked')")) {
				$stmt->bind_param("si", $_POST['winner'], $_POST['matchid']);
				$stmt->execute();
			}
			/* Updating bets_matches:
				Changing the winner column to username 2 where user1choice is NOT the winner
			*/
			if($stmt = $mysqli->prepare("UPDATE bets_money SET `winner`=`username 2` WHERE (`match`=? AND `status`='locked') AND NOT (`user1choice`=?)")) {
				$stmt->bind_param("is",  $_POST['matchid'], $_POST['winner']);
				$stmt->execute();
			}
			/* Updating user:
				Select betvalues and names from winner column in bets_money
				Pay betvalues x2 to usernames in user
				Pay the mod 10 fvbux per completed bet
			*/
			if($stmt = $mysqli->prepare("SELECT `value`, `winner` FROM bets_money WHERE (`match`=? AND `status`='locked')")) {
				$stmt->bind_param("i", $_POST['matchid']);
				$stmt->execute();
				$results = Array();
				$stmt->bind_result($betvalues, $winners);
                                while( $stmt->fetch() ) {
                                	$results[] = array( 'winner' => $winners, 'betvalue' => $betvalues );
                                }
								
								/* Calculate sum of user's bets for less mysql queries */
								$sum = array_reduce($results, function($result, $item) {
									if (!isset($result[$item['winner']])) $result[$item['winner']] = 0;
									$result[$item['winner']] += $item['betvalue'];
									return $result;
								}, array());
								
                                foreach ($sum as $winner => $value) {
                                	if($stmt = $mysqli->prepare("UPDATE user SET points = points + (? * 2) WHERE username=?")) {
                                	$stmt->bind_param("is", $value, $winner);
                                	$stmt->execute();
									/* test winner */
                                	//echo $winner ." won ". ($value * 2) ." FVBUX for betting on ". $_POST['winner'] ."!<br>";
                                    }
                                }

                                $modcut = (count($results) * 10);
                                if($stmt = $mysqli->prepare("UPDATE user SET points = points + ? WHERE username=?")) {
                               	$stmt->bind_param("is", $modcut, $mod);
                               	$stmt->execute();
								/* test mod reward */
								//echo $mod ." rewarded ". $modcut ." FVBUX for moderating!<br>";
                                }
			}
			/* Updating bets_money:
				Changing the status column to closed in rows with the right match id
			*/
			if($stmt = $mysqli->prepare("UPDATE `bets_money` SET `status`='closed' WHERE `match`=?")) {
				$stmt->bind_param("i", $_POST['matchid']);
				$stmt->execute();
                        }

		}

	}
header('Location:bets.php?mid='.$_POST['matchid']);
}

?>
