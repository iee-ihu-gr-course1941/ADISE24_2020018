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
			case 'tile': 
                handle_tile_move($method, $request[0], $request[1], $input);             
				break;
			default: header("HTTP/1.1 404 Not Found");
				break;
		} 
		break;
	case 'status': 
		if(sizeof($request)==0) 
			{handle_status($method);}
		else 
			{header("HTTP/1.1 404 Not Found");}
		break;
	case 'players': handle_player($method, $request, $input);
			break;
    default: 	
	header("HTTP/1.1 404 Not Found");
    print "<h1>not FOUND</h1>";
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



function handle_tile_move($method, $color, $shape, $input) {
	if ($method == 'PUT') {
        place_tile_on_board($color, $shape, $input['x'], $input['y'], $input['token']);
    }
}





function handle_player($method, $p) {
    $name = array_shift($p);
    
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'GET': 
            show_user($name);
            break;
        
        case 'PUT': 
            set_user($input);
            break;

        default:
            header("HTTP/1.1 400 Bad Request"); 
            print json_encode(['errormesg' => "Method $method not allowed for player $name."]);
            break;
    }
}



function handle_status($method) {
    if($method=='GET') {
        show_status();
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
    }
}


?>
