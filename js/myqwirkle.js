   
    var me={};
    var game_status={};


    $(function () {
        draw_empty_board();
        fill_board();
        $('#move_div').hide();
        $('#move_div').hide();
        $('#change').hide();


        $('#quirkle_reset').click(reset_board);
        $('#quirkle_login').click(login_to_game);
        $('#do_move').click(do_move);
        $('#change_turn').click(change_turn);
        $('#change_tiles').click(change_tiles);
        
    });

    function reset_board(){
        $.ajax({
            method: "POST",
            url: "qwirkle.php/board/",
            success: fill_board_by_data
        });
    }

    function draw_empty_board() {
        var t = '<table id="quirkle_table">';
        for (var y = 15; y > 0; y--) {
            t += '<tr>';
            for (var x = 1; x <= 15; x++) {
                t += '<td class="quirkle_square" id="square_' + x + '_' + y + '"></td>';
            }
            t += '</tr>';
        }
        t += '</table>';
        $('#quirkle_board').html(t);
    }

    function fill_board() {
        $.ajax({
            method: "GET",
            url: "qwirkle.php/board/",
            success: fill_board_by_data
        });
    }

    function fill_board_by_data(data) {
        for (var i = 0; i < data.length; i++) {
            var o = data[i];

            var id = '#square_' + o.x + '_' + o.y;

            if (o.tile_color && o.tile_shape) {
                var tileColor = o.tile_color.toLowerCase();
                var tileShape = o.tile_shape.toLowerCase();
                var imagePath = 'images/' + tileColor + '_' + tileShape + '.png';

                var tileHtml = '<img src="' + imagePath + '" alt="' + o.tile_color + ' ' + o.tile_shape + '" class="quirkle_tile">';
                $(id).html(tileHtml);
            } else {
                $(id).html('');
            }

            if (o.b_color) {
                $(id).addClass(o.b_color + '_square');
            }
        }
    }


    function fill_available_tiles() {
        $.ajax({
            url: "qwirkle.php/board/available_tiles/",
            method: "GET",
            success: fill_tiles_by_data,
            error: function(error) {           
                if (error.responseJSON && error.responseJSON.errormesg) {
                    alert("Error: " + error.responseJSON.errormesg);
                } else {
                    alert("An error occurred: " + error.statusText);
                }
            }
        });
    }

    function fill_tiles_by_data(data) {
        var filteredData = data.filter(o => o.username === me.username);
        
        var totalCells = 6;
        
        for (var i = 0; i < totalCells; i++) {
            var id = '#square_' + (i + 1); 
            
            if (i < filteredData.length) {
                var o = filteredData[i];
                
                if (o.tile_color && o.tile_shape) {
                    var tileColor = o.tile_color.toLowerCase();
                    var tileShape = o.tile_shape.toLowerCase();
                    var imagePath = 'images/' + tileColor + '_' + tileShape + '.png';
                    
                    var tileHtml = '<img src="' + imagePath + '" alt="' + o.tile_color + ' ' + o.tile_shape + '" class="quirkle_tile">';
                    $(id).html(tileHtml);
                }
                
                if (o.b_color) {
                    $(id).addClass(o.b_color + '_square');
                }
            } else {
                $(id).html('');
                //$(id).removeClass().addClass('default_square');
            }
        }
    }
    
    

    function login_to_game() {
        if ($('#username').val() == '') {
            alert('Πρέπει να δώσεις ένα username');
            return;
        }    
        $.ajax({
            url: "qwirkle.php/players",
            method: 'PUT',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify({ username: $('#username').val() }),
            success: login_result,
            error: login_error
        });
    }

    function login_result(data) {
        me = data[0];
        $('#game_initializer').hide();
        update_info();
        game_status_update();
    }

    function update_info() {
        let statusMessage = "";

        switch (game_status.status) {
            case 'initialized':
                statusMessage = "Waiting for another player to join...";
                break;
            case 'started':
                statusMessage = "It's " + game_status.p_turn + "'s turn to play.";
                break;
            case 'ended':
                statusMessage = "Game Over. " + game_status.winner + " won the game!";
                break;
            case 'aborted':
                statusMessage = "Το παιχνίδι τερματίστηκε, κάποιος βγήκε από το παιχνίδι";
                break;
            default:
                statusMessage = "Unknown game status.";
                break;
        }

        $('#game_info').html(
            "I am Player: " + me.username + 
            '<br>Token= ' + me.token + 
            '<br>Game Status: ' + game_status.status + 
            '<br>Game state: ' + statusMessage
        );
    }
   
    function login_error(data, y, z, c) {
        var x = data.responseJSON;
        alert(x.errormesg);
    }


    function game_status_update() {
        $.ajax({ url: "qwirkle.php/status/", success: update_status });
    }

    function update_status(data) {
        if (game_status.p_turn == null || data[0].p_turn != game_status.p_turn || data[0].status != game_status.status) {
            fill_board();
        }
        
        update_points_opponet_tiles();
        fill_available_tiles();
        game_status = data[0];
        update_info();
        if (game_status.p_turn === me.username && me.username != null) {
            x = 0;
            $('#move_div').show();
            $('#change').show();
            setTimeout(function() { game_status_update(); }, 15000);
        } else {
            $('#the_move').val('');
            $('#tiles_for_change').val('');
            $('#move_div').hide();
            $('#change').hide();
            setTimeout(function() { game_status_update(); }, 4000);
        }
    }
    


    function do_move() {
        
        var s = $('#the_move').val();
    
        var a = s.trim().split(/[ ]+/);
        if (a.length != 4) {
            alert('Πρέπει να δώσεις 4 παραμέτρους: χρώμα, σχήμα, και τις συντεταγμένες (x & y)');
            return;
        }

        var validColors = ['Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple'];
        if (!validColors.includes(a[0])) {
            alert('Το χρώμα πρέπει να είναι ένα από τα εξής: Red, Blue, Green, Yellow, Orange, Purple');
            return;
        }

        var validShapes = ['Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star'];
        if (!validShapes.includes(a[1])) {
            alert('Το σχήμα πρέπει να είναι ένα από τα εξής: Circle, Square, 4Star, Diamond, Clover, 8Star');
            return;
        }

        var x1 = parseInt(a[2], 10);
        var y1 = parseInt(a[3], 10);

        if (isNaN(x1) || x1 < 1 || x1 > 15 || isNaN(y1) || y1 < 1 || y1 > 15) {
            alert('Οι συντεταγμένες (x & y) πρέπει να είναι αριθμοί από 1 έως 15');
            return;
        }


        $.ajax({
            url: "qwirkle.php/board/tile_move/"+a[0]+'/'+a[1], 
            method: 'PUT',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify({ x: a[2], y: a[3], token: me.token }),
            success: move_result, 
            error: function(error) {
                if (error.responseJSON && error.responseJSON.errormesg) {
                    alert("Error: " + error.responseJSON.errormesg);
                } else {
                    alert("An error occurred: " + error.statusText);
                }
            }
        });
    }
    

    function move_result(data) {
        $('#change').hide();
        fill_board_by_data(data);
        fill_available_tiles();
        update_points_opponet_tiles();
    }

    
    function change_tiles() {
        var s = $('#tiles_for_change').val().trim();
    
        if (s === "") {
            alert('Παρακαλώ εισάγετε αριθμούς πλακιδίων (1-6)');
            return;
        }

        var tileNumbers = s.split(/[,]+/).map(Number);

        // Έλεγχος ότι όλοι οι αριθμοί είναι στο εύρος [1, 6]
        var isValid = tileNumbers.every(function(num) {
            return !isNaN(num) && num >= 1 && num <= 6;
        });

        if (!isValid) {
            alert('Παρακαλώ εισάγετε έγκυρους αριθμούς πλακιδίων (1-6)');
            return;
        }


        $.ajax({
            url: "qwirkle.php/board/change_tiles/",
            method: 'POST',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify({ token: me.token, tile_numbers: tileNumbers }),
            error: function(error) {          
                if (error.responseJSON && error.responseJSON.errormesg) {
                    alert("Error: " + error.responseJSON.errormesg);
                } else {
                    alert("An error occurred: " + error.statusText);
                }
            }
        });

        fill_available_tiles();
        update_points_opponet_tiles();
        change_turn();
    }

    function update_points_opponet_tiles() {
        $.ajax({
            url: "qwirkle.php/board/game_data/",
            method: "GET",
            dataType: "json",
            data: JSON.stringify({ token: me.token }),
            success: fill_game_data,
            error: function(error) {            
                if (error.responseJSON && error.responseJSON.errormesg) {
                    alert("Error: " + error.responseJSON.errormesg);
                } else {
                    alert("An error occurred: " + error.statusText);
                }
            }
        });
    }

    function fill_game_data(data){
        const myData = data.find(player => player.username === me.username);
        const opponentData = data.find(player => player.username !== me.username);

        document.getElementById('your-score').textContent = myData.score;
        document.getElementById('opponent-score').textContent = opponentData.score;
        document.getElementById('opponent-tiles').textContent = opponentData.tile_count;

    }

    function change_turn() {
        $.ajax({
            url: "qwirkle.php/board/switch_player_turn/",
            method: "POST",
            dataType: "json",
            data: JSON.stringify({ token: me.token }),
            error: function(error) {           
                if (error.responseJSON && error.responseJSON.errormesg) {
                    alert("Error: " + error.responseJSON.errormesg);
                } else {
                    alert("An error occurred: " + error.statusText);
                }
            }
        });
    }



    function lathos(jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error");
        console.error("Status: " + textStatus);
        console.error("Error Thrown: " + errorThrown);
        console.error("Response Text: ", jqXHR.responseText);
        console.error("Status Code: " + jqXHR.status);
    
        alert("Παρουσιάστηκε σφάλμα: " + textStatus + "\n" + errorThrown);
    }
    






