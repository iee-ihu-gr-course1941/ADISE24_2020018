<?php

function show_status() {
    global $mysqli;

    check_abort();
	
	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);

	$st->execute();
	$res = $st->get_result();

	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function check_abort() {
	global $mysqli;
	
	$sql = "UPDATE game_status SET status = 'aborted', p_turn = NULL 
            WHERE p_turn IS NOT NULL AND last_change < (NOW() - INTERVAL 5 MINUTE) AND status = 'started'";
	$st = $mysqli->prepare($sql);
	$r = $st->execute();
}


function show_game_data(){
    global $mysqli;
    $sql = "SELECT p.username, p.score, (SELECT COUNT(*) FROM player_tiles pt WHERE pt.username = p.username) AS tile_count
                                        FROM players p
                                        WHERE p.username IS NOT NULL
                                        LIMIT 2";

    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();

    header('Content-type: application/json');
    echo json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function update_game_status() {
    global $mysqli;

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
    $sql= "SELECT count(*) as aborted FROM players WHERE last_action < (NOW() - INTERVAL 5 MINUTE)";
    $st3 = $mysqli->prepare($sql);
    $st3->execute();

    $res3 = $st3->get_result();
    $aborted = $res3->fetch_assoc()['aborted'];
    
    if ($aborted > 0) {
        // Απομάκρυνση ανενεργών παικτών και πλακιδίων
        $sql = "DELETE FROM player_tiles WHERE username IN (SELECT username 
                                                            FROM players 
                                                            WHERE last_action < (NOW() - INTERVAL 5 MINUTE));";
        $st2 = $mysqli->prepare($sql);
        $st2->execute();


        $sql = "UPDATE players SET username = NULL, token = NULL WHERE last_action < (NOW() - INTERVAL 5 MINUTE)";
        $st3 = $mysqli->prepare($sql);
        $st3->execute();

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


            // Επαναφορά του board
            $sql = 'call clean_board()';
		    $mysqli->query($sql);

            // Επαναφορά του tile_pool
            $sql = 'CALL reset_tile_pool()';
            $st = $mysqli->prepare($sql);
            $st->execute();
     		
            // Μοίρασμα πλακιδίων
            $sql = 'CALL DistributeTilesToPlayersByUsername2(?, ?)';
            $st = $mysqli->prepare($sql);
            $st->bind_param('ss', $player1_username, $player2_username); 
            $st->execute();               


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


function switch_player_turn($token) {
    // Βρίσκουμε το username του παίκτη από το token
    $player_username = current_user($token);

    if ($player_username == null) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "You are not a player of this game."]);
        exit;
    }

    global $mysqli;

    // Βρίσκουμε το game_id από τον πίνακα game_status
    $sql = 'SELECT game_id FROM game_status WHERE p_turn = ?';
    $st = $mysqli->prepare($sql);
    $st->bind_param("s", $player_username);
    $st->execute();
    $res = $st->get_result();

    if ($res->num_rows == 0) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "Game not found or it's not your turn."]);
        exit;
    }

    $row = $res->fetch_assoc();
    $game_id = $row['game_id'];

    // Βρίσκουμε τον αντίπαλο παίκτη
    $sql = 'SELECT username FROM players WHERE username != ?';
    $st = $mysqli->prepare($sql);
    $st->bind_param("s", $player_username);
    $st->execute();
    $res = $st->get_result();
    $next_player = $res->fetch_assoc()['username'];
 
    if ($next_player == null) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "Could not determine the next player."]);
        exit;
    }
 
    $sql = 'UPDATE game_status SET p_turn = ? WHERE game_id = ?';
    $st = $mysqli->prepare($sql);
    $st->bind_param("si", $next_player, $game_id);
    $st->execute();

    header('Content-type: application/json');
    print json_encode(['success' => "Turn updated"]);
    //header("HTTP/1.1 200 OK");
    //print json_encode(['successmesg' => "  "]);
    //exit;
}



?>