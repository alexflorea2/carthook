-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `home_team` int NOT NULL,
  `away_team` int NOT NULL,
  `date` datetime NOT NULL,
  `season_id` int NOT NULL,
  `score_q1_home_team` smallint NOT NULL,
  `score_q1_away_team` smallint NOT NULL,
  `score_q2_home_team` smallint NOT NULL,
  `score_q2_away_team` smallint NOT NULL,
  `score_q3_home_team` smallint NOT NULL,
  `score_q3_away_team` smallint NOT NULL,
  `score_q4_home_team` smallint NOT NULL,
  `score_q4_away_team` smallint NOT NULL,
  `score_total_home_team` smallint NOT NULL,
  `score_total_away_team` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `season_id` (`season_id`),
  KEY `home_team_away_team` (`home_team`,`away_team`),
  CONSTRAINT `games_ibfk_4` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `games_players`;
CREATE TABLE `games_players` (
  `id` int NOT NULL,
  `game_id` int NOT NULL,
  `player_id` int NOT NULL,
  `position` enum('point_guard','shooting_guard','snall_forward','power_forward','center') COLLATE utf8mb4_general_ci NOT NULL,
  `points` smallint NOT NULL,
  `stats_fg` decimal(5,2) NOT NULL,
  `stats_ft` decimal(5,2) NOT NULL,
  `stats_3p` decimal(5,2) NOT NULL,
  `stats_reb` smallint NOT NULL,
  `stats_ast` smallint NOT NULL,
  `stats_stl` smallint NOT NULL,
  `stats_blk` smallint NOT NULL,
  `stats_ba` smallint NOT NULL,
  KEY `game_id` (`game_id`),
  KEY `player_id` (`player_id`),
  CONSTRAINT `games_players_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  CONSTRAINT `games_players_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `height` smallint DEFAULT NULL,
  `weight` smallint DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city` int DEFAULT NULL,
  `nba_debut` date DEFAULT NULL,
  `status` enum('still_playing','retreat','injury') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `career_stats_mpg` decimal(5,2) DEFAULT '0.00',
  `career_stats_fg` decimal(5,2) DEFAULT '0.00',
  `career_stats_3p` decimal(5,2) DEFAULT '0.00',
  `career_stats_ft` decimal(5,2) DEFAULT '0.00',
  `career_stats_ppg` decimal(5,2) DEFAULT '0.00',
  `career_stats_rpg` decimal(5,2) DEFAULT '0.00',
  `career_stats_apg` decimal(5,2) DEFAULT '0.00',
  `career_stats_bpg` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `seasons`;
CREATE TABLE `seasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city` int NOT NULL,
  `head_coach` int NOT NULL,
  `wins` int DEFAULT '0',
  `losses` int DEFAULT '0',
  `ppg` decimal(5,2) DEFAULT '0.00',
  `oppg` decimal(52,0) DEFAULT '0',
  `rpg` decimal(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `teams_players`;
CREATE TABLE `teams_players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_id` int NOT NULL,
  `team_id` int NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id_team_id` (`player_id`,`team_id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `teams_players_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  CONSTRAINT `teams_players_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2020-09-04 13:10:21
