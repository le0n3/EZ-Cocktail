-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Feb 2024 um 17:17
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ez_cocktail`
--
CREATE DATABASE IF NOT EXISTS `ez_cocktail` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ez_cocktail`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheit`
--

DROP TABLE IF EXISTS `einheit`;
CREATE TABLE `einheit` (
                           `id` int(11) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `einheitkuerzel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `einheit`
--

INSERT INTO `einheit` (`id`, `name`, `einheitkuerzel`) VALUES
                                                           (1, 'Centiliter', 'cl'),
                                                           (2, 'Milliliter', 'ml'),
                                                           (3, 'Stück', 'Stk');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezept`
--

DROP TABLE IF EXISTS `rezept`;
CREATE TABLE `rezept` (
                          `id` int(11) NOT NULL,
                          `name` varchar(255) DEFAULT NULL,
                          `beschreibung` text DEFAULT NULL,
                          `zubereitung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rezept`
--

INSERT INTO `rezept` (`id`, `name`, `beschreibung`, `zubereitung`) VALUES
                                                                       (1, 'Jacky Cola', 'erklrt sich ziemlich von allein', 'einfach alles in ein Glas Uns Fertig'),
                                                                       (2, 'Margarita', 'Ein klassischer Tequila-Cocktail', '1. Saft einer Limette, 2. 60 ml Tequila, 3. 30 ml Triple Sec, 4. Salz für den Glasrand'),
                                                                       (3, 'Mojito', 'Ein erfrischender Rum-Cocktail', '1. Saft von einer Limette, 2. 2 Teelöffel Zucker, 3. Einige Minzblätter, 4. 60 ml Rum, 5. Soda zum auffüllen'),
                                                                       (4, 'Cosmopolitan', 'Ein stylischer Wodka-Cocktail', '1. 45 ml Wodka, 2. 15 ml Triple Sec, 3. 15 ml Limettensaft, 4. 30 ml Cranberrysaft');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezeptbild`
--

DROP TABLE IF EXISTS `rezeptbild`;
CREATE TABLE `rezeptbild` (
                              `id` int(11) NOT NULL,
                              `rezeptId` int(11) DEFAULT NULL,
                              `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rezeptbild`
--

INSERT INTO `rezeptbild` (`id`, `rezeptId`, `url`) VALUES
                                                       (1, 1, 'https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif'),
                                                       (2, 2, 'https://assets.happyplates.com/media/2554/happy-plates-rezept-klassischer-margarita-cocktail-.png?twic=v1/quality=80/focus=50px50p/cover=1200x1200/resize=1200'),
                                                       (3, 3, 'https://img.chefkoch-cdn.de/rezepte/1163331222441467/bilder/1505733/crop-960x540/mojito.jpg'),
                                                       (4, 4, 'https://images.immediate.co.uk/production/volatile/sites/30/2020/08/cosmopolitan-7a6874f.jpg?quality=90&resize=440,400');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `rezeptgesamt`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `rezeptgesamt`;
CREATE TABLE `rezeptgesamt` (
                                `id` int(11)
    ,`name` varchar(255)
    ,`beschreibung` text
    ,`zubereitung` text
    ,`url` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typ`
--

DROP TABLE IF EXISTS `typ`;
CREATE TABLE `typ` (
                       `id` int(11) NOT NULL,
                       `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `typ`
--

INSERT INTO `typ` (`id`, `name`) VALUES
                                     (1, 'Softdrink'),
                                     (2, 'Whiskey'),
                                     (3, 'Frucht');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat`
--

DROP TABLE IF EXISTS `zutat`;
CREATE TABLE `zutat` (
                         `id` int(11) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `beschreibung` varchar(255) NOT NULL,
                         `typId` int(11) NOT NULL,
                         `einheitId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutat`
--

INSERT INTO `zutat` (`id`, `name`, `beschreibung`, `typId`, `einheitId`) VALUES
                                                                             (1, 'Cola', 'Cola', 1, 2),
                                                                             (2, 'Jack Daniels', 'knallt halt nh', 2, 1),
                                                                             (3, 'Zitronee', ' boah', 3, 2),
                                                                             (4, 'Sprite', 'Muss mann von Rülpsen', 1, 2),
                                                                             (15, 'Tequila', 'Ein Alkohol, der aus der blauen Weber-Agave hergestellt wird.', 2, 1),
                                                                             (16, 'Triple Sec', 'Eine Sorte von starken, süßen und farblosen Orangenlikören.', 2, 1),
                                                                             (17, 'Limette', 'Eine säuerliche Frucht, die oft in Cocktails verwendet wird.', 3, 3),
                                                                             (18, 'Rum', 'Eine Spirituose, die durch die Fermentation von Zuckerrohrsaft oder Melasse hergestellt wird.', 2, 1),
                                                                             (19, 'Zucker', 'Ein süßes Kristallpulver.', 3, 1),
                                                                             (20, 'Minze', 'Eine Pflanze mit einem frischen Geschmack und Aroma.', 3, 3),
                                                                             (21, 'Soda', 'Sprudelndes Wasser, oft benutzt als Cocktail-Zutat.', 1, 1),
                                                                             (22, 'Wodka', 'Eine klare destillierte alkoholische Getränk.', 2, 1),
                                                                             (23, 'Cranberrysaft', 'Saft, der aus Cranberries gepresst wird.', 1, 1);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `zutatgesamt`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `zutatgesamt`;
CREATE TABLE `zutatgesamt` (
                               `id` int(11)
    ,`typ` varchar(255)
    ,`name` varchar(255)
    ,`beschreibung` varchar(255)
    ,`menge` float
    ,`einheit` varchar(10)
    ,`einheitlang` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutatinventar`
--

DROP TABLE IF EXISTS `zutatinventar`;
CREATE TABLE `zutatinventar` (
                                 `id` int(11) NOT NULL,
                                 `menge` float NOT NULL,
                                 `zutatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutatinventar`
--

INSERT INTO `zutatinventar` (`id`, `menge`, `zutatId`) VALUES
                                                           (1, 1000, 1),
                                                           (2, 100, 3),
                                                           (5, 500, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat_rezept`
--

DROP TABLE IF EXISTS `zutat_rezept`;
CREATE TABLE `zutat_rezept` (
                                `id` int(11) NOT NULL,
                                `menge` float NOT NULL,
                                `rezeptId` int(11) DEFAULT NULL,
                                `zutatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutat_rezept`
--

INSERT INTO `zutat_rezept` (`id`, `menge`, `rezeptId`, `zutatId`) VALUES
                                                                      (1, 120, 1, 1),
                                                                      (3, 4, 1, 2),
                                                                      (4, 1, 1, 3),
                                                                      (5, 60, 2, 15),
                                                                      (6, 30, 2, 16),
                                                                      (7, 1, 2, 17),
                                                                      (8, 60, 3, 18),
                                                                      (9, 2, 3, 19),
                                                                      (10, 1, 3, 17),
                                                                      (11, 1, 3, 20),
                                                                      (12, 1, 3, 21),
                                                                      (13, 45, 4, 22),
                                                                      (14, 15, 4, 16),
                                                                      (15, 15, 4, 17),
                                                                      (16, 30, 4, 23);

-- --------------------------------------------------------

--
-- Struktur des Views `rezeptgesamt`
--
DROP TABLE IF EXISTS `rezeptgesamt`;

DROP VIEW IF EXISTS `rezeptgesamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rezeptgesamt`  AS SELECT `rezept`.`id` AS `id`, `rezept`.`name` AS `name`, `rezept`.`beschreibung` AS `beschreibung`, `rezept`.`zubereitung` AS `zubereitung`, `rezeptbild`.`url` AS `url` FROM (`rezept` left join `rezeptbild` on(`rezept`.`id` = `rezeptbild`.`rezeptId`)) ;

-- --------------------------------------------------------

--
-- Struktur des Views `zutatgesamt`
--
DROP TABLE IF EXISTS `zutatgesamt`;

DROP VIEW IF EXISTS `zutatgesamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `zutatgesamt`  AS SELECT `zutat`.`id` AS `id`, `typ`.`name` AS `typ`, `zutat`.`name` AS `name`, `zutat`.`beschreibung` AS `beschreibung`, `zutatinventar`.`menge` AS `menge`, `einheit`.`einheitkuerzel` AS `einheit`, `einheit`.`name` AS `einheitlang` FROM (((`zutat` left join `typ` on(`zutat`.`typId` = `typ`.`id`)) left join `einheit` on(`zutat`.`einheitId` = `einheit`.`id`)) left join `zutatinventar` on(`zutat`.`id` = `zutatinventar`.`zutatId`)) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `einheit`
--
ALTER TABLE `einheit`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rezept`
--
ALTER TABLE `rezept`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rezeptbild`
--
ALTER TABLE `rezeptbild`
    ADD PRIMARY KEY (`id`),
    ADD KEY `rezeptId` (`rezeptId`);

--
-- Indizes für die Tabelle `typ`
--
ALTER TABLE `typ`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `zutat`
--
ALTER TABLE `zutat`
    ADD PRIMARY KEY (`id`),
    ADD KEY `typId` (`typId`),
    ADD KEY `einheitId` (`einheitId`);

--
-- Indizes für die Tabelle `zutatinventar`
--
ALTER TABLE `zutatinventar`
    ADD PRIMARY KEY (`id`),
    ADD KEY `zutatinventar_ibfk_1` (`zutatId`);

--
-- Indizes für die Tabelle `zutat_rezept`
--
ALTER TABLE `zutat_rezept`
    ADD PRIMARY KEY (`id`),
    ADD KEY `rezeptId` (`rezeptId`),
    ADD KEY `zutat_rezept_ibfk_1` (`zutatId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `einheit`
--
ALTER TABLE `einheit`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `rezept`
--
ALTER TABLE `rezept`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `rezeptbild`
--
ALTER TABLE `rezeptbild`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `typ`
--
ALTER TABLE `typ`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `zutat`
--
ALTER TABLE `zutat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `zutatinventar`
--
ALTER TABLE `zutatinventar`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `zutat_rezept`
--
ALTER TABLE `zutat_rezept`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `rezeptbild`
--
ALTER TABLE `rezeptbild`
    ADD CONSTRAINT `rezeptbild_ibfk_1` FOREIGN KEY (`rezeptId`) REFERENCES `rezept` (`id`);

--
-- Constraints der Tabelle `zutat`
--
ALTER TABLE `zutat`
    ADD CONSTRAINT `zutat_ibfk_1` FOREIGN KEY (`einheitId`) REFERENCES `einheit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `zutat_ibfk_2` FOREIGN KEY (`typId`) REFERENCES `typ` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `zutatinventar`
--
ALTER TABLE `zutatinventar`
    ADD CONSTRAINT `zutatinventar_ibfk_1` FOREIGN KEY (`zutatId`) REFERENCES `zutat` (`id`);

--
-- Constraints der Tabelle `zutat_rezept`
--
ALTER TABLE `zutat_rezept`
    ADD CONSTRAINT `zutat_rezept_ibfk_1` FOREIGN KEY (`zutatId`) REFERENCES `zutat` (`id`),
    ADD CONSTRAINT `zutat_rezept_ibfk_2` FOREIGN KEY (`rezeptId`) REFERENCES `rezept` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
