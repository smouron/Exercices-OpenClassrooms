-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 06 déc. 2022 à 15:23
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `partage_de_recettes`
--
/* CREATE DATABASE `partage_de_recettes`*/;

-- --------------------------------------------------------

--
-- Structure de la table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT 'Nom de la recette',
  `recipe` text NOT NULL,
  `author` varchar(256) NOT NULL,
  `original_author` varchar(256) NOT NULL,
  `is_enabled` BOOLEAN NOT NULL COMMENT 'Actif ou pas actif',
  PRIMARY KEY (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6;

--
-- Déchargement des données de la table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `recipe`, `author`, `original_author`, `is_enabled`) VALUES
(1, 'Cassoulet', 'Le cassoulet est une spécialité régionale du Languedoc, à base de haricots secs, généralement blancs, et de viande. À son origine, il était à base de fèves. Le cassoulet tient son nom de la cassole en terre cuite émaillée dite caçòla1 en occitan et fabriquée à Issel.', 'mickael.andrieu@exemple.com', 'mickael.andrieu@exemple.com', 0),
(2, 'Couscous', 'Le couscous est d\'une part une semoule de blé dur préparée à l\'huile d\'olive (un des aliments de base traditionnel de la cuisine des pays du Maghreb) et d\'autre part, une spécialité culinaire issue de la cuisine berbère, à base de couscous, de légumes, d\'épices, d\'huile d\'olive et de viande (rouge ou de volaille) ou de poisson.', 'mickael.andrieu@exemple.com', 'mickael.andrieu@exemple.com', 1),
(3, 'Escalope milanaise', 'L\'escalope à la milanaise, ou escalope milanaise est une escalope panée, de viande de veau, traditionnellement prise dans le faux-filet. Historiquement, on la cuit avec du beurre. Elle est généralement servie avec salade ou frites, accompagnée de sauce mayonnaise. On peut y ajouter un filet de jus de citron.\n\nEn Italie, ce mets ne se sert pas avec des pâtes.', 'mathieu.nebra@exemple.com', 'mathieu.nebra@exemple.com', 1),
(4, 'Salade Romaine', 'La salade César est une recette de cuisine de salade composée de la cuisine américaine, traditionnellement préparée en salle à côté de la table, à base de laitue romaine, œuf dur, croûtons, parmesan et de « sauce César » à base de parmesan râpé, huile d\'olive, pâte d\'anchois, ail, vinaigre de vin, moutarde, jaune d\'œuf et sauce Worcestershire.', 'laurene.castor@exemple.com', 'laurene.castor@exemple.com', 1),
(5, 'Steack à cheval', 'Viande de boeuf hachée avec un oeuf sur le plat sur le dessus. Il existe une variante avec une tranche de bacon en', 'stephane.mouron@free.fr', 'stephane.mouron@free.fr', 1);


INSERT INTO `recipes` (`recipe_id`, `title`, `recipe`, `author`, `original_author`, `is_enabled`) VALUES
(1, 'Cassoulet', 'Recette du cassoulet', 'mickael.andrieu@exemple.com', 'mickael.andrieu@exemple.com', 0),
(2, 'Couscous', 'Recette du couscous', 'mickael.andrieu@exemple.com', 'mickael.andrieu@exemple.com', 1),
(3, 'Escalope milanaise', 'Recette de l\'escalope milanaise', 'mathieu.nebra@exemple.com', 'mathieu.nebra@exemple.com', 1),
(4, 'Salade Romaine', 'Recette de la saleade romaine', 'laurene.castor@exemple.com', 'laurene.castor@exemple.com', 1),
(5, 'Steack à cheval', 'Recette du steck à chevel', 'stephane.mouron@free.fr', 'stephane.mouron@free.fr', 1);
-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(128) NOT NULL COMMENT 'Nom et prénom',
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `age` int(11) NOT NULL,
  `pseudo` varchar(128) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `full_mane`, `email`, `password`, `age`, `pseudo`) VALUES
(1, 'Stéphane MOURON', 'stephane.mouron@free.fr', 'steph', 51, 'exca'),
(2, 'Laurène Castor', 'laurene.castor@exemple.com', '1234', 28, 'lcastor'),
(3, 'Mickaël Andrieu', 'mickael.andrieu@exemple.com', '4321', 34, 'micka'),
(4, 'Mathieu Nebra', 'mathieu.nebra@exemple.com', 'Mathieu', 34, 'mathnebra');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
