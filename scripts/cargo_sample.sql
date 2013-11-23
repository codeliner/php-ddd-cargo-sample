--
-- Datenbank: `cargo_sample`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `tracking_id` varchar(13) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`tracking_id`)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `voyage`
--

CREATE TABLE IF NOT EXISTS `voyage` (
  `voyage_number` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  PRIMARY KEY (`voyage_number`)
);