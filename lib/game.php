<?php

function show_status() {
    global $mysqli;
	
	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);

	$st->execute();
	$res = $st->get_result();

	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function update_game_status() {
    global $mysqli;

    // Λήψη της τρέχουσας κατάστασης
    $sql = 'SELECT * FROM game_status';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $status = $res->fetch_assoc();

    if (!$status) {
        // Αν δεν υπάρχει εγγραφή στο game_status, δημιουργούμε μία
        $sql = 'INSERT INTO game_status (status) VALUES ("not active")';
        $mysqli->query($sql);
        $status = ['status' => 'not active', 'p_turn' => null];
    }

    $new_status = null;

    // Εύρεση παικτών που δεν είναι ενεργοί για πάνω από 5 λεπτά
    $st3 = $mysqli->prepare('SELECT count(*) as aborted FROM players WHERE last_action < (NOW() - INTERVAL 5 MINUTE)');
    $st3->execute();
    $res3 = $st3->get_result();
    $aborted = $res3->fetch_assoc()['aborted'];
    
    if ($aborted > 0) {
        // Απομάκρυνση ανενεργών παικτών
        $sql = "UPDATE players SET username = NULL, token = NULL WHERE last_action < (NOW() - INTERVAL 5 MINUTE)";
        $st2 = $mysqli->prepare($sql);
        $st2->execute();
        if ($status['status'] == 'started') {
            $new_status = 'aborted';
        }
    }

	
    // Έλεγχος ενεργών παικτών
    $sql = 'SELECT count(*) AS c FROM players WHERE username IS NOT NULL';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	$active_players = $res->fetch_assoc()['c'];

	// Ενημέρωση της κατάστασης με βάση τον αριθμό των ενεργών παικτών
	switch ($active_players) {
		case 0:
			$new_status = 'not active';
			break;
		case 1:
			$new_status = 'initialized';
			break;
		case 2:
			$new_status = 'started';
			
			// Βρίσκουμε τους 2 πρώτους ενεργούς παίκτες
			$sql = 'SELECT username FROM players WHERE username IS NOT NULL ORDER BY player_id ASC LIMIT 2';
            $st = $mysqli->prepare($sql);
            $st->execute();
            $res = $st->get_result();

            $player1 = $res->fetch_assoc();
            $player1_username = $player1['username'];

            $player2 = $res->fetch_assoc();
            $player2_username = $player2['username'];

            // Μοιρασμα πλακιδίων
            //$sql = 'CALL DistributeTilesToPlayersByUsername(?, ?)';
            //$st = $mysqli->prepare($sql);
            //$st->bind_param('ss', $player1_username, $player2_username); 
            //$st->execute();
			
			// Ορίζουμε τον πρώτον παίκτη για το p_turn
			$sql = 'UPDATE game_status SET p_turn = ? WHERE game_id = 3';
            $st = $mysqli->prepare($sql);
            $st->bind_param('s', $player1_username);
            $st->execute();
			break;
		default:
			$new_status = $status['status'];
			break;
	}

	$sql = 'UPDATE game_status SET status = ? WHERE game_id = 3';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s', $new_status);
	$st->execute();


	
/*
    // Ενημέρωση πίνακα `game_status`
    if ($new_status !== null && $new_status != $status['status']) {
        $sql = 'UPDATE game_status SET status = ? WHERE game_id = 1';
        $st = $mysqli->prepare($sql);
        $st->bind_param('s', $new_status);
        $st->execute();
    }*/
}


function read_status() {
    global $mysqli;

    $sql = 'SELECT * FROM game_status';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $status = $res->fetch_assoc();
    return $status;
}

?>