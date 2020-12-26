-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 17 déc. 2020 à 01:45
-- Version du serveur :  8.0.22-0ubuntu0.20.04.3
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `brice_voia`
--

-- --------------------------------------------------------

--
-- Structure de la table `packages`
--

CREATE TABLE `packages` (
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `numberPerson` int NOT NULL,
  `timeOut` double NOT NULL DEFAULT '7884000',
  `price` double NOT NULL,
  `logoPath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `packages`
--

INSERT INTO `packages` (`token`, `productToken`, `designation`, `description`, `numberPerson`, `timeOut`, `price`, `logoPath`) VALUES
('f204cc95a09b98ebe5c0966395cb8ae33380ac8d', '26785c28b8c9c237a4535eaa0a82cddf1825265f', 'Niveau 1', 'Inscrivez-vous dans ce programme pour apprendre comment monétiser vos activités sur les réseaux sociaux, décupler vos ventes, communiquer et entreprendre dans le secteur du numérique.', 10, 5184000, 5000, '/Data/default.jpg'),
('mqlksdjmflqksjdmflqksdjfmqlksdjmfqlskjdmfqskdjfmqslkdjfmqslkd', '26785c28b8c9c237a4535eaa0a82cddf1825265f', 'Niveau 2', 'Inscrivez-vous dans ce programme pour apprendre comment monétiser vos activités sur les réseaux sociaux, décupler vos ventes, communiquer et entreprendre dans le secteur du numérique.', 5, 5184000, 10000, '/Default/default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `logoPath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`token`, `designation`, `description`, `price`, `logoPath`) VALUES
('26785c28b8c9c237a4535eaa0a82cddf1825265f', 'Techo POP 4', 'Système d\'exploitation (OS) : Androïde 10.0 ; mesure de l\'écran : 6 pouces ; Processeur : Mediatek MT6580 ; RAM 2GB ; Espace intérieur : 32GB ; appareil photo : 5 MP ; Réseau : 3G UMTS HSDPA 850/1900, 4G FDD LTE, Ne prend pas en charge le réseau 4G LTE ; SIM : Deux tranches (nano-sim, double veille) ; Technologie de l\'écran : IPS LCD capacitive touchscreen 16, 16 millions de couleurs ; Batterie : 5000 MAH, Li-polymère, non amovible ; Caméra fond : 5 MP, Les fonctions de la caméra : Mise au point de géolocalisation, flash LED, Tournage vidéo : 720 pixel 30 ips, Caméra frontale : 8 MP.', 60000, '/Data/default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `sponsorships`
--

CREATE TABLE `sponsorships` (
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `godFatherToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `godDauhterToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subscribedPackages`
--

CREATE TABLE `subscribedPackages` (
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `packageToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subscriptionDate` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `subscribedPackages`
--

INSERT INTO `subscribedPackages` (`token`, `userToken`, `packageToken`, `subscriptionDate`) VALUES
('1d4de8946925d02705f51b0edd17c7ef495f5a87', '1d4de8946925d02705f51b0edd17c7ef495f3a87', 'f204cc95a09b98ebe5c0966395cb8ae33380ac8d', 1607657857),
('5c3612ec6230d99f1e794ecbd2dde2ac2a8c6d1c', 'd3d1cb82d8c2259035367c46bf4e82bc161bdb0f', 'mqlksdjmflqksjdmflqksdjfmqlksdjmfqlskjdmfqskdjfmqslkdjfmqslkd', 1607788559);

-- --------------------------------------------------------

--
-- Structure de la table `superAdmins`
--

CREATE TABLE `superAdmins` (
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('Homme','Femme') COLLATE utf8_unicode_ci NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `superAdmins`
--

INSERT INTO `superAdmins` (`token`, `username`, `password`, `lastName`, `firstName`, `email`, `sex`, `creationDate`) VALUES
('f9430e949bfc401b901cc331a743a13fd209af5d', 'bricebrice', '$2y$10$5jlzcZjbNTVaZAzpjFDMUOuk9QVe1rLMe7RuYgAJqilS.p1A8LsPW', 'TCHAPNGA', 'Brice', 'bricebrice@gmail.com', 'Homme', '2020-12-12 09:45:41');

-- --------------------------------------------------------

--
-- Structure de la table `trainings`
--

CREATE TABLE `trainings` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration_hour` int NOT NULL,
  `trainers` text COLLATE utf8_unicode_ci NOT NULL,
  `certified` tinyint(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `training_group_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `trainings`
--

INSERT INTO `trainings` (`id`, `name`, `slug`, `duration_hour`, `trainers`, `certified`, `description`, `training_group_slug`) VALUES
(1, 'Créer et monétiser sa chaîne youtube', 'creer-et-monetiser-sa-chaine-youtube', 1, '', 1, 'Média social de partage de  vidéos, Youtube nous ouvre une fenêtre sur le monde. Pour savoir comment créer une chaîne Youtube, quel type de contenu y fournir, comment se démarquer et surtout comment monétiser sa chaîne, rejoignez le programme VOIA.', 'Niveau 1, Niveau 2'),
(2, 'Créer et monétiser sa chaîne Facebook', 'creer-et-monetiser-sa-chaine-facebook\r\n', 1, '', 1, 'Allez à la rencontre de vos potentiels clients et rejoindre votre audience, réduire votre budget markéting sont quelques un des nombreux avantages que nous procurent une page Facebook, ceci à condition de  bien la gérer. Venez apprendre  comment susciter du trafic, et monétiser votre page Facebook.', 'Niveau 1, Niveau 2'),
(3, 'Faire du e-commerce avec son téléphone', 'faire-du-e-commerce-avec-son-telephone', 2, '', 1, 'Proposez des devis, commencez à vendre et conseillez des clients à  travers le monde depuis votre Smartphone en suivant cette formation pratique sur l’e-commerce.', 'Niveau 1, Niveau 2'),
(4, 'E-marketing', 'e-marketing', 2, '', 1, 'Ce module englobe l’ensemble applications du marketing à l’internet notamment l’influence et les réseaux sociaux, l’optimisation du commerce électronique et la  création de trafic au travers de tous supports numériques.', 'Niveau 1, Niveau 2'),
(5, 'Community management', 'community-management', 2, '', 1, 'Cette formation vous apprendra comment interagir avec des internautes et fédérer des communautés sur Internet pour le compte d\'une société, d\'une marque, d’une célébrité, d’une institution ou d\'une collectivité territoriale.', 'Niveau 1, Niveau 2'),
(6, 'Entrepreneuriat numérique', 'entrepreneuriat-numerique', 4, '', 1, 'Créer, manager et lever des fonds pour son entreprise numérique, telles seront les connaissances dont vous serez dotés après avoir suivi ce module.', 'Niveau 1, Niveau 2'),
(7, 'Montage vidéo avec son téléphone', 'montage-video-avec-son-telephone', 4, '', 1, 'Véritables outils à tout faire, les Smartphones nous permettent de téléphoner, jouer ou encore surfer sur les réseaux sociaux. Participez à cette formation et apprenez comment réaliser des vidéos professionnelles (clips, publicités….).', 'Niveau 1, Niveau 2');

-- --------------------------------------------------------

--
-- Structure de la table `trainings_groups`
--

CREATE TABLE `trainings_groups` (
  `id` int NOT NULL,
  `name` varchar(525) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `duration_month` int NOT NULL,
  `certified` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `trainings_groups`
--

INSERT INTO `trainings_groups` (`id`, `name`, `slug`, `description`, `duration_month`, `certified`) VALUES
(1, 'Communication digitale', 'communication-digitale', 'La communication digitale est un champ des sciences de l’information relatif à l\'utilisation de l’ensemble des médias numériques notamment le web, les médias sociaux ou les terminaux mobiles comme des canaux de diffusion, de partage et de création d\'informations. \r\nInscrivez-vous dans ce programme pour apprendre comment monétiser vos activités sur les réseaux sociaux, décupler vos ventes, communiquer et entreprendre dans le secteur du numérique.', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('normal','commercial') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('Homme','Femme') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Homme',
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admissionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`token`, `id`, `username`, `password`, `type`, `last_name`, `first_name`, `email`, `sex`, `matricule`, `admissionDate`) VALUES
('1d4de8946925d02705f51b0edd17c7ef495f3a87', 1, 'bricebrice1', '$2y$10$X8kJWGp9ltqfXRCwUdhASOu4C62VMQta41HutDvvfJPsCUBeb8k76', 'commercial', 'TCHAPNGA', 'Brice', 'bricebrice@gmail.com', 'Homme', '02047r01212', '2020-12-12 13:58:47'),
('d3d1cb82d8c2259035367c46bf4e82bc161bdb0f', 4, 'bricebrice2', '$2y$10$8bbJgV5YUtmCrpDdUb9JSeXkgxMPqdODr9WMBSFpoNUgRoQhrGTAa', 'commercial', 'TCHAPNGA', 'Brice', 'bricebrice2@gmail.com', 'Homme', '12036r01212', '2020-12-12 09:55:59');

-- --------------------------------------------------------

--
-- Structure de la table `usersWaiting`
--

CREATE TABLE `usersWaiting` (
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codeParainnage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('normal','commercial') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('Homme','Femme') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Homme',
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admissionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`token`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`token`);

--
-- Index pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD UNIQUE KEY `token` (`token`);

--
-- Index pour la table `subscribedPackages`
--
ALTER TABLE `subscribedPackages`
  ADD PRIMARY KEY (`token`);

--
-- Index pour la table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trainings_groups`
--
ALTER TABLE `trainings_groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `users` (`token`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `usersWaiting`
--
ALTER TABLE `usersWaiting`
  ADD UNIQUE KEY `users` (`token`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `trainings_groups`
--
ALTER TABLE `trainings_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
