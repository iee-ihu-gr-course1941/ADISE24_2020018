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

	function show_players_tiles() {
		global $mysqli;
		
		$sql = 'SELECT username, tile_color, tile_shape FROM player_tiles';
		$st = $mysqli->prepare($sql);
		$st->execute();
		$res = $st->get_result();
		header('Content-type: application/json');
		print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
	}
	
	

	function place_tile_on_board($tile_color, $tile_shape, $x, $y, $token) {
		
		if ($token == null || $token == '') {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "Το Token δεν έχει οριστεί."]);
			exit;
		}
	
		$player_username = current_user($token);

		if ($player_username == null) {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "Δεν ανήκεις στο παιχνίδι."]);
			exit;
		}
		
		$status = read_status();

		if ($status['status'] != 'started') {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "Το παιχνίδι δεν έχει ξεκινήσει."]);
			exit;
		}
	
		if ($status['p_turn'] != $player_username) {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "Δεν είναι η σειρά σου."]);
			exit;
		}

		do_move($player_username, $x, $y, $tile_color, $tile_shape);
		
	}

	function do_move($player_username1, $x1, $y1, $tile_color1, $tile_shape1) {

		$orig_board = read_board();
        $board = convert_board($orig_board);

		$result_code = is_valid_move($board, $x1, $y1, $tile_color1, $tile_shape1, $player_username1);

		switch ($result_code) {
			case 1:
				header("HTTP/1.1 400 Bad Request");
				print json_encode(['errormesg' => "Το πλακίδιο δεν ανήκει στον χρήστη."]);
				exit;
			case 2:
				header("HTTP/1.1 400 Bad Request");
				print json_encode(['errormesg' => "Η θέση είναι ήδη κατειλημμένη."]);
				exit;
			case 3:
				header("HTTP/1.1 400 Bad Request");
				print json_encode(['errormesg' => "Η κίνηση δεν είναι έγκυρη."]);
				exit;
			case 0:
				global $mysqli;
				$sql = 'CALL place_tile3(?, ?, ?, ?, ?)';
				$st = $mysqli->prepare($sql);
				$st->bind_param('siiss', $player_username1, $x1, $y1, $tile_color1, $tile_shape1);
				$st->execute();

				
				// Υπολογισμός πόντων
				$points = calculate_points($board, $x1, $y1, $tile_color1, $tile_shape1);

				// Ενημέρωση της βαθμολογίας του παίκτη
				$sql = 'UPDATE players SET score = score + ? WHERE username = ?';
				$st = $mysqli->prepare($sql);
				$st->bind_param('is', $points, $player_username1);
				$st->execute();
				

				show_board();
				exit;
		}
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "Κάτι πήγε λάθος στην 'do_move'."]);
		exit;
	}	


	function is_valid_move($board, $x, $y, $tile_color, $tile_shape, $player_username) {

		global $mysqli;

		// Έλεγχος αν το πλακίδιο ανήκει στον χρήστη
		$sql_select = 'SELECT tile_color, tile_shape 
                	FROM player_tiles 
                    WHERE username = ? AND tile_color = ? AND tile_shape = ? 
                    LIMIT 1';
		$st = $mysqli->prepare($sql_select);
		$st->bind_param('sss', $player_username, $tile_color, $tile_shape);
		$st->execute();
		$res = $st->get_result();

		if ($res->num_rows === 0) {
			return 1;
		}

		// Έλενχος αν η θέση είναι κενή
		if ($board[$x][$y]['tile_color'] !== null || $board[$x][$y]['tile_shape'] !== null) {
			return 2;
		}
		
		// Έλεγχος αν είναι η πρώτη κίνηση
		$is_first_move = is_first_move();
		if ($is_first_move) {
			return 0;
		}
	
		// Ελέγξτε τους γειτονικούς συνδυασμούς
		$directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];
		$valid = 3;

		foreach ($directions as [$dx, $dy]) {
			$nx = $x + $dx;
			$ny = $y + $dy;

			if (isset($board[$nx][$ny])) {
				$neighbor_color = $board[$nx][$ny]['tile_color'];
				$neighbor_shape = $board[$nx][$ny]['tile_shape'];

				if ($neighbor_color !== null && $neighbor_shape !== null) {
				
					if ($neighbor_color === $tile_color && $neighbor_shape === $tile_shape) {
						return 3;
					}

					if ($neighbor_color === $tile_color || $neighbor_shape === $tile_shape) {
						$valid = 0;
					} else {
						return 3;
					}
				}
			}
		}
		return $valid;
	}


	function calculate_points($board, $x, $y, $tile_color, $tile_shape) {
		$points = 0;
		$directions = [[0, 1], [1, 0]];
		$total_lines = 0;
		$has_neighbors = false;

		foreach ($directions as [$dx, $dy]) {
			$line_points = 1;
			$line_complete = true;

			for ($nx = $x + $dx, $ny = $y + $dy; isset($board[$nx][$ny]); $nx += $dx, $ny += $dy) {
				$neighbor_tile = $board[$nx][$ny];
				if ($neighbor_tile['tile_color'] === null || $neighbor_tile['tile_shape'] === null
				) { 
					break;
				}

				$has_neighbors = true;
				if ($neighbor_tile['tile_color'] === $tile_color || $neighbor_tile['tile_shape'] === $tile_shape
				) {
					$line_points++;
				} else {
					$line_complete = false;
					break;
				}
			}

			for ($nx = $x - $dx, $ny = $y - $dy; isset($board[$nx][$ny]); $nx -= $dx, $ny -= $dy) {
				$neighbor_tile = $board[$nx][$ny];
				if ($neighbor_tile['tile_color'] === null ||   $neighbor_tile['tile_shape'] === null
				) { 
					break;
				}

				$has_neighbors = true;
				if (
					$neighbor_tile['tile_color'] === $tile_color || 
					$neighbor_tile['tile_shape'] === $tile_shape
				) {
					$line_points++;
				} else {
					$line_complete = false;
					break;
				}
			}

			if ($line_points > 1) {
				$points += $line_points;
				$total_lines++;
			}

			if ($line_points === 6 && $line_complete) {
				$points += 6;
			}
		}

		if (!$has_neighbors) {
			$points = 1;
		} else {
			if ($total_lines > 1) {
				$points -= ($total_lines - 1);
			}
		}

		return $points;
	}

	
	function convert_board(&$orig_board) {
		$board = [];
		foreach ($orig_board as $row) {
			$board[$row['x']][$row['y']] = [
				'tile_color' => $row['tile_color'],
				'tile_shape' => $row['tile_shape'],
			];
		}
		return $board;
	}

	function read_board() {
		global $mysqli;
		$sql = 'select * from board';
		$st = $mysqli->prepare($sql);
		$st->execute();
		$res = $st->get_result();
		return($res->fetch_all(MYSQLI_ASSOC));
	}

	function is_first_move() {
		global $mysqli;
	
		$sql = 'SELECT COUNT(*) as cnt 
				FROM board 
				WHERE tile_color IS NOT NULL OR tile_shape IS NOT NULL';
		$st = $mysqli->prepare($sql);
		$st->execute();
		$res = $st->get_result();
		$row = $res->fetch_assoc();
	
		return ($row['cnt'] == 0);
	}


	function change_tiles($token, $tile_numbers) {

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


		global $mysqli;
		try {
			$tile_numbers_reverse = array_reverse($tile_numbers);
			// Αφαίρεση των πλακιδίων από τον player_tiles και μεταφορά στον tiles_pool
			foreach ($tile_numbers_reverse as $tile_position) {
				// Βρίσκουμε το πλακίδιο από τον player_tiles
				$sql_select = 'SELECT tile_color, tile_shape 
							   FROM player_tiles 
							   WHERE username = ? 
							   LIMIT 1 OFFSET ?';
				$st = $mysqli->prepare($sql_select);
				$tile_offset = $tile_position - 1;
				$st->bind_param('si', $player_username, $tile_offset);
				$st->execute();
				$res = $st->get_result();
				$tile = $res->fetch_assoc();

				// Διαγραφή από τον player_tiles
				$sql_delete = 'DELETE FROM player_tiles 
							   WHERE username = ? 
							   AND tile_color = ? 
							   AND tile_shape = ? 
							   LIMIT 1';
				$st1 = $mysqli->prepare($sql_delete);
				$st1->bind_param('sss', $player_username, $tile['tile_color'], $tile['tile_shape']);
				$st1->execute();

				// Εισαγωγή στον tiles_pool
				$sql_insert = 'INSERT INTO tiles_pool (tile_color, tile_shape) 
							   VALUES (?, ?)';
				$st1 = $mysqli->prepare($sql_insert);
				$st1->bind_param('ss', $tile['tile_color'], $tile['tile_shape']);
				$st1->execute();
				
			}

			$tiles_to_add = count($tile_numbers);

			// Κλήση της συνάρτησης refill_tiles για τυχαία επιλογή πλακιδίων
			$sql_random_tiles = "CALL refill_tiles2(?, ?)";
			$stmt = $mysqli->prepare($sql_random_tiles);
			$stmt->bind_param('si', $player_username, $tiles_to_add);
			$stmt->execute();

			header("HTTP/1.1 200 OK");
			print json_encode(['successmesg' => "Η αλλαγή των πλακιδίων έγινε με επιτυχία"]);
			exit;

		} catch (Exception $e) {
			header('HTTP/1.1 500 Internal Server Error2233');
			return ['errormesg' => $e->getMessage()];
		}
	}
	

?>

