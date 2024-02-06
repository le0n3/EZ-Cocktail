

Create DATABASE ez_cocktail;

Use [ez_cocktail]
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Tabellenstruktur für Tabelle `einheit`
--

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
    (1, 'Jacky Cola', 'erklrt sich ziemlich von allein', 'einfach alles in ein Glas Uns Fertig');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezeptbild`
--

CREATE TABLE `rezeptbild` (
                              `id` int(11) NOT NULL,
                              `rezeptId` int(11) DEFAULT NULL,
                              `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rezeptbild`
--

INSERT INTO `rezeptbild` (`id`, `rezeptId`, `url`) VALUES
    (0, 1, 'https://media3.giphy.com/media/TcdpZwYDPlWXC/giphy.gif');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `rezeptgesamt`
-- (Siehe unten für die tatsächliche Ansicht)
--
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

CREATE TABLE `typ` (
                       `id` int(11) NOT NULL,
                       `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `typ`
--

INSERT INTO `typ` (`id`, `name`) VALUES
                                     (1, 'Softdrink'),
                                     (2, 'Wihskey'),
                                     (3, 'Frucht');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat`
--

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
                                                                             (1, 'Cola', 'Coca Cola', 1, 2),
                                                                             (2, 'Jack Daniels', 'knallt halt nh', 2, 1),
                                                                             (3, 'Zitrone', 'boah', 3, 3);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `zutatgesamt`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `zutatgesamt` (
                               `id` int(11)
    ,`typ` varchar(255)
    ,`name` varchar(255)
    ,`beschreibung` varchar(255)
    ,`menge` float
    ,`einheit` varchar(10)
);

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
                                                           (1, 1000, 1),
                                                           (2, 100, 3),
                                                           (5, 500, 2);

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
                                                                      (1, 120, 1, 1),
                                                                      (3, 4, 1, 2),
                                                                      (4, 1, 1, 3);

-- --------------------------------------------------------

--
-- Struktur des Views `rezeptgesamt`
--
DROP TABLE IF EXISTS `rezeptgesamt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rezeptgesamt`  AS SELECT `rezept`.`id` AS `id`, `rezept`.`name` AS `name`, `rezept`.`beschreibung` AS `beschreibung`, `rezept`.`zubereitung` AS `zubereitung`, `rezeptbild`.`url` AS `url` FROM (`rezept` left join `rezeptbild` on(`rezept`.`id` = `rezeptbild`.`rezeptId`)) ;

-- --------------------------------------------------------

--
-- Struktur des Views `zutatgesamt`
--
DROP TABLE IF EXISTS `zutatgesamt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `zutatgesamt`  AS SELECT `zutat`.`id` AS `id`, `typ`.`name` AS `typ`, `zutat`.`name` AS `name`, `zutat`.`beschreibung` AS `beschreibung`, `zutatinventar`.`menge` AS `menge`, `einheit`.`einheitkuerzel` AS `einheit` FROM (((`zutat` left join `typ` on(`zutat`.`typId` = `typ`.`id`)) left join `einheit` on(`zutat`.`einheitId` = `einheit`.`id`)) left join `zutatinventar` on(`zutat`.`id` = `zutatinventar`.`zutatId`)) ;

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
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `rezept`
--
ALTER TABLE `rezept`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `typ`
--
ALTER TABLE `typ`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `zutat`
--
ALTER TABLE `zutat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `zutatinventar`
--
ALTER TABLE `zutatinventar`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `zutat_rezept`
--
ALTER TABLE `zutat_rezept`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
