<?php


	function show_users() {
		global $mysqli;
		$sql = 'SELECT * FROM players';
		$st = $mysqli->prepare($sql);
		$st->execute();

		$res = $st->get_result();

		header('Content-type: application/json');
		print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
	}


	function set_user($input) {
		if (!isset($input['username']) || $input['username'] == '') {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "No username given."]);
			exit;
		}
	
		$username = $input['username'];
		global $mysqli;
	
		// Έλεγχος αν υπάρχει ήδη ο χρήστης
		$sql = 'SELECT count(*) as c FROM players WHERE username = ?';
		$st = $mysqli->prepare($sql);
		$st->bind_param('s', $username);
		$st->execute();
	
		$res = $st->get_result();
		$r = $res->fetch_all(MYSQLI_ASSOC);
	
		if ($r[0]['c'] > 0) {
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg' => "Username $username is already taken."]);
			exit;
		}
	
		// Δημιουργία χρήστη
		$sql = 'INSERT INTO players (username, token) VALUES (?, md5(CONCAT( ?, NOW())))';
		$st2 = $mysqli->prepare($sql);
		$st2->bind_param('ss', $username, $username);
		$st2->execute();
		

		update_game_status();
	
		$sql = 'SELECT * FROM players WHERE username = ?';
		$st = $mysqli->prepare($sql);
		$st->bind_param('s', $username);
		$st->execute();
	
		$res = $st->get_result();
	
		header('Content-type: application/json');
		print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
	}
	
	
	

	function current_user($token) {
		global $mysqli;
		if ($token == null) {
			return null;
		}
		$sql = 'SELECT username FROM players WHERE token = ?';
		$st = $mysqli->prepare($sql);
		$st->bind_param('s', $token);
		$st->execute();
		$res = $st->get_result();
		if ($row = $res->fetch_assoc()) {
			return $row['username'];
		}
		return null;
	}


?>