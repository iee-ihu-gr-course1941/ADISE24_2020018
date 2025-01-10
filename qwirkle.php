<?php
//ini_set("log_errors", 1);
//ini_set("error_log", "logs/php-error.log");

require_once "lib/dbconnect.php"; 
require_once "lib/board.php";
require_once "lib/game.php";
require_once "lib/users.php";


$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
 
$input = json_decode(file_get_contents('php://input'),true);

switch ($r=array_shift($request)) {
    case 'board' : 
	    switch ($b=array_shift($request)) {
			case '': 
			case null: handle_board($method);
                break;
			case 'tile_move': 
                handle_tile_move($method, $request[0], $request[1], $input);             
				break;
            case 'available_tiles': 
                players_available_tiles($method);             
                break;     
            case 'switch_player_turn': 
                switch_turn($method, $input);             
                break;
            case 'change_tiles': 
                handle_change_tiles($method, $input);             
                break;
            case 'game_data': 
                handle_game_data($method);             
                break;                  
			default: header("HTTP/1.1 404 Not Found");
				break;
		} 
		break;
	case 'status': 
		if(sizeof($request)==0) {
            handle_status($method);
        }else {
            header("HTTP/1.1 404 Not Found");
        }
		break;
	case 'players': handle_player($method, $input);
		break;
    default: 	
	header("HTTP/1.1 404 Not Found");
    print "<h1>NOT FOUND</h1>";
	exit;
}


function handle_board($method) {
    if($method=='GET') {
            show_board();
    } else if ($method=='POST') {
           reset_board();
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}

function handle_player($method,$input) {
    if($method =='GET') {
        show_users();
    } else if ($method =='PUT') {
        set_user($input);
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}

function handle_status($method) {
    if($method =='GET') {
        show_status();
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}

function handle_tile_move($method, $color, $shape, $input) {
	if ($method == 'PUT') {
        place_tile_on_board($color, $shape, $input['x'], $input['y'], $input['token']);
    }else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}

function handle_change_tiles($method, $input) {
    if ($method === 'POST') {
        if (!isset($input['token']) || !isset($input['tile_numbers'])) {
            header('HTTP/1.1 400 Bad Request21');
            echo json_encode(['errormesg' => 'Missing username or tile_numbers']);
            return;
        }

        $token = $input['token'];
        $tile_numbers = $input['tile_numbers'];

        if (!is_array($tile_numbers)) {
            header('HTTP/1.1 400 Bad Request22');
            echo json_encode(['errormesg' => 'tile_numbers must be an array']);
            return;
        }

        change_tiles($token, $tile_numbers);
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
    
}

function switch_turn($method, $input) {
	if ($method == 'POST') {
        switch_player_turn($input['token']);
    }else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}

function players_available_tiles($method) {
	if ($method == 'GET') {
        show_players_tiles();
    }else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}


function handle_game_data($method) {
    if($method =='GET') {
        show_game_data();
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}


?>
