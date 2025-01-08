<?php

	function show_board() {
		global $mysqli;
		
		$sql = 'select * from board';
		$st = $mysqli->prepare($sql);
		$st->execute();
		$res = $st->get_result();
		header('Content-type: application/json');
		print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
	}

	function reset_board() {
		global $mysqli;
		
		$sql = 'call clean_board()';
		$mysqli->query($sql);
		show_board();
	}


	function place_tile_on_board($tile_color, $tile_shape, $x, $y, $token) {
		
		if ($token == null || $token == '') {
			header("HTTP/1.1 400 Bad Request1");
			print json_encode(['errormesg' => "Token is not set."]);
			exit;
		}
	
		
		// Παίρνουμε το player_username του παίκτη με βάση το token
		$player_username = current_user($token);

		if ($player_username == null) {
			header("HTTP/1.1 400 Bad Request2");
			print json_encode(['errormesg' => "You are not a player of this game."]);
			exit;
		}
		
		// Ελέγχουμε την κατάσταση του παιχνιδιού
		$status = read_status();

		if ($status['status'] != 'started') {
			header("HTTP/1.1 400 Bad Request3");
			print json_encode(['errormesg' => "Game is not in action."]);
			exit;
		}
	
		if ($status['p_turn'] != $player_username) {
			header("HTTP/1.1 400 Bad Request4");
			print json_encode(['errormesg' => "It is not your turn."]);
			exit;
		}

		do_move($player_username, $x, $y, $tile_color, $tile_shape);
		
	}

	function do_move($player_username1, $x1, $y1, $tile_color1, $tile_shape1) {
		try {
			global $mysqli;
			$sql = 'CALL place_tile2(?, ?, ?, ?, ?)';
			$st = $mysqli->prepare($sql);
			$st->bind_param('iiiss', $player_username1, $x1, $y1, $tile_color1, $tile_shape1);
			$st->execute();

			show_board();

		} catch (mysqli_sql_exception $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
			exit;
		}
	}

	/*
	function current_player_username($token) {
		global $mysqli;
	
		$sql = "SELECT username FROM players WHERE token = ?";
		$st = $mysqli->prepare($sql);
		$st->bind_param('s', $token);
		$st->execute();
		$res = $st->get_result();
	
		if ($row = $res->fetch_assoc()) {
			return $row['username'];
		}
		return null;
	}*/
		
	

?>

