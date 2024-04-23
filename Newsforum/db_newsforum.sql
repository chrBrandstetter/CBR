-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Apr 2023 um 11:34
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_newsforum`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_antworten`
--

CREATE TABLE `tbl_antworten` (
  `IDAntworten` int(10) UNSIGNED NOT NULL,
  `Content` text NOT NULL,
  `FIDUser` int(10) UNSIGNED DEFAULT NULL,
  `FIDAntworten` int(10) UNSIGNED DEFAULT NULL,
  `Zeitpunkt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_antworten`
--

INSERT INTO `tbl_antworten` (`IDAntworten`, `Content`, `FIDUser`, `FIDAntworten`, `Zeitpunkt`) VALUES
(1, 'Wie geht es euh heute?', 1, NULL, '2023-04-17 09:30:58'),
(2, 'Mir geht es gut! ', 2, 1, '2023-04-17 09:30:58'),
(3, 'Mir geht es nicht so gut', 3, 1, '2023-04-17 09:31:54'),
(4, 'Warum denn nicht?', 2, 3, '2023-04-17 09:32:23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE `tbl_user` (
  `IDUser` int(10) UNSIGNED NOT NULL,
  `Emailadresse` varchar(32) NOT NULL,
  `Passwort` varchar(32) NOT NULL,
  `Vorname` varchar(32) NOT NULL,
  `Nachname` varchar(32) NOT NULL,
  `Geburtsdatum` date NOT NULL,
  `RegistrierungsZeit` timestamp NOT NULL DEFAULT current_timestamp(),
  `LoginZeit` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`IDUser`, `Emailadresse`, `Passwort`, `Vorname`, `Nachname`, `Geburtsdatum`, `RegistrierungsZeit`, `LoginZeit`) VALUES
(1, 'christoph.brandstetter@gmail.com', 'test123', 'Christoph', 'Brandstetter', '2023-04-07', '2023-04-17 09:29:57', '2023-04-17 09:29:57'),
(2, 'max.muster@mustermail.test', 'hallo123', 'Maximilian', 'Mustermann', '2023-04-06', '2023-04-17 09:29:57', '2023-04-17 09:29:57'),
(3, 'nina.brandstetter@gmail.com', 'hallihalli', 'Nina', 'Brandstetter', '2023-04-22', '2023-04-17 09:29:57', '2023-04-17 09:29:57');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_antworten`
--
ALTER TABLE `tbl_antworten`
  ADD PRIMARY KEY (`IDAntworten`),
  ADD KEY `FIDUser` (`FIDUser`),
  ADD KEY `tbl_antworten_ibfk_1` (`FIDAntworten`);

--
-- Indizes für die Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`IDUser`),
  ADD UNIQUE KEY `Emailadresse` (`Emailadresse`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_antworten`
--
ALTER TABLE `tbl_antworten`
  MODIFY `IDAntworten` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `IDUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_antworten`
--
ALTER TABLE `tbl_antworten`
  ADD CONSTRAINT `tbl_antworten_ibfk_1` FOREIGN KEY (`FIDAntworten`) REFERENCES `tbl_antworten` (`IDAntworten`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_antworten_ibfk_3` FOREIGN KEY (`FIDUser`) REFERENCES `tbl_user` (`IDUser`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
