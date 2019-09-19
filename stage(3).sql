-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 19 Septembre 2019 à 16:06
-- Version du serveur :  5.7.14
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `stage`
--

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190506111152', '2019-05-06 11:12:06'),
('20190520120815', '2019-05-20 12:08:22'),
('20190520191841', '2019-05-20 19:18:59'),
('20190522214506', '2019-05-22 21:45:41'),
('20190603120120', '2019-06-03 12:01:26'),
('20190603141348', '2019-06-03 14:13:54'),
('20190603141524', '2019-06-03 14:15:29'),
('20190607164159', '2019-06-07 16:42:07'),
('20190607164530', '2019-06-07 16:45:35'),
('20190607173956', '2019-06-07 17:40:02'),
('20190608154838', '2019-06-08 15:48:45'),
('20190608155835', '2019-06-08 15:59:30'),
('20190608160046', '2019-06-08 16:00:50'),
('20190608160608', '2019-06-08 16:06:17'),
('20190608182930', '2019-06-08 18:29:34'),
('20190608220619', '2019-06-08 22:06:25'),
('20190613113311', '2019-06-13 11:33:19'),
('20190616104241', '2019-06-16 10:42:48'),
('20190626103435', '2019-06-26 10:34:43'),
('20190627201555', '2019-06-27 20:16:09'),
('20190628112739', '2019-06-28 11:27:47'),
('20190628113049', '2019-06-28 11:30:54'),
('20190802112623', '2019-08-02 11:26:46'),
('20190802114651', '2019-08-02 11:46:56'),
('20190802122703', '2019-08-02 12:27:10'),
('20190802124257', '2019-08-02 12:43:03'),
('20190802173557', '2019-08-02 17:36:48'),
('20190821201510', '2019-08-21 20:15:20'),
('20190902155624', '2019-09-02 15:56:28'),
('20190903172416', '2019-09-03 17:24:24'),
('20190903173948', '2019-09-03 17:39:53'),
('20190912112955', '2019-09-12 11:30:05');

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `remorque_id` int(11) NOT NULL,
  `operation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `parking_id` int(11) DEFAULT NULL,
  `quai_id` int(11) DEFAULT NULL,
  `traction_id` int(11) DEFAULT NULL,
  `planning_id` int(11) DEFAULT NULL,
  `affectation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `operation`
--

INSERT INTO `operation` (`id`, `remorque_id`, `operation`, `date_creation`, `parking_id`, `quai_id`, `traction_id`, `planning_id`, `affectation`) VALUES
(204, 47, '2', '2019-09-19 00:14:53', NULL, NULL, NULL, 1, 'lille'),
(205, 43, '2', '2019-09-19 11:24:40', 1, NULL, 5, NULL, 'Alsdorf Cologne'),
(207, 42, '4', '2019-09-19 00:25:29', 1, NULL, NULL, NULL, 'Annecy Grenoble'),
(208, 34, '2', '2019-09-19 16:59:38', NULL, 3, NULL, NULL, NULL),
(209, 46, '2', '2019-09-19 18:05:29', 5, NULL, 2, NULL, 'Koblenz Mannheim'),
(210, 48, '4', '2019-09-19 17:25:30', 2, NULL, NULL, NULL, NULL),
(211, 35, '4', '2019-09-19 17:36:48', 1, NULL, NULL, NULL, NULL),
(212, 36, '2', '2019-09-19 18:04:21', NULL, 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `parking`
--

CREATE TABLE `parking` (
  `id` int(11) NOT NULL,
  `denomination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `parking`
--

INSERT INTO `parking` (`id`, `denomination`) VALUES
(1, 'P1'),
(2, 'P2'),
(3, 'P3'),
(4, 'P4'),
(5, 'RUE');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `tournee` int(11) NOT NULL,
  `chauffeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloquer` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `planning`
--

INSERT INTO `planning` (`id`, `tournee`, `chauffeur`, `tracteur`, `bloquer`) VALUES
(1, 300, 'Frédéric Kuik', '1TDZ439', 0),
(2, 301, 'Christian Albrecht', '1NAL270', 0),
(3, 302, 'Mickaël Daully', '1TDZ439', 0),
(4, 303, 'Philippe Kahlouche', '1TDZ456', 0),
(5, 304, 'Eric Catteau', '1NAL341', 0),
(6, 305, 'Mohammed El Bhounouni', '1NAL236', 0),
(7, 306, 'Patrick Legas', '1NBF277', 0),
(8, 307, 'Frédéric Vermeire', '1NAL316', 0),
(9, 308, 'Cédric Bétermier', '1TDZ443', 0),
(10, 309, 'David Flipot', '1NAL361', 0),
(11, 310, 'Thomas Decaluwé', '1PFP931', 0),
(12, 311, 'David Villers', '1NAL298', 0),
(13, 312, 'Christophe Phélizon', '1TDZ464', 0),
(14, 313, 'Aurélien Gilmet', '1NBF292', 0),
(15, 314, 'Christophe Devos', '1PGL507', 0),
(16, 315, 'Dominique Polet', '1TDZ436', 0),
(17, 316, 'Frédéric Jallet', '1TER209', 0),
(18, 317, 'Jefferson Catteaux', 'Externe', 0),
(19, 318, 'Patrick Guilmin', '1TDZ451', 0),
(20, 319, 'Sébastien Delbecq', '1NBF259', 0),
(21, 320, 'B&T Trans', 'Externe', 0),
(22, 321, 'Deluxe', 'Externe', 0),
(23, 322, 'Deluxe', 'Externe', 0),
(24, 323, 'Deluxe', 'Externe', 0),
(25, 325, 'Analexis', 'Externe', 0),
(26, 326, 'Analexis', 'Externe', 0),
(27, 327, 'Analexis', 'Externe', 0),
(28, 328, 'IDM', 'Externe', 0),
(29, 329, 'IDM', 'Externe', 0),
(30, 330, 'GHS', 'Externe', 0),
(31, 335, 'Verso', 'Externe', 0);

-- --------------------------------------------------------

--
-- Structure de la table `quai`
--

CREATE TABLE `quai` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `quai`
--

INSERT INTO `quai` (`id`, `numero`, `maintenance`) VALUES
(2, 102, 1),
(3, 103, 0),
(4, 104, 0),
(5, 105, 0),
(6, 106, 0),
(7, 107, 0),
(8, 108, 0),
(9, 109, 0),
(10, 110, 0),
(11, 111, 0),
(12, 113, 0),
(13, 114, 0),
(14, 115, 0),
(15, 116, 0),
(16, 117, 0),
(17, 118, 0),
(18, 119, 0),
(19, 120, 0),
(20, 121, 0),
(21, 123, 0),
(22, 124, 0),
(23, 125, 0),
(24, 126, 1),
(25, 127, 0),
(26, 128, 0),
(27, 129, 0),
(28, 130, 0),
(29, 139, 0),
(30, 140, 0),
(31, 141, 0),
(32, 142, 0),
(33, 144, 0),
(34, 145, 0),
(35, 146, 0),
(36, 147, 0),
(37, 148, 0),
(38, 149, 0),
(39, 150, 0),
(40, 151, 0),
(41, 152, 0),
(42, 153, 0),
(43, 154, 0),
(44, 201, 0),
(45, 202, 0),
(46, 203, 0),
(47, 204, 0),
(48, 205, 0),
(49, 206, 0),
(50, 207, 0),
(51, 208, 0),
(52, 209, 0),
(53, 210, 0),
(54, 211, 0),
(55, 213, 0),
(56, 214, 0),
(57, 215, 0),
(58, 216, 0),
(59, 217, 0),
(60, 218, 0),
(61, 219, 0),
(62, 220, 0),
(63, 222, 0),
(64, 223, 0),
(65, 224, 0),
(66, 225, 0),
(67, 226, 0),
(68, 227, 0),
(69, 228, 0),
(70, 229, 0),
(71, 230, 1),
(72, 232, 0),
(73, 233, 0),
(74, 234, 0),
(75, 235, 0),
(76, 236, 0),
(77, 237, 0),
(78, 238, 0),
(79, 239, 0),
(80, 240, 0),
(81, 241, 0),
(82, 242, 0),
(83, 244, 0),
(84, 245, 0),
(85, 246, 0),
(86, 247, 0),
(87, 248, 0),
(88, 249, 0),
(89, 250, 0),
(90, 251, 0),
(91, 252, 0),
(92, 253, 0),
(96, 254, 0),
(97, 101, 0);

-- --------------------------------------------------------

--
-- Structure de la table `remorque`
--

CREATE TABLE `remorque` (
  `id` int(11) NOT NULL,
  `remorque` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `immatriculation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_edition` datetime NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `maintenance_raison` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vide` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `remorque`
--

INSERT INTO `remorque` (`id`, `remorque`, `immatriculation`, `date_creation`, `date_edition`, `maintenance`, `type_id`, `maintenance_raison`, `vide`) VALUES
(34, 'SA17', '1-QCL-82', '2019-07-07 23:18:49', '2019-09-18 13:00:02', 0, 6, '', 1),
(35, 'SA18', '1-QCL-83', '2019-07-07 23:18:49', '2019-09-18 13:00:16', 0, 6, NULL, 1),
(36, 'SA19', '1-QCL-84', '2019-07-07 23:18:49', '2019-09-18 13:00:28', 0, 6, NULL, 0),
(42, 'SA10', '1-QCL-810', '2019-07-07 23:18:49', '2019-09-18 12:58:03', 0, 7, '', 1),
(43, 'SA11', '1-QCL-811', '2019-07-07 23:18:49', '2019-09-18 12:58:12', 0, 7, NULL, 1),
(44, 'SA12', '1-QCL-812', '2019-07-07 23:18:49', '2019-09-18 12:58:24', 0, 8, '', 1),
(45, 'SA13', '1-QCL-813', '2019-07-07 23:18:49', '2019-09-18 12:58:34', 1, 8, 'TEST', 0),
(46, 'SA14', '1-QCL-814', '2019-07-07 23:18:49', '2019-09-18 12:58:46', 0, 8, NULL, 1),
(47, 'SA15', '1-QCL-815', '2019-07-07 23:18:49', '2019-09-18 12:58:59', 0, 8, NULL, 1),
(48, 'SA16', '1-QCL-816', '2019-07-07 23:18:49', '2019-09-18 12:59:17', 0, 8, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `remorque_type`
--

CREATE TABLE `remorque_type` (
  `id` int(11) NOT NULL,
  `denomination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `remorque_type`
--

INSERT INTO `remorque_type` (`id`, `denomination`) VALUES
(6, 'Bâché'),
(7, 'Double Plancher Hayon'),
(8, 'Double Plancher'),
(9, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `traction`
--

CREATE TABLE `traction` (
  `id` int(11) NOT NULL,
  `affectation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `traction`
--

INSERT INTO `traction` (`id`, `affectation`, `quai_id`) VALUES
(1, 'Dartford', 2),
(2, 'Koblenz Mannheim', 5),
(3, 'Hamburg', 8),
(4, 'Bremen', 9),
(5, 'Alsdorf Cologne', 11),
(6, 'Berlin', 17),
(7, 'Strasbourg', 18),
(8, 'Freiburg', 19),
(9, 'Nantes', 20),
(10, 'Rennes', 21),
(11, 'Verrie', 22),
(12, 'Wissous Orléans', 23),
(13, 'Bordeaux', 26),
(14, 'Tours Niort', 25),
(15, 'Toulouse', 27),
(16, 'Annecy Grenoble', 29),
(17, 'Clermont St Etienne', 30),
(18, 'Hub Clermont', 31),
(19, 'Lyon', 32),
(20, 'Bad Salzuflen', 46),
(21, 'Zevenaar', 48);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_edition` datetime NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `role`, `date_creation`, `date_edition`, `username`, `password`) VALUES
(1, 'Moury', 'Laurent', '4', '2019-05-20 16:14:07', '2019-07-07 23:24:47', 'laurent', 'tila'),
(15, 'admin', 'admin', '4', '2019-07-04 22:16:51', '2019-07-04 22:16:51', 'admin', '$2y$12$e1HlTzsG.eQQZGDH/1GGjeogUqREtxyDChPbV3ZEazk2p.R1XvxkS'),
(17, 'quai', 'quai', '2', '2019-07-07 23:23:30', '2019-07-07 23:23:30', 'quai', '$2y$12$tJ/HmkWKAuMsql42lCEwjuZrGufIh18O3fsWCiH1It.v6gLP.ja0.'),
(18, 'parking', 'parking', '3', '2019-07-07 23:24:00', '2019-07-07 23:24:00', 'parking', '$2y$12$X5xqrvQbZU5/BgHp76dzGuZ79gZbsuk/Dtf2whJGP8IL6NKOjrUHG'),
(19, 'employe', 'employe', '1', '2019-07-07 23:24:30', '2019-07-07 23:24:30', 'employe', '$2y$12$O2lYwQOLqm/Ne4wn8WfUWONkaJ9Hi9KxZA0vUICVPfxP6fxNwUxKO');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1981A66D41A32AC4` (`remorque_id`),
  ADD UNIQUE KEY `UNIQ_1981A66DF7E062C5` (`quai_id`),
  ADD UNIQUE KEY `UNIQ_1981A66DACFB21A3` (`traction_id`),
  ADD UNIQUE KEY `UNIQ_1981A66D3D865311` (`planning_id`),
  ADD KEY `IDX_1981A66DF17B2DD` (`parking_id`);

--
-- Index pour la table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `quai`
--
ALTER TABLE `quai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Index pour la table `remorque`
--
ALTER TABLE `remorque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_644A4CAC54C8C93` (`type_id`);

--
-- Index pour la table `remorque_type`
--
ALTER TABLE `remorque_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traction`
--
ALTER TABLE `traction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C0C1AC30F7E062C5` (`quai_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;
--
-- AUTO_INCREMENT pour la table `parking`
--
ALTER TABLE `parking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `quai`
--
ALTER TABLE `quai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT pour la table `remorque`
--
ALTER TABLE `remorque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT pour la table `remorque_type`
--
ALTER TABLE `remorque_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `traction`
--
ALTER TABLE `traction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `FK_1981A66D3D865311` FOREIGN KEY (`planning_id`) REFERENCES `planning` (`id`),
  ADD CONSTRAINT `FK_1981A66D41A32AC4` FOREIGN KEY (`remorque_id`) REFERENCES `remorque` (`id`),
  ADD CONSTRAINT `FK_1981A66DACFB21A3` FOREIGN KEY (`traction_id`) REFERENCES `traction` (`id`),
  ADD CONSTRAINT `FK_1981A66DF17B2DD` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`),
  ADD CONSTRAINT `FK_1981A66DF7E062C5` FOREIGN KEY (`quai_id`) REFERENCES `quai` (`id`);

--
-- Contraintes pour la table `remorque`
--
ALTER TABLE `remorque`
  ADD CONSTRAINT `FK_644A4CAC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `remorque_type` (`id`);

--
-- Contraintes pour la table `traction`
--
ALTER TABLE `traction`
  ADD CONSTRAINT `FK_C0C1AC30F7E062C5` FOREIGN KEY (`quai_id`) REFERENCES `quai` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
