-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Jul 2023 um 10:57
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
-- Datenbank: `db_poolroboterersatzteilliste`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_bauteilgruppen`
--

CREATE TABLE `tbl_bauteilgruppen` (
  `IDBauteilgruppe` int(10) UNSIGNED NOT NULL,
  `FIDBauteilgruppe` int(10) UNSIGNED DEFAULT NULL,
  `Kategorie` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_konfigurator`
--

CREATE TABLE `tbl_konfigurator` (
  `IDKonfigurator` int(10) UNSIGNED NOT NULL,
  `FIDPoolroboter` int(10) UNSIGNED NOT NULL,
  `FIDKomponente` int(10) UNSIGNED NOT NULL,
  `Anzahl` decimal(4,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_marken`
--

CREATE TABLE `tbl_marken` (
  `IDMarke` int(10) UNSIGNED NOT NULL,
  `Markenname` varchar(64) NOT NULL,
  `Url` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_nutzungsintensitaeten`
--

CREATE TABLE `tbl_nutzungsintensitaeten` (
  `IDNutzungsintensitaet` int(10) UNSIGNED NOT NULL,
  `Nutzungsintensitaet` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_poolarten`
--

CREATE TABLE `tbl_poolarten` (
  `IDPoolart` int(10) UNSIGNED NOT NULL,
  `Poolart` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_produkte`
--

CREATE TABLE `tbl_produkte` (
  `IDProdukt` int(10) UNSIGNED NOT NULL,
  `FIDBauteilgruppe` int(10) UNSIGNED DEFAULT NULL,
  `Bezeichnung` varchar(64) NOT NULL,
  `Beschreibung` text NOT NULL,
  `Preis` decimal(6,2) NOT NULL,
  `FIDMarke` int(10) UNSIGNED NOT NULL,
  `FIDPoolart` int(10) UNSIGNED DEFAULT NULL,
  `FIDNutzungsintensitaet` int(10) UNSIGNED DEFAULT NULL,
  `Artikelnummer` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_bauteilgruppen`
--
ALTER TABLE `tbl_bauteilgruppen`
  ADD PRIMARY KEY (`IDBauteilgruppe`),
  ADD KEY `FIDBauteilgruppe` (`FIDBauteilgruppe`);

--
-- Indizes für die Tabelle `tbl_konfigurator`
--
ALTER TABLE `tbl_konfigurator`
  ADD PRIMARY KEY (`IDKonfigurator`),
  ADD KEY `FIDBauteil` (`FIDKomponente`),
  ADD KEY `tbl_konfigurator_ibfk_1` (`FIDPoolroboter`);

--
-- Indizes für die Tabelle `tbl_marken`
--
ALTER TABLE `tbl_marken`
  ADD PRIMARY KEY (`IDMarke`),
  ADD UNIQUE KEY `Markenname` (`Markenname`);

--
-- Indizes für die Tabelle `tbl_nutzungsintensitaeten`
--
ALTER TABLE `tbl_nutzungsintensitaeten`
  ADD PRIMARY KEY (`IDNutzungsintensitaet`),
  ADD UNIQUE KEY `Nutzungsintensitaet` (`Nutzungsintensitaet`);

--
-- Indizes für die Tabelle `tbl_poolarten`
--
ALTER TABLE `tbl_poolarten`
  ADD PRIMARY KEY (`IDPoolart`),
  ADD UNIQUE KEY `Poolart` (`Poolart`);

--
-- Indizes für die Tabelle `tbl_produkte`
--
ALTER TABLE `tbl_produkte`
  ADD PRIMARY KEY (`IDProdukt`),
  ADD UNIQUE KEY `Artikelnummer` (`Artikelnummer`),
  ADD UNIQUE KEY `FIDNutzungsintensitaet` (`FIDNutzungsintensitaet`),
  ADD KEY `FIDBauteilgruppe` (`FIDBauteilgruppe`),
  ADD KEY `FIDMarke` (`FIDMarke`),
  ADD KEY `FIDPoolart` (`FIDPoolart`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_bauteilgruppen`
--
ALTER TABLE `tbl_bauteilgruppen`
  MODIFY `IDBauteilgruppe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_konfigurator`
--
ALTER TABLE `tbl_konfigurator`
  MODIFY `IDKonfigurator` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_marken`
--
ALTER TABLE `tbl_marken`
  MODIFY `IDMarke` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_nutzungsintensitaeten`
--
ALTER TABLE `tbl_nutzungsintensitaeten`
  MODIFY `IDNutzungsintensitaet` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_poolarten`
--
ALTER TABLE `tbl_poolarten`
  MODIFY `IDPoolart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_produkte`
--
ALTER TABLE `tbl_produkte`
  MODIFY `IDProdukt` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_bauteilgruppen`
--
ALTER TABLE `tbl_bauteilgruppen`
  ADD CONSTRAINT `tbl_bauteilgruppen_ibfk_1` FOREIGN KEY (`FIDBauteilgruppe`) REFERENCES `tbl_bauteilgruppen` (`IDBauteilgruppe`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_konfigurator`
--
ALTER TABLE `tbl_konfigurator`
  ADD CONSTRAINT `tbl_konfigurator_ibfk_1` FOREIGN KEY (`FIDPoolroboter`) REFERENCES `tbl_produkte` (`IDProdukt`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_konfigurator_ibfk_2` FOREIGN KEY (`FIDKomponente`) REFERENCES `tbl_produkte` (`IDProdukt`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_produkte`
--
ALTER TABLE `tbl_produkte`
  ADD CONSTRAINT `tbl_produkte_ibfk_1` FOREIGN KEY (`FIDBauteilgruppe`) REFERENCES `tbl_bauteilgruppen` (`IDBauteilgruppe`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_produkte_ibfk_2` FOREIGN KEY (`FIDMarke`) REFERENCES `tbl_marken` (`IDMarke`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_produkte_ibfk_3` FOREIGN KEY (`FIDPoolart`) REFERENCES `tbl_poolarten` (`IDPoolart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_produkte_ibfk_4` FOREIGN KEY (`FIDNutzungsintensitaet`) REFERENCES `tbl_nutzungsintensitaeten` (`IDNutzungsintensitaet`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
