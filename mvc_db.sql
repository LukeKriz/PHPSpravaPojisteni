-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 19. led 2023, 13:39
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `mvc_db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `pojistenci`
--

CREATE TABLE `pojistenci` (
  `person_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `post_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `pojisteni`
--

CREATE TABLE `pojisteni` (
  `insurance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `druh_pojisteni` varchar(255) NOT NULL,
  `castka` int(100) NOT NULL,
  `predmet_pojisteni` varchar(255) NOT NULL,
  `platnost_od` date NOT NULL,
  `platnost_do` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `udalosti`
--

CREATE TABLE `udalosti` (
  `event_id` int(11) NOT NULL,
  `pojisteni_id` int(11) NOT NULL,
  `druh_udalosti` varchar(255) NOT NULL,
  `cena_skody` int(255) NOT NULL,
  `datum_udalosti` date NOT NULL,
  `aktualni_stav` varchar(255) NOT NULL,
  `popis_skody` varchar(255) NOT NULL,
  `vyplaceno` int(255) NOT NULL,
  `datum_vyplaceni` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `uzivatele_id` int(11) NOT NULL,
  `jmeno` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `heslo` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`uzivatele_id`, `jmeno`, `heslo`, `admin`) VALUES
(1, 'admin', '$2y$10$r6T4Uet1h3LNbCyYUOdrP.dX8uyegxpkgN8RcPJ9Y.W8ZZKxyQTxO', 1);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `pojistenci`
--
ALTER TABLE `pojistenci`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexy pro tabulku `pojisteni`
--
ALTER TABLE `pojisteni`
  ADD PRIMARY KEY (`insurance_id`),
  ADD KEY `Pojistka` (`user_id`);

--
-- Indexy pro tabulku `udalosti`
--
ALTER TABLE `udalosti`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `udalostiKey` (`pojisteni_id`);

--
-- Indexy pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`uzivatele_id`),
  ADD UNIQUE KEY `jmeno` (`jmeno`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `pojistenci`
--
ALTER TABLE `pojistenci`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `pojisteni`
--
ALTER TABLE `pojisteni`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `udalosti`
--
ALTER TABLE `udalosti`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `uzivatele_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `pojisteni`
--
ALTER TABLE `pojisteni`
  ADD CONSTRAINT `Pojistka` FOREIGN KEY (`user_id`) REFERENCES `pojistenci` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `udalosti`
--
ALTER TABLE `udalosti`
  ADD CONSTRAINT `udalostiKey` FOREIGN KEY (`pojisteni_id`) REFERENCES `pojisteni` (`insurance_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
