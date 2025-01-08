   
    var me={};
    var game_status={};


    $(function () {
        draw_empty_board();
        fill_board();
        //$('#quirkle_reset').click(reset_board);

        $('#quirkle_login').click(login_to_game);
        //$('#move_div').hide(1000);
        $('#do_move').click(do_move);
    });


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
        $('#game_info').html("I am Player: " + me.username + ", my name is " + me.username + 
            '<br>Token=' + me.token + '<br>Game state: ' + game_status.status + ', ' + game_status.p_turn + ' must play now.');
    }
   
    function login_error(data, y, z, c) {
        var x = data.responseJSON;
        alert(x.errormesg);
        alert("axx");
    }





    function game_status_update() {
        $.ajax({ url: "qwirkle.php/status/", success: update_status });
    }

    function update_status(data) {
        if (game_status.p_turn == null || data[0].p_turn != game_status.p_turn || data[0].status != game_status.status) {
            fill_board();
        }
        
        game_status = data[0];
        update_info();
        if (game_status.p_turn === me.username && me.username != null) {
            x = 0;
            $('#move_div').show();
            setTimeout(function() { game_status_update(); }, 15000);
        } else {
            $('#move_div').hide();
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

        $.ajax({
            url: "qwirkle.php/board/tile/"+a[0]+'/'+a[1], 
            method: 'PUT',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify({ x: a[2], y: a[3], token: me.token }),
            success: move_result, 
            error: lathos
        });
    }
    
    function move_result(data) {
        // Ενημέρωση του πίνακα με τα νέα δεδομένα
        fill_board_by_data(data);
    }

    
    function lathos(jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error");
        console.error("Status: " + textStatus);
        console.error("Error Thrown: " + errorThrown);
        console.error("Response Text: ", jqXHR.responseText);
        console.error("Status Code: " + jqXHR.status);
    
        alert("Παρουσιάστηκε σφάλμα: " + textStatus + "\n" + errorThrown);
    }
    






