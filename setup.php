/*-------------------------------------------------------+
| Bowling Statistics
| SETUP DATABASE AND TABLES
| Until fixed, you will need to manually create the tables and
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
CREATE TABLE IF NOT EXISTS `members` (
    `memberID` BIGINT NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL DEFAULT '',
    `password` varchar(32) NOT NULL DEFAULT '',
    PRIMARY KEY (`memberID`)
);

INSERT INTO `members` (`memberID`, `username`, `password`) VALUES
(1, 'admin', md5('P@$$w0rd#1'));

CREATE TABLE IF NOT EXISTS `user_data` (
    `user_data_id` BIGINT NOT NULL AUTO_INCREMENT,
    `admin` INT NOT NULL DEFAULT 0,
    `memberID` BIGINT DEFAULT NULL,
    `first_name` varchar(64) NOT NULL DEFAULT '',
    `last_name` varchar(64) NOT NULL DEFAULT '',
    `email` varchar(100) NOT NULL DEFAULT '',
    `birthday` DATE NOT NULL,
    `join_date` DATE NOT NULL,
    `avatar` varchar(300) NOT NULL,
    `location` TEXT NOT NULL,
    `quote` varchar(150) NOT NULL,
    `about_me` LONGTEXT NOT NULL,
    PRIMARY KEY (`user_data_id`),
    FOREIGN KEY ('memberID') REFERENCES members(memberID)
);

INSERT INTO `user_data` (`admin`,`memberID`, `join_date`) VALUES (1, 1, CURDATE(),);

CREATE TABLE IF NOT EXISTS 'games' (
    'game_id' BIGINT NOT NULL AUTO_INCREMENT,
    'member_id' BIGINT DEFAULT NULL,
    'date' DATE NOT NULL DEFAULT CURDATE(),
    'full_game' VARCHAR(6) NOT NULL DEFAULT 'false',
    'league_play' VARCHAR(6) NOT NULL DEFAULT 'false',
    'frames' LONGTEXT NULL DEFAULT '',
    'score' int(3) NOT NULL DEFAULT '0',
    PRIMARY KEY ('game_id'),
    FOREIGN KEY ('memberID') REFERENCES members(memberID)
    );

CREATE TABLE IF NOT EXISTS 'pages' (
    'page_id' INT(11) NOT NULL AUTO_INCREMENT,
    'page_title' VARCHAR(255) NOT NULL DEFAULT '',
    'isRoot' TINYINT unsigned NOT NULL,
    'page_content' LONGTEXT NULL DEFAULT '',
    'author' BIGINT NOT NULL DEFAULT '1',
    PRIMARY KEY ('page_id'),
    FOREIGN KEY ('author') REFERENCES members(memberID)
    );


INSERT INTO `pages` (`page_id`, `page_title`, `isRoot`, `page_content`) VALUES
(1, 'Home', 0, '<p>Sample Sample content</p>');
