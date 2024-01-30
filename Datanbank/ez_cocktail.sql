-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jan 2024 um 11:08
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheit`
--

CREATE TABLE `einheit` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `einheitBezeichnung` varchar(255) DEFAULT NULL,
  `zutatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `einheit`
--

INSERT INTO `einheit` (`id`, `name`, `einheitBezeichnung`, `zutatId`) VALUES
(5, 'Centiliter', 'cl', 3),
(6, 'Milliliter', 'ml', 2),
(7, 'Stück', 'Stk', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezept`
--

CREATE TABLE `rezept` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rezept`
--

INSERT INTO `rezept` (`id`, `name`, `beschreibung`) VALUES
(1, 'Jacky Cola', 'erklrt sich ziemlich von allein');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezeptbild`
--

CREATE TABLE `rezeptbild` (
  `id` int(11) NOT NULL,
  `rezeptId` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typ`
--

CREATE TABLE `typ` (
  `Id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `zutatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `typ`
--

INSERT INTO `typ` (`Id`, `name`, `zutatId`) VALUES
(2, 'Softdrink', 2),
(3, 'Wihskey', 3),
(4, 'Frucht', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat`
--

CREATE TABLE `zutat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutat`
--

INSERT INTO `zutat` (`id`, `name`, `beschreibung`) VALUES
(2, 'Cola', 'Coca Cola'),
(3, 'Jack Daniels', 'knallt halt nh'),
(4, 'Zitrone', 'boah');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutatinventar`
--

CREATE TABLE `zutatinventar` (
  `id` int(11) NOT NULL,
  `menge` float NOT NULL,
  `zutatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutatinventar`
--

INSERT INTO `zutatinventar` (`id`, `menge`, `zutatId`) VALUES
(1, 1000, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat_rezept`
--

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
(1, 120, 1, 2),
(3, 4, 1, 3),
(4, 1, 1, 4);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `einheit`
--
ALTER TABLE `einheit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zutatId` (`zutatId`);

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
  ADD PRIMARY KEY (`Id`),
  ADD KEY `zutatId` (`zutatId`);

--
-- Indizes für die Tabelle `zutat`
--
ALTER TABLE `zutat`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `rezept`
--
ALTER TABLE `rezept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `typ`
--
ALTER TABLE `typ`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `zutat`
--
ALTER TABLE `zutat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `zutatinventar`
--
ALTER TABLE `zutatinventar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `zutat_rezept`
--
ALTER TABLE `zutat_rezept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `einheit`
--
ALTER TABLE `einheit`
  ADD CONSTRAINT `einheit_ibfk_1` FOREIGN KEY (`zutatId`) REFERENCES `zutat` (`id`);

--
-- Constraints der Tabelle `rezeptbild`
--
ALTER TABLE `rezeptbild`
  ADD CONSTRAINT `rezeptbild_ibfk_1` FOREIGN KEY (`rezeptId`) REFERENCES `rezept` (`id`);

--
-- Constraints der Tabelle `typ`
--
ALTER TABLE `typ`
  ADD CONSTRAINT `typ_ibfk_1` FOREIGN KEY (`zutatId`) REFERENCES `zutat` (`id`);

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
