-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db538131000.db.1and1.com
-- Généré le :  Lun 23 Mai 2016 à 13:48
-- Version du serveur :  5.1.73-log
-- Version de PHP :  5.4.45-0+deb7u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db538131000`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=151 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `cat_id`, `title`, `body`, `date`) VALUES
(113, 28, 'Wargames (1983)', '<img src="./img/wargames.jpg">', '2014-08-01 05:58:44'),
(114, 28, 'American Psycho (1991)', '<img src="./img/feedme3.jpg">', '2014-08-01 06:59:07'),
(115, 28, 'Pretty In Pink (1986)', '<img src="./img/prettyinpink.png">', '2014-08-01 07:01:55'),
(122, 26, 'The Primitives - Crash', '<iframe width="700" height="394" src="//www.youtube.com/embed/31abJDvQhuU" frameborder="0" allowfullscreen></iframe>', '2014-08-01 08:23:10'),
(123, 26, 'Martha & The Muffins - Echo Beach', '<iframe width="700" height="525" src="//www.youtube.com/embed/QEQkIEkxm7k" frameborder="0" allowfullscreen></iframe>', '2014-08-01 09:29:57'),
(124, 26, 'Siouxsie & The Banshees - Hong Kong Garden', '<iframe width="700" height="525" src="//www.youtube.com/embed/QG6bbnIwX6U" frameborder="0" allowfullscreen></iframe>', '2014-08-01 10:34:17'),
(129, 27, 'Ettore Sottsass', '<img src="./img/Sottsass2.jpg"/>\r\n\r\nLampe Tahiti.', '2014-08-01 11:36:42'),
(130, 27, 'Sarah Maisonobe', '<img src="./img/SarahMaison.jpg"/>\r\n\r\nQui fait également <a href="https://soundcloud.com/sarah-maison"> de la musique</a>.', '2014-08-01 12:49:28'),
(131, 27, 'David Hockney', '<img src=".img/Hockney.jpg"/> \r\n\r\n<em>Portrait of the Artist</em>.', '2014-08-01 13:15:14'),
(132, 27, 'Wire - 154', '<img src="./img/Wire154.png"/>\r\n\r\n1979, une bonne année.', '2014-08-01 13:20:47'),
(133, 27, 'Thomas Demand', '<img src="./img/ThomasDemand.jpg"/>\r\n\r\n<em>Control Room</em>', '2014-08-01 14:27:20'),
(134, 27, 'Alex Katz', '<img src=".img/AlexKatz.jpg"/>\r\n\r\n<em>Ives Field II</em>', '2014-08-01 14:30:39'),
(138, 27, 'Un salon sympathique', '<img src="./img/memphis.jpg"/>\r\n\r\n<a href="http://www.memphis-milano.it">Memphis, Milan</a>.', '2014-08-01 15:00:58'),
(140, 26, 'Tom Tom Club - Genius Of Love', '<iframe width="700" height="394" src="//www.youtube.com/embed/rfvx4l7Mc2g?t=9" frameborder="0" allowfullscreen></iframe>\r\n\r\n"Genius Of Love" connut une étonnante popularité auprès des auditeurs des radios noires, qui croyaient le groupe noir lui aussi, vu son sens manifeste du funk." (Simon Reynolds, <em>Rip It Up And Start Again</em>).', '2014-08-01 16:48:36'),
(144, 27, 'Alex Steinweiss', '<img src="./img/Steinwess1942.jpg">\r\n\r\nAlex Steinwess, <a href="http://www.brainpickings.org/index.php/2011/07/21/alex-steinweiss-taschen/">inventeur</a> de la pochette d''album. "Lorsqu''il réalisa une pochette pour l''<em>Héroïque</em> de Beethoven, les ventes grimpèrent de 800%. Il ne faut pas rire du design" (David Byrne, <em>Bicycle Diaries</em>).', '2014-08-01 17:02:29'),
(150, 27, 'Nathalie Du Pasquier', '<img src="./img/DuPaquier1.jpg"/>\r\n\r\n<a href="http://www.nathaliedupasquier.com">Classique</a>.', '2014-08-02 18:32:50');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(26, 'Walkman Video'),
(27, 'Bibelots'),
(28, 'Ecrans');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `website` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `name` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`name`, `password`) VALUES
('admin', '$2y$10$KiI8CWCKmh3yHAjM/sCCT.KwcqG/HwSaAImIEsO3A54P8ZIdsp/sC');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
