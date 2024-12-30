
$(function () {
    draw_empty_board();
    fill_board();
    //$('#quirkle_reset').click(reset_board);
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




