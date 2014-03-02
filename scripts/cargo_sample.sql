
--
-- Datenbank: `cargo_sample`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `tracking_id` varchar(36) NOT NULL,
  `origin` varchar(250) NOT NULL,
  `route_specification_id` int(11) NOT NULL,
  `itinerary_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tracking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itinerary`
--

CREATE TABLE IF NOT EXISTS `itinerary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `route_specification`
--

CREATE TABLE IF NOT EXISTS `route_specification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origin` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;
