-- --------------------------------------------------------
-- Διακομιστής:                  127.0.0.1
-- Έκδοση διακομιστή:            10.4.32-MariaDB - mariadb.org binary distribution
-- Λειτ. σύστημα διακομιστή:     Win64
-- HeidiSQL Έκδοση:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for πίνακας qwirkle.board
CREATE TABLE IF NOT EXISTS `board` (
  `x` smallint(6) NOT NULL,
  `y` smallint(6) NOT NULL,
  `tile_color` enum('Red','Blue','Green','Yellow','Orange','Purple') DEFAULT NULL,
  `tile_shape` enum('Circle','Square','4Star','Diamond','Clover','8Star') DEFAULT NULL,
  PRIMARY KEY (`x`,`y`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table qwirkle.board: ~225 rows (approximately)
INSERT INTO `board` (`x`, `y`, `tile_color`, `tile_shape`) VALUES
	(1, 1, NULL, NULL),
	(1, 2, NULL, NULL),
	(1, 3, NULL, NULL),
	(1, 4, NULL, NULL),
	(1, 5, NULL, NULL),
	(1, 6, NULL, NULL),
	(1, 7, NULL, NULL),
	(1, 8, NULL, NULL),
	(1, 9, NULL, NULL),
	(1, 10, NULL, NULL),
	(1, 11, NULL, NULL),
	(1, 12, NULL, NULL),
	(1, 13, NULL, NULL),
	(1, 14, NULL, NULL),
	(1, 15, NULL, NULL),
	(2, 1, NULL, NULL),
	(2, 2, NULL, NULL),
	(2, 3, NULL, NULL),
	(2, 4, NULL, NULL),
	(2, 5, NULL, NULL),
	(2, 6, NULL, NULL),
	(2, 7, NULL, NULL),
	(2, 8, NULL, NULL),
	(2, 9, NULL, NULL),
	(2, 10, NULL, NULL),
	(2, 11, NULL, NULL),
	(2, 12, NULL, NULL),
	(2, 13, NULL, NULL),
	(2, 14, NULL, NULL),
	(2, 15, NULL, NULL),
	(3, 1, NULL, NULL),
	(3, 2, NULL, NULL),
	(3, 3, NULL, NULL),
	(3, 4, NULL, NULL),
	(3, 5, NULL, NULL),
	(3, 6, NULL, NULL),
	(3, 7, NULL, NULL),
	(3, 8, NULL, NULL),
	(3, 9, NULL, NULL),
	(3, 10, NULL, NULL),
	(3, 11, NULL, NULL),
	(3, 12, NULL, NULL),
	(3, 13, NULL, NULL),
	(3, 14, NULL, NULL),
	(3, 15, NULL, NULL),
	(4, 1, NULL, NULL),
	(4, 2, NULL, NULL),
	(4, 3, NULL, NULL),
	(4, 4, NULL, NULL),
	(4, 5, NULL, NULL),
	(4, 6, NULL, NULL),
	(4, 7, NULL, NULL),
	(4, 8, NULL, NULL),
	(4, 9, NULL, NULL),
	(4, 10, NULL, NULL),
	(4, 11, NULL, NULL),
	(4, 12, NULL, NULL),
	(4, 13, NULL, NULL),
	(4, 14, NULL, NULL),
	(4, 15, NULL, NULL),
	(5, 1, NULL, NULL),
	(5, 2, NULL, NULL),
	(5, 3, NULL, NULL),
	(5, 4, NULL, NULL),
	(5, 5, NULL, NULL),
	(5, 6, NULL, NULL),
	(5, 7, NULL, NULL),
	(5, 8, NULL, NULL),
	(5, 9, NULL, NULL),
	(5, 10, NULL, NULL),
	(5, 11, NULL, NULL),
	(5, 12, NULL, NULL),
	(5, 13, NULL, NULL),
	(5, 14, NULL, NULL),
	(5, 15, NULL, NULL),
	(6, 1, NULL, NULL),
	(6, 2, NULL, NULL),
	(6, 3, NULL, NULL),
	(6, 4, NULL, NULL),
	(6, 5, NULL, NULL),
	(6, 6, NULL, NULL),
	(6, 7, NULL, NULL),
	(6, 8, NULL, NULL),
	(6, 9, NULL, NULL),
	(6, 10, NULL, NULL),
	(6, 11, NULL, NULL),
	(6, 12, NULL, NULL),
	(6, 13, NULL, NULL),
	(6, 14, NULL, NULL),
	(6, 15, NULL, NULL),
	(7, 1, NULL, NULL),
	(7, 2, NULL, NULL),
	(7, 3, NULL, NULL),
	(7, 4, NULL, NULL),
	(7, 5, NULL, NULL),
	(7, 6, NULL, NULL),
	(7, 7, NULL, NULL),
	(7, 8, NULL, NULL),
	(7, 9, NULL, NULL),
	(7, 10, NULL, NULL),
	(7, 11, NULL, NULL),
	(7, 12, NULL, NULL),
	(7, 13, NULL, NULL),
	(7, 14, NULL, NULL),
	(7, 15, NULL, NULL),
	(8, 1, NULL, NULL),
	(8, 2, NULL, NULL),
	(8, 3, NULL, NULL),
	(8, 4, NULL, NULL),
	(8, 5, NULL, NULL),
	(8, 6, NULL, NULL),
	(8, 7, NULL, NULL),
	(8, 8, NULL, NULL),
	(8, 9, NULL, NULL),
	(8, 10, NULL, NULL),
	(8, 11, NULL, NULL),
	(8, 12, NULL, NULL),
	(8, 13, NULL, NULL),
	(8, 14, NULL, NULL),
	(8, 15, NULL, NULL),
	(9, 1, NULL, NULL),
	(9, 2, NULL, NULL),
	(9, 3, NULL, NULL),
	(9, 4, NULL, NULL),
	(9, 5, NULL, NULL),
	(9, 6, NULL, NULL),
	(9, 7, NULL, NULL),
	(9, 8, NULL, NULL),
	(9, 9, NULL, NULL),
	(9, 10, NULL, NULL),
	(9, 11, NULL, NULL),
	(9, 12, NULL, NULL),
	(9, 13, NULL, NULL),
	(9, 14, NULL, NULL),
	(9, 15, NULL, NULL),
	(10, 1, NULL, NULL),
	(10, 2, NULL, NULL),
	(10, 3, NULL, NULL),
	(10, 4, NULL, NULL),
	(10, 5, NULL, NULL),
	(10, 6, NULL, NULL),
	(10, 7, NULL, NULL),
	(10, 8, NULL, NULL),
	(10, 9, NULL, NULL),
	(10, 10, NULL, NULL),
	(10, 11, NULL, NULL),
	(10, 12, NULL, NULL),
	(10, 13, NULL, NULL),
	(10, 14, NULL, NULL),
	(10, 15, NULL, NULL),
	(11, 1, NULL, NULL),
	(11, 2, NULL, NULL),
	(11, 3, NULL, NULL),
	(11, 4, NULL, NULL),
	(11, 5, NULL, NULL),
	(11, 6, NULL, NULL),
	(11, 7, NULL, NULL),
	(11, 8, NULL, NULL),
	(11, 9, NULL, NULL),
	(11, 10, NULL, NULL),
	(11, 11, NULL, NULL),
	(11, 12, NULL, NULL),
	(11, 13, NULL, NULL),
	(11, 14, NULL, NULL),
	(11, 15, NULL, NULL),
	(12, 1, NULL, NULL),
	(12, 2, NULL, NULL),
	(12, 3, NULL, NULL),
	(12, 4, NULL, NULL),
	(12, 5, NULL, NULL),
	(12, 6, NULL, NULL),
	(12, 7, NULL, NULL),
	(12, 8, NULL, NULL),
	(12, 9, NULL, NULL),
	(12, 10, NULL, NULL),
	(12, 11, NULL, NULL),
	(12, 12, NULL, NULL),
	(12, 13, NULL, NULL),
	(12, 14, NULL, NULL),
	(12, 15, NULL, NULL),
	(13, 1, NULL, NULL),
	(13, 2, NULL, NULL),
	(13, 3, NULL, NULL),
	(13, 4, NULL, NULL),
	(13, 5, NULL, NULL),
	(13, 6, NULL, NULL),
	(13, 7, NULL, NULL),
	(13, 8, NULL, NULL),
	(13, 9, NULL, NULL),
	(13, 10, NULL, NULL),
	(13, 11, NULL, NULL),
	(13, 12, NULL, NULL),
	(13, 13, NULL, NULL),
	(13, 14, NULL, NULL),
	(13, 15, NULL, NULL),
	(14, 1, NULL, NULL),
	(14, 2, NULL, NULL),
	(14, 3, NULL, NULL),
	(14, 4, NULL, NULL),
	(14, 5, NULL, NULL),
	(14, 6, NULL, NULL),
	(14, 7, NULL, NULL),
	(14, 8, NULL, NULL),
	(14, 9, NULL, NULL),
	(14, 10, NULL, NULL),
	(14, 11, NULL, NULL),
	(14, 12, NULL, NULL),
	(14, 13, NULL, NULL),
	(14, 14, NULL, NULL),
	(14, 15, NULL, NULL),
	(15, 1, NULL, NULL),
	(15, 2, NULL, NULL),
	(15, 3, NULL, NULL),
	(15, 4, NULL, NULL),
	(15, 5, NULL, NULL),
	(15, 6, NULL, NULL),
	(15, 7, NULL, NULL),
	(15, 8, NULL, NULL),
	(15, 9, NULL, NULL),
	(15, 10, NULL, NULL),
	(15, 11, NULL, NULL),
	(15, 12, NULL, NULL),
	(15, 13, NULL, NULL),
	(15, 14, NULL, NULL),
	(15, 15, NULL, NULL);

-- Dumping structure for procedure qwirkle.clean_board
DELIMITER //
CREATE PROCEDURE `clean_board`()
BEGIN
    -- Καθαρισμός του πίνακα
    TRUNCATE TABLE board;

    -- Επαναφορά του πίνακα σε grid 15x15
    INSERT INTO board (x, y)
	SELECT x, y
	FROM (
	    SELECT x_axis.x, y_axis.y
	    FROM (
	        SELECT 1 AS x UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
	        UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
	        UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
	    ) AS x_axis,
	    (
	        SELECT 1 AS y UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
	        UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
	        UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
	    ) AS y_axis
	) AS grid;

END//
DELIMITER ;

-- Dumping structure for procedure qwirkle.DistributeTilesToPlayersByUsername2
DELIMITER //
CREATE PROCEDURE `DistributeTilesToPlayersByUsername2`(player1_username VARCHAR(20), player2_username VARCHAR(20))
BEGIN
    DECLARE player1_id INT;
    DECLARE player2_id INT;

    DECLARE tile_count INT;

    DECLARE i INT DEFAULT 0;
    DECLARE selected_tile_id INT;

    DECLARE tile_color1 ENUM('Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple');
    DECLARE tile_shape1 ENUM('Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star');
    
    DECLARE tile_color2 ENUM('Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple');
    DECLARE tile_shape2 ENUM('Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star');


    -- Κατανομή πλακιδίων
    WHILE i < 6 DO
        -- Επιλογή τυχαίου πλακιδίου για τον player1
        SELECT tile_id, tile_color, tile_shape
        INTO selected_tile_id, tile_color1, tile_shape1
        FROM tiles_pool
        ORDER BY RAND()
        LIMIT 1;
        
        -- Προσθήκη πλακιδίου στον player1
        INSERT INTO player_tiles (username, tile_color, tile_shape)
        VALUES (player1_username, tile_color1, tile_shape1);
        
        -- Διαγραφή πλακιδίου από το tiles_pool
        DELETE FROM tiles_pool WHERE tile_id = selected_tile_id;

        -- Επιλογή τυχαίου πλακιδίου για τον player2
        SELECT tile_id, tile_color, tile_shape
        INTO selected_tile_id, tile_color2, tile_shape2
        FROM tiles_pool
        ORDER BY RAND()
        LIMIT 1;
        
        -- Προσθήκη πλακιδίου στον player2
        INSERT INTO player_tiles (username, tile_color, tile_shape)
        VALUES (player2_username, tile_color2, tile_shape2);

        -- Διαγραφή πλακιδίου από το tiles_pool
        DELETE FROM tiles_pool WHERE tile_id = selected_tile_id;

        SET i = i + 1;
    END WHILE;
END//
DELIMITER ;

-- Dumping structure for πίνακας qwirkle.game_status
CREATE TABLE IF NOT EXISTS `game_status` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('not active','initialized','started','ended','aborted') NOT NULL DEFAULT 'not active',
  `p_turn` varchar(20) DEFAULT NULL,
  `result` enum('player1','player2','draw') DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table qwirkle.game_status: ~1 rows (approximately)
INSERT INTO `game_status` (`game_id`, `status`, `p_turn`, `result`, `last_change`) VALUES
	(3, 'aborted', NULL, NULL, '2025-01-10 19:30:38');

-- Dumping structure for procedure qwirkle.place_tile3
DELIMITER //
CREATE PROCEDURE `place_tile3`(
    IN p_player_username VARCHAR(20), 
    IN p_x SMALLINT, 
    IN p_y SMALLINT, 
    IN p_tile_color ENUM('Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple'), 
    IN p_tile_shape ENUM('Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star')
)
BEGIN
    DECLARE tile_exists INT;
    DECLARE p_tile_id INT;


        SELECT player_tile_id INTO p_tile_id
        FROM player_tiles
        WHERE username= p_player_username AND tile_color = p_tile_color AND tile_shape = p_tile_shape
        LIMIT 1;


            INSERT INTO board (x, y, tile_color, tile_shape)
            VALUES (p_x, p_y, p_tile_color, p_tile_shape)
            ON DUPLICATE KEY UPDATE 
                tile_color = VALUES(tile_color), 
                tile_shape = VALUES(tile_shape);

            DELETE FROM player_tiles
            WHERE player_tile_id = p_tile_id;

END//
DELIMITER ;

-- Dumping structure for πίνακας qwirkle.players
CREATE TABLE IF NOT EXISTS `players` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `score` int(11) DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table qwirkle.players: ~24 rows (approximately)
INSERT INTO `players` (`player_id`, `username`, `score`, `token`, `last_action`) VALUES
	(62, NULL, 0, NULL, '2025-01-10 12:53:08'),
	(63, NULL, 0, NULL, '2025-01-10 12:53:08'),
	(64, NULL, 0, NULL, '2025-01-10 12:53:08'),
	(65, NULL, 0, NULL, '2025-01-10 12:53:08'),
	(66, NULL, 0, NULL, '2025-01-10 12:59:36'),
	(67, NULL, 0, NULL, '2025-01-10 13:09:13'),
	(68, NULL, 0, NULL, '2025-01-10 13:09:13'),
	(89, NULL, 4, NULL, '2025-01-10 13:54:53'),
	(90, NULL, 0, NULL, '2025-01-10 13:54:53'),
	(96, NULL, 0, NULL, '2025-01-10 14:35:54'),
	(97, NULL, 0, NULL, '2025-01-10 14:35:54'),
	(106, NULL, 2, NULL, '2025-01-10 14:50:47'),
	(107, NULL, 0, NULL, '2025-01-10 14:50:47'),
	(108, NULL, 1, NULL, '2025-01-10 15:02:49'),
	(109, NULL, 0, NULL, '2025-01-10 15:02:49'),
	(110, NULL, 0, NULL, '2025-01-10 15:11:19'),
	(111, NULL, 0, NULL, '2025-01-10 15:11:19'),
	(116, NULL, 0, NULL, '2025-01-10 17:56:43'),
	(117, NULL, 0, NULL, '2025-01-10 17:56:43'),
	(123, NULL, 10, NULL, '2025-01-10 18:49:22'),
	(124, NULL, 0, NULL, '2025-01-10 18:49:22'),
	(125, NULL, 1, NULL, '2025-01-10 19:25:32'),
	(126, NULL, 0, NULL, '2025-01-10 19:25:32'),
	(127, 'makis', 0, 'c1e0425fd3081a7cb0bc432f62bae8ec', '2025-01-10 19:25:32'),
	(128, 'takis', 0, '88eb15abae86f42a8bc1301f69db4990', '2025-01-10 19:25:36');

-- Dumping structure for πίνακας qwirkle.player_tiles
CREATE TABLE IF NOT EXISTS `player_tiles` (
  `player_tile_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `tile_color` enum('Red','Blue','Green','Yellow','Orange','Purple') NOT NULL,
  `tile_shape` enum('Circle','Square','4Star','Diamond','Clover','8Star') NOT NULL,
  PRIMARY KEY (`player_tile_id`),
  KEY `username` (`username`),
  CONSTRAINT `player_tiles_ibfk_1` FOREIGN KEY (`username`) REFERENCES `players` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table qwirkle.player_tiles: ~12 rows (approximately)
INSERT INTO `player_tiles` (`player_tile_id`, `username`, `tile_color`, `tile_shape`) VALUES
	(69, 'makis', 'Yellow', '8Star'),
	(70, 'takis', 'Green', 'Square'),
	(71, 'makis', 'Purple', 'Diamond'),
	(72, 'takis', 'Red', '4Star'),
	(73, 'makis', 'Green', 'Circle'),
	(74, 'takis', 'Purple', 'Square'),
	(75, 'makis', 'Red', '8Star'),
	(76, 'takis', 'Purple', 'Clover'),
	(77, 'makis', 'Red', 'Diamond'),
	(78, 'takis', 'Green', 'Diamond'),
	(79, 'makis', 'Blue', 'Diamond'),
	(80, 'takis', 'Orange', '4Star');

-- Dumping structure for procedure qwirkle.refill_tiles
DELIMITER //
CREATE PROCEDURE `refill_tiles`(player_username VARCHAR(20), num_tiles INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE selected_tile_id INT;

    DECLARE t_color ENUM('Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple');
    DECLARE t_shape ENUM('Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star');



    -- Κατανομή πλακιδίων
    WHILE i < num_tiles DO
        -- Επιλογή τυχαίου πλακιδίου από το tiles_pool
        SELECT tile_id, tile_color, tile_shape 
        INTO selected_tile_id, t_color, t_shape
        FROM tiles_pool
        ORDER BY RAND()
        LIMIT 1;

        -- Εισαγωγή του πλακιδίου στον πίνακα players_tiles
        IF selected_tile_id IS NOT NULL THEN
            INSERT INTO player_tiles (username, tile_color, tile_shape)
            VALUES (player_username, t_color, t_shape);

            -- Διαγραφή του πλακιδίου από το tiles_pool
            DELETE FROM tiles_pool WHERE tile_id = selected_tile_id;
        END IF;

        SET i = i + 1;
    END WHILE;
END//
DELIMITER ;

-- Dumping structure for procedure qwirkle.refill_tiles2
DELIMITER //
CREATE PROCEDURE `refill_tiles2`(player_username VARCHAR(20), num_tiles INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE selected_tile_id INT;
    DECLARE available_tiles INT;

    DECLARE t_color ENUM('Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple');
    DECLARE t_shape ENUM('Circle', 'Square', '4Star', 'Diamond', 'Clover', '8Star');

    -- Ελέγχουμε πόσα tiles υπάρχουν στο tiles_pool
    SELECT COUNT(*) INTO available_tiles
    FROM tiles_pool;

    -- Ορίζουμε τον αριθμό των tiles που θα πάρουμε (πρέπει να είναι το μικρότερο από το num_tiles και τα διαθέσιμα tiles)
    SET num_tiles = LEAST(num_tiles, available_tiles);

    WHILE i < num_tiles DO

        SELECT tile_id, tile_color, tile_shape 
        INTO selected_tile_id, t_color, t_shape
        FROM tiles_pool
        ORDER BY RAND()
        LIMIT 1;

        IF selected_tile_id IS NOT NULL THEN
            INSERT INTO player_tiles (username, tile_color, tile_shape)
            VALUES (player_username, t_color, t_shape);

            DELETE FROM tiles_pool WHERE tile_id = selected_tile_id;
        END IF;

        SET i = i + 1;
    END WHILE;
END//
DELIMITER ;

-- Dumping structure for procedure qwirkle.reset_tile_pool
DELIMITER //
CREATE PROCEDURE `reset_tile_pool`()
BEGIN
    DECLARE counter INT DEFAULT 0;

    TRUNCATE TABLE tiles_pool;

    WHILE counter < 3 DO
        INSERT INTO tiles_pool (tile_color, tile_shape) VALUES
        ('Red', 'Circle'),
        ('Red', 'Square'),
        ('Red', '4Star'),
        ('Red', 'Diamond'),
        ('Red', 'Clover'),
        ('Red', '8Star'),
        ('Blue', 'Circle'),
        ('Blue', 'Square'),
        ('Blue', '4Star'),
        ('Blue', 'Diamond'),
        ('Blue', 'Clover'),
        ('Blue', '8Star'),
        ('Green', 'Circle'),
        ('Green', 'Square'),
        ('Green', '4Star'),
        ('Green', 'Diamond'),
        ('Green', 'Clover'),
        ('Green', '8Star'),
        ('Yellow', 'Circle'),
        ('Yellow', 'Square'),
        ('Yellow', '4Star'),
        ('Yellow', 'Diamond'),
        ('Yellow', 'Clover'),
        ('Yellow', '8Star'),
        ('Orange', 'Circle'),
        ('Orange', 'Square'),
        ('Orange', '4Star'),
        ('Orange', 'Diamond'),
        ('Orange', 'Clover'),
        ('Orange', '8Star'),
        ('Purple', 'Circle'),
        ('Purple', 'Square'),
        ('Purple', '4Star'),
        ('Purple', 'Diamond'),
        ('Purple', 'Clover'),
        ('Purple', '8Star');

        SET counter = counter + 1;
    END WHILE;
END//
DELIMITER ;

-- Dumping structure for πίνακας qwirkle.tiles_pool
CREATE TABLE IF NOT EXISTS `tiles_pool` (
  `tile_id` int(11) NOT NULL AUTO_INCREMENT,
  `tile_color` enum('Red','Blue','Green','Yellow','Orange','Purple') NOT NULL,
  `tile_shape` enum('Circle','Square','4Star','Diamond','Clover','8Star') NOT NULL,
  PRIMARY KEY (`tile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table qwirkle.tiles_pool: ~96 rows (approximately)
INSERT INTO `tiles_pool` (`tile_id`, `tile_color`, `tile_shape`) VALUES
	(1, 'Red', 'Circle'),
	(2, 'Red', 'Square'),
	(3, 'Red', '4Star'),
	(4, 'Red', 'Diamond'),
	(5, 'Red', 'Clover'),
	(7, 'Blue', 'Circle'),
	(8, 'Blue', 'Square'),
	(9, 'Blue', '4Star'),
	(10, 'Blue', 'Diamond'),
	(11, 'Blue', 'Clover'),
	(12, 'Blue', '8Star'),
	(13, 'Green', 'Circle'),
	(14, 'Green', 'Square'),
	(15, 'Green', '4Star'),
	(17, 'Green', 'Clover'),
	(18, 'Green', '8Star'),
	(19, 'Yellow', 'Circle'),
	(20, 'Yellow', 'Square'),
	(21, 'Yellow', '4Star'),
	(22, 'Yellow', 'Diamond'),
	(23, 'Yellow', 'Clover'),
	(24, 'Yellow', '8Star'),
	(25, 'Orange', 'Circle'),
	(26, 'Orange', 'Square'),
	(27, 'Orange', '4Star'),
	(28, 'Orange', 'Diamond'),
	(29, 'Orange', 'Clover'),
	(30, 'Orange', '8Star'),
	(31, 'Purple', 'Circle'),
	(33, 'Purple', '4Star'),
	(34, 'Purple', 'Diamond'),
	(36, 'Purple', '8Star'),
	(37, 'Red', 'Circle'),
	(38, 'Red', 'Square'),
	(40, 'Red', 'Diamond'),
	(41, 'Red', 'Clover'),
	(42, 'Red', '8Star'),
	(43, 'Blue', 'Circle'),
	(44, 'Blue', 'Square'),
	(45, 'Blue', '4Star'),
	(47, 'Blue', 'Clover'),
	(48, 'Blue', '8Star'),
	(49, 'Green', 'Circle'),
	(50, 'Green', 'Square'),
	(51, 'Green', '4Star'),
	(52, 'Green', 'Diamond'),
	(53, 'Green', 'Clover'),
	(54, 'Green', '8Star'),
	(55, 'Yellow', 'Circle'),
	(56, 'Yellow', 'Square'),
	(57, 'Yellow', '4Star'),
	(58, 'Yellow', 'Diamond'),
	(59, 'Yellow', 'Clover'),
	(60, 'Yellow', '8Star'),
	(61, 'Orange', 'Circle'),
	(62, 'Orange', 'Square'),
	(64, 'Orange', 'Diamond'),
	(65, 'Orange', 'Clover'),
	(66, 'Orange', '8Star'),
	(67, 'Purple', 'Circle'),
	(68, 'Purple', 'Square'),
	(69, 'Purple', '4Star'),
	(70, 'Purple', 'Diamond'),
	(71, 'Purple', 'Clover'),
	(72, 'Purple', '8Star'),
	(73, 'Red', 'Circle'),
	(74, 'Red', 'Square'),
	(75, 'Red', '4Star'),
	(77, 'Red', 'Clover'),
	(78, 'Red', '8Star'),
	(79, 'Blue', 'Circle'),
	(80, 'Blue', 'Square'),
	(81, 'Blue', '4Star'),
	(82, 'Blue', 'Diamond'),
	(83, 'Blue', 'Clover'),
	(84, 'Blue', '8Star'),
	(87, 'Green', '4Star'),
	(88, 'Green', 'Diamond'),
	(89, 'Green', 'Clover'),
	(90, 'Green', '8Star'),
	(91, 'Yellow', 'Circle'),
	(92, 'Yellow', 'Square'),
	(93, 'Yellow', '4Star'),
	(94, 'Yellow', 'Diamond'),
	(95, 'Yellow', 'Clover'),
	(97, 'Orange', 'Circle'),
	(98, 'Orange', 'Square'),
	(99, 'Orange', '4Star'),
	(100, 'Orange', 'Diamond'),
	(101, 'Orange', 'Clover'),
	(102, 'Orange', '8Star'),
	(103, 'Purple', 'Circle'),
	(104, 'Purple', 'Square'),
	(105, 'Purple', '4Star'),
	(107, 'Purple', 'Clover'),
	(108, 'Purple', '8Star');

-- Dumping structure for trigger qwirkle.game_status_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER game_status_update BEFORE UPDATE
ON game_status
FOR EACH ROW BEGIN
SET NEW.last_change = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
