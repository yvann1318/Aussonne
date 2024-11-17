-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 04 mai 2024 à 16:14
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ym_aussonne`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `idAdherent` int NOT NULL AUTO_INCREMENT,
  `nomAdherent` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prenomAdherent` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ageAdherent` int NOT NULL,
  `sexeAdherent` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loginAdherent` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pwdAdherent` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idAdherent`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`idAdherent`, `nomAdherent`, `prenomAdherent`, `ageAdherent`, `sexeAdherent`, `loginAdherent`, `pwdAdherent`) VALUES
(1, 'Dupont', 'Pierre', 7, 'Masculin', 'pDupont', '26d3649a8402892cbd78263f576cda23'),
(2, 'Dubois', 'Vincent', 10, 'Masculin', 'vDubois', 'b6c7790658f2cabc77cfb445f3530cf4'),
(3, 'Durant', 'Jacques', 6, 'Masculin', 'jDurant', '01e8e31b6f11b0872c662c306b3e87c9'),
(4, 'Fleur', 'Sophie', 7, 'Féminin', 'sFleur', '520a72f041586acdeb770d35388ce6c4'),
(5, 'Lopez', 'Gérard', 9, 'Féminin', 'gLopez', '7327ad631d4bc778a432148ae078863a');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `nomAdmin` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prenomAdmin` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loginAdmin` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pwdAdmin` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`idAdmin`, `nomAdmin`, `prenomAdmin`, `loginAdmin`, `pwdAdmin`) VALUES
(1, 'LeFirst', 'Vincent', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'LeSecond', 'Pierre', 'admin2', 'c84258e9c39059a89ab77d846ddab909');

-- --------------------------------------------------------

--
-- Structure de la table `competent`
--

DROP TABLE IF EXISTS `competent`;
CREATE TABLE IF NOT EXISTS `competent` (
  `idSpecialite` int NOT NULL,
  `idEntraineur` int NOT NULL,
  PRIMARY KEY (`idSpecialite`,`idEntraineur`),
  KEY `fk_competent_entraineur` (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competent`
--

INSERT INTO `competent` (`idSpecialite`, `idEntraineur`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

DROP TABLE IF EXISTS `entraineur`;
CREATE TABLE IF NOT EXISTS `entraineur` (
  `idEntraineur` int NOT NULL AUTO_INCREMENT,
  `nomEntraineur` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `loginEntraineur` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pwdEntraineur` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entraineur`
--

INSERT INTO `entraineur` (`idEntraineur`, `nomEntraineur`, `loginEntraineur`, `pwdEntraineur`) VALUES
(1, 'Delbert', 'Delbert', '0b02931216d535031eea687d3b687eea'),
(2, 'Dubois', 'Dubois', '2da1fecc769db814efa8c4568a801ed3'),
(3, 'Bousquet', 'Bousquet', '3938b2f3fd8ef725d61e8f92c7dee52b');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `idEquipe` int NOT NULL,
  `nomEquipe` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nbrPlaceEquipe` int NOT NULL,
  `ageMinEquipe` int NOT NULL,
  `ageMaxEquipe` int NOT NULL,
  `sexeEquipe` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idSpecialite` int NOT NULL,
  `idEntraineur` int NOT NULL,
  PRIMARY KEY (`idEquipe`),
  KEY `fk_equipe_specialite` (`idSpecialite`),
  KEY `fk_equipe_entraineur` (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`idEquipe`, `nomEquipe`, `nbrPlaceEquipe`, `ageMinEquipe`, `ageMaxEquipe`, `sexeEquipe`, `idSpecialite`, `idEntraineur`) VALUES
(1, 'lutin', 10, 5, 10, 'Féminin', 1, 1),
(2, 'spartiate', 3, 5, 9, 'Masculin', 2, 1),
(3, 'koko', 14, 5, 10, 'Féminin', 4, 3),
(4, 'Los nignos', 3, 11, 15, 'Féminin', 5, 3);

--
-- Déclencheurs `equipe`
--
DROP TRIGGER IF EXISTS `insert equipe`;
DELIMITER $$
CREATE TRIGGER `insert equipe` BEFORE INSERT ON `equipe` FOR EACH ROW BEGIN
	DECLARE nbEquipesEntraineur int;
    SET nbEquipesEntraineur = (
        select count(equipe.idEquipe) 
        from equipe 
        WHERE equipe.idEntraineur = new.idEntraineur);
    if (nbEquipesEntraineur >= 3) THEN
    	signal SQLSTATE '10012' set message_text = 					'L etraineur s occupe deja de 3 equipes';
   end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert equipe competances entraineur`;
DELIMITER $$
CREATE TRIGGER `insert equipe competances entraineur` BEFORE INSERT ON `equipe` FOR EACH ROW BEGIN
    DECLARE competenceEntraineur int;
    SET competenceEntraineur = (
        SELECT COUNT(*)
        FROM competent
        WHERE competent.idEntraineur = NEW.idEntraineur
          AND competent.idSpecialite = NEW.idSpecialite);

    IF (competenceEntraineur = 0) THEN
        SIGNAL SQLSTATE '10016' SET MESSAGE_TEXT = 'L entraineur n est pas compétent dans cette spécialité';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update equipe`;
DELIMITER $$
CREATE TRIGGER `update equipe` BEFORE UPDATE ON `equipe` FOR EACH ROW BEGIN
	DECLARE nbEquipesEntraineur int;
    SET nbEquipesEntraineur = (
        select count(equipe.idEquipe) 
        from equipe 
        WHERE equipe.idEntraineur = new.idEntraineur);
    if (nbEquipesEntraineur >= 3) THEN
    	signal SQLSTATE '10012' set message_text = 'L etraineur s occupe deja de 3 equipes';
   end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update equipe competances entraineur`;
DELIMITER $$
CREATE TRIGGER `update equipe competances entraineur` BEFORE UPDATE ON `equipe` FOR EACH ROW BEGIN
    DECLARE competenceEntraineur int;
    SET competenceEntraineur = (
        SELECT COUNT(*)
        FROM competent
        WHERE competent.idEntraineur = NEW.idEntraineur
          AND competent.idSpecialite = NEW.idSpecialite);

    IF (competenceEntraineur = 0) THEN
        SIGNAL SQLSTATE '10016' SET MESSAGE_TEXT = 'L entraineur n est pas compétent dans cette spécialité';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `logactionutilisateur`
--

DROP TABLE IF EXISTS `logactionutilisateur`;
CREATE TABLE IF NOT EXISTS `logactionutilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `temps` date NOT NULL,
  `idUtilisateur` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logActionutilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=490 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logactionutilisateur`
--

INSERT INTO `logactionutilisateur` (`id`, `action`, `temps`, `idUtilisateur`) VALUES
(286, 'insert entraineur 8 : spécialité', '2024-02-14', 'admin'),
(287, 'connexion', '2014-02-24', 'admin'),
(288, 'update entraineur 1', '2024-02-14', 'admin'),
(289, 'update entraineur 1', '2024-02-14', 'admin'),
(290, 'update entraineur 1', '2024-02-14', 'admin'),
(291, 'connexion', '2015-02-24', 'admin'),
(292, 'insert equipe 5', '2024-02-15', 'admin'),
(293, 'insert equipe 6', '2024-02-15', 'admin'),
(294, 'insert equipe 5', '2024-02-15', 'admin'),
(295, 'update entraineur 1', '2024-02-15', 'admin'),
(296, 'update entraineur 1', '2024-02-15', 'admin'),
(297, 'update spécialité 8', '2024-02-15', 'admin'),
(298, 'update spécialité 8', '2024-02-15', 'admin'),
(299, 'connexion', '2015-02-24', 'Delbert'),
(300, 'connexion', '2015-02-24', 'admin'),
(301, 'connexion', '2015-02-24', 'pDupont'),
(302, 'connexion', '2015-02-24', 'admin'),
(303, 'insert equipe 13', '2024-02-15', 'admin'),
(304, 'insert equipe 13', '2024-02-15', 'admin'),
(305, 'modification ahderent 13', '2024-02-15', 'admin'),
(306, 'modification ahderent 13', '2024-02-15', 'admin'),
(307, 'modification ahderent 13', '2024-02-15', 'admin'),
(308, 'modification ahderent 13', '2024-02-15', 'admin'),
(309, 'modification ahderent 13', '2024-02-15', 'admin'),
(310, 'modification ahderent 13', '2024-02-15', 'admin'),
(311, 'insert equipe 14', '2024-02-15', 'admin'),
(312, 'insert equipe 15', '2024-02-15', 'admin'),
(313, 'insert equipe 16', '2024-02-15', 'admin'),
(314, 'insert equipe 6', '2024-02-15', 'admin'),
(315, 'insert equipe 7', '2024-02-15', 'admin'),
(316, 'insert equipe 6', '2024-02-15', 'admin'),
(317, 'insert equipe 6', '2024-02-15', 'admin'),
(318, 'insert equipe 6', '2024-02-15', 'admin'),
(319, 'insert equipe 6', '2024-02-15', 'admin'),
(320, 'insert equipe 7', '2024-02-15', 'admin'),
(321, 'insert equipe 8', '2024-02-15', 'admin'),
(322, 'insert equipe 9', '2024-02-15', 'admin'),
(323, 'connexion', '2015-02-24', 'admin'),
(324, 'insert equipe 6', '2024-02-15', 'admin'),
(325, 'insert equipe 7', '2024-02-15', 'admin'),
(326, 'insert equipe 6', '2024-02-15', 'admin'),
(327, 'insert equipe 6', '2024-02-15', 'admin'),
(328, 'modification ahderent 1', '2024-02-15', 'admin'),
(329, 'modification ahderent 1', '2024-02-15', 'admin'),
(330, 'modification ahderent 1', '2024-02-15', 'admin'),
(331, 'modification ahderent 1', '2024-02-15', 'admin'),
(332, 'modification ahderent 1', '2024-02-15', 'admin'),
(333, 'modification ahderent 1', '2024-02-15', 'admin'),
(334, 'modification ahderent 1', '2024-02-15', 'admin'),
(335, 'connexion', '2015-02-24', 'admin'),
(336, 'modification ahderent 1', '2024-02-15', 'admin'),
(337, 'modification ahderent 1', '2024-02-15', 'admin'),
(338, 'modification ahderent 1', '2024-02-15', 'admin'),
(339, 'modification ahderent 1', '2024-02-15', 'admin'),
(340, 'modification ahderent 1', '2024-02-15', 'admin'),
(341, 'modification ahderent 1', '2024-02-15', 'admin'),
(342, 'connexion', '2015-02-24', 'admin'),
(343, 'modification ahderent 1', '2024-02-15', 'admin'),
(344, 'modification ahderent 1', '2024-02-15', 'admin'),
(345, 'modification ahderent 1', '2024-02-15', 'admin'),
(346, 'modification ahderent 1', '2024-02-15', 'admin'),
(347, 'modification ahderent 1', '2024-02-15', 'admin'),
(348, 'connexion', '2015-02-24', 'admin'),
(349, 'modification ahderent 1', '2024-02-15', 'admin'),
(350, 'modification ahderent 1', '2024-02-15', 'admin'),
(351, 'modification ahderent 5', '2024-02-15', 'admin'),
(352, 'modification ahderent 5', '2024-02-15', 'admin'),
(353, 'modification ahderent 5', '2024-02-15', 'admin'),
(354, 'modification ahderent 5', '2024-02-15', 'admin'),
(355, 'modification ahderent 5', '2024-02-15', 'admin'),
(356, 'modification ahderent 5', '2024-02-15', 'admin'),
(357, 'modification ahderent 5', '2024-02-15', 'admin'),
(358, 'modification ahderent 5', '2024-02-15', 'admin'),
(359, 'modification ahderent 5', '2024-02-15', 'admin'),
(360, 'modification ahderent 5', '2024-02-15', 'admin'),
(361, 'modification ahderent 5', '2024-02-15', 'admin'),
(362, 'modification equipe 4', '2024-02-15', 'admin'),
(363, 'modification ahderent 5', '2024-02-15', 'admin'),
(364, 'modification ahderent 5', '2024-02-15', 'admin'),
(365, 'modification equipe 4', '2024-02-15', 'admin'),
(366, 'modification ahderent 5', '2024-02-15', 'admin'),
(367, 'modification equipe 4', '2024-02-15', 'admin'),
(368, 'modification equipe 4', '2024-02-15', 'admin'),
(369, 'modification ahderent 5', '2024-02-15', 'admin'),
(370, 'modification equipe 4', '2024-02-15', 'admin'),
(371, 'modification ahderent 5', '2024-02-15', 'admin'),
(372, 'modification ahderent 5', '2024-02-15', 'admin'),
(373, 'modification ahderent 5', '2024-02-15', 'admin'),
(374, 'modification ahderent 5', '2024-02-15', 'admin'),
(375, 'modification equipe 4', '2024-02-15', 'admin'),
(376, 'modification ahderent 5', '2024-02-15', 'admin'),
(377, 'modification equipe 4', '2024-02-15', 'admin'),
(378, 'modification ahderent 5', '2024-02-15', 'admin'),
(379, 'modification ahderent 5', '2024-02-15', 'admin'),
(380, 'modification equipe 4', '2024-02-15', 'admin'),
(381, 'modification ahderent 5', '2024-02-15', 'admin'),
(382, 'modification equipe 4', '2024-02-15', 'admin'),
(383, 'modification ahderent 5', '2024-02-15', 'admin'),
(384, 'modification ahderent 5', '2024-02-15', 'admin'),
(385, 'modification ahderent 5', '2024-02-15', 'admin'),
(386, 'update entraineur 1', '2024-02-15', 'admin'),
(387, 'modification equipe 1', '2024-02-15', 'admin'),
(388, 'update entraineur 1', '2024-02-15', 'admin'),
(389, 'update entraineur 1', '2024-02-15', 'admin'),
(390, 'connexion', '2015-02-24', 'admin'),
(391, 'insert equipe 5', '2024-02-15', 'admin'),
(392, 'modification equipe 4', '2024-02-15', 'admin'),
(393, 'modification ahderent 5', '2024-02-15', 'admin'),
(394, 'modification ahderent 5', '2024-02-15', 'admin'),
(395, 'modification equipe 4', '2024-02-15', 'admin'),
(396, 'modification ahderent 5', '2024-02-15', 'admin'),
(397, 'modification equipe 4', '2024-02-15', 'admin'),
(398, 'modification ahderent 5', '2024-02-15', 'admin'),
(399, 'modification ahderent 5', '2024-02-15', 'admin'),
(400, 'modification ahderent 5', '2024-02-15', 'admin'),
(401, 'modification equipe 4', '2024-02-15', 'admin'),
(402, 'modification ahderent 5', '2024-02-15', 'admin'),
(403, 'modification ahderent 5', '2024-02-15', 'admin'),
(404, 'modification ahderent 5', '2024-02-15', 'admin'),
(405, 'insert equipe 5', '2024-02-15', 'admin'),
(406, 'connexion', '2016-02-24', 'admin'),
(407, 'modification ahderent 5', '2024-02-16', 'admin'),
(408, 'modification equipe 4', '2024-02-16', 'admin'),
(409, 'modification ahderent 5', '2024-02-16', 'admin'),
(410, 'modification ahderent 5', '2024-02-16', 'admin'),
(411, 'modification ahderent 5', '2024-02-16', 'admin'),
(412, 'modification equipe 4', '2024-02-16', 'admin'),
(413, 'modification ahderent 5', '2024-02-16', 'admin'),
(414, 'connexion', '2016-02-24', 'admin'),
(415, 'modification equipe 4', '2024-02-16', 'admin'),
(416, 'modification equipe 4', '2024-02-16', 'admin'),
(417, 'modification ahderent 5', '2024-02-16', 'admin'),
(418, 'modification ahderent 5', '2024-02-16', 'admin'),
(419, 'modification ahderent 5', '2024-02-16', 'admin'),
(420, 'modification ahderent 5', '2024-02-16', 'admin'),
(421, 'modification equipe 4', '2024-02-16', 'admin'),
(422, 'modification ahderent 5', '2024-02-16', 'admin'),
(423, 'modification ahderent 5', '2024-02-16', 'admin'),
(424, 'update entraineur 3', '2024-02-16', 'admin'),
(425, 'modification equipe 4', '2024-02-16', 'admin'),
(426, 'update entraineur 3', '2024-02-16', 'admin'),
(427, 'modification equipe 2', '2024-02-16', 'admin'),
(428, 'modification equipe 2', '2024-02-16', 'admin'),
(429, 'modification ahderent 5', '2024-02-16', 'admin'),
(430, 'connexion', '2016-02-24', 'pDupont'),
(431, 'connexion', '2016-02-24', 'pDupont'),
(432, 'changement mot de passe', '2016-02-24', 'pDupont'),
(433, 'changement mot de passe', '2016-02-24', 'pDupont'),
(434, 'changement mot de passe', '2016-02-24', 'pDupont'),
(435, 'changement mot de passe', '2016-02-24', 'pDupont'),
(436, 'changement mot de passe', '2024-02-16', 'pDupont'),
(437, 'changement mot de passe', '2024-02-16', 'pDupont'),
(438, 'changement mot de passe', '2024-02-16', 'pDupont'),
(439, 'connexion', '2016-02-24', 'admin'),
(440, 'insert equipe 5', '2024-02-16', 'admin'),
(441, 'insert equipe 6', '2024-02-16', 'admin'),
(442, 'insert equipe 6', '2024-02-16', 'admin'),
(443, 'connexion', '2016-02-24', 'admin'),
(444, 'insert Vacataire 5', '2024-02-16', 'admin'),
(445, 'insert entraineur 5 : spécialité', '2024-02-16', 'admin'),
(446, 'connexion', '2019-02-24', 'admin'),
(447, 'connexion', '2019-02-24', 'admin'),
(448, 'connexion', '2019-02-24', 'admin'),
(449, 'connexion', '2019-02-24', 'admin'),
(450, 'connexion', '2019-02-24', 'admin'),
(451, 'connexion', '2019-02-24', 'admin'),
(452, 'connexion', '2019-02-24', 'pDupont'),
(453, 'connexion', '2001-03-24', 'admin'),
(454, 'connexion', '2001-03-24', 'pDupont'),
(455, 'connexion', '2021-03-24', 'pDupont'),
(456, 'connexion', '2021-03-24', 'pDupont'),
(457, 'connexion', '2021-03-24', 'pDupont'),
(458, 'connexion', '2021-03-24', 'pDupont'),
(459, 'connexion', '2021-03-24', 'admin'),
(460, 'connexion', '2021-03-24', 'pDupont'),
(461, 'connexion', '2021-03-24', 'admin'),
(462, 'connexion', '2009-04-24', 'admin'),
(463, 'connexion', '2015-04-24', 'pDupont'),
(464, 'connexion', '2015-04-24', 'admin'),
(465, 'insert Titulaire 5', '2024-04-15', 'admin'),
(466, 'insert Vacataire 5', '2024-04-15', 'admin'),
(467, 'insert entraineur 5 : spécialité', '2024-04-15', 'admin'),
(468, 'insert Titulaire 5', '2024-04-15', 'admin'),
(469, 'insert Vacataire 5', '2024-04-15', 'admin'),
(470, 'insert entraineur 5 : spécialité', '2024-04-15', 'admin'),
(471, 'insert Titulaire 5', '2024-04-15', 'admin'),
(472, 'insert entraineur 5 : spécialité', '2024-04-15', 'admin'),
(473, 'insert Titulaire 5', '2024-04-15', 'admin'),
(474, 'insert entraineur 5 : spécialité', '2024-04-15', 'admin'),
(475, 'insert Titulaire 5', '2024-04-15', 'admin'),
(476, 'insert entraineur 5 : spécialité', '2024-04-15', 'admin'),
(477, 'update spécialité 9', '2024-04-15', 'admin'),
(478, 'connexion', '2015-04-24', 'admin'),
(479, 'modification ahderent 5', '2024-04-15', 'admin'),
(480, 'modification ahderent 5', '2024-04-15', 'admin'),
(481, 'connexion', '2002-05-24', 'pDupont'),
(482, 'connexion', '2002-05-24', 'vDubois'),
(483, 'connexion', '2002-05-24', 'jDurant'),
(484, 'connexion', '2002-05-24', 'sFleur'),
(485, 'connexion', '2002-05-24', 'gLopez'),
(486, 'connexion', '2002-05-24', 'Delbert'),
(487, 'connexion', '2002-05-24', 'Dubois'),
(488, 'connexion', '2002-05-24', 'admin'),
(489, 'connexion', '2004-05-24', 'Delbert');

-- --------------------------------------------------------

--
-- Structure de la table `nouvelle`
--

DROP TABLE IF EXISTS `nouvelle`;
CREATE TABLE IF NOT EXISTS `nouvelle` (
  `code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codeTheme` int NOT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_nouvelle_theme` (`codeTheme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nouvelle`
--

INSERT INTO `nouvelle` (`code`, `date`, `description`, `codeTheme`) VALUES
('1', '01/12/2023', 'Mini-Marathons pour Enfants', 2),
('2', '01/09/2023', 'Festivals de Sports pour Enfants', 2),
('3', '01/08/2023', 'Camps Sportifs pour Enfants ', 2),
('4', '01/07/2023', 'Initiations aux Sports', 2),
('5', '01/06/2023', 'Jeux Olympiques de la Jeunesse', 2),
('6', '01/02/2023', 'Festivals Culturels et Cinéma Autour des Jeux Olympiques ', 1),
('7', '01/01/2023', 'Tour de France et Culture Régionale', 1),
('8', '01/03/2023', 'Événements sportifs et Culture Geek', 1),
('9', '01/06/2023', 'Rencontres Sportives en Musique', 1);

-- --------------------------------------------------------

--
-- Structure de la table `pouvoir`
--

DROP TABLE IF EXISTS `pouvoir`;
CREATE TABLE IF NOT EXISTS `pouvoir` (
  `idAdherent` int NOT NULL,
  `idEquipe` int NOT NULL,
  PRIMARY KEY (`idAdherent`,`idEquipe`),
  KEY `fk_pouvoir_equipe` (`idEquipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pouvoir`
--

INSERT INTO `pouvoir` (`idAdherent`, `idEquipe`) VALUES
(1, 2),
(3, 2),
(4, 2),
(5, 3),
(1, 4),
(2, 4);

--
-- Déclencheurs `pouvoir`
--
DROP TRIGGER IF EXISTS `insert pouvoir`;
DELIMITER $$
CREATE TRIGGER `insert pouvoir` BEFORE INSERT ON `pouvoir` FOR EACH ROW BEGIN
    declare nbInscrit int default 0;
    declare maxi int default 0;
    DECLARE nbInscriptions int default 0;
    declare ageAdherent int default 0;
    declare ageMax int default 0;
    declare ageMin int default 0;
    declare sexeAdherent int default 0;
    set ageMin = (
        select sum(equipe.ageMinEquipe) 
        from equipe 
        where equipe.idEquipe = new.idEquipe);
    set ageMax = (
        select sum(equipe.ageMaxEquipe) 
        from equipe 
        where equipe.idEquipe = new.idEquipe);
    set ageAdherent = (
        select sum(adherent.ageAdherent) 
        from adherent 
        where adherent.idAdherent = new.idAdherent);
    set nbInscriptions = (
        select count(pouvoir.idEquipe) 
        from pouvoir 
        where pouvoir.idAdherent = new.idAdherent);
    set nbInscrit = (
        select count(pouvoir.idAdherent) 
        from pouvoir 
        where idEquipe = new.idEquipe);
    set maxi = (
        select sum(equipe.nbrPlaceEquipe) 
        from equipe 
        where equipe.idEquipe = new.idEquipe);
    set sexeAdherent = (
        select count(adherent.idAdherent)
        from pouvoir
        inner join adherent on adherent.idAdherent = new.idAdherent
        inner join equipe on equipe.idEquipe = new.idEquipe
        where equipe.sexeEquipe = adherent.sexeAdherent);
    if (nbInscrit >= maxi) THEN
        signal SQLSTATE '10008' set MESSAGE_TEXT = 'Nombre d adherent max déjà atteint';
    end IF;
    if (nbInscriptions > 2) THEN
    	signal SQLSTATE '10009' set MESSAGE_TEXT = 'Nombre d inscriptions max atteint';
    end if;
    if (ageAdherent > ageMax or ageAdherent < ageMin) THEN
    	signal SQLSTATE '10010' set MESSAGE_TEXT = 'L âge ne correspond pas a l equipe';
    end if;
    if (sexeAdherent = 0) THEN
    	signal SQLSTATE '10011' set MESSAGE_TEXT = 'Le sexe ne correspond pas a l equipe';
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
CREATE TABLE IF NOT EXISTS `specialite` (
  `idSpecialite` int NOT NULL AUTO_INCREMENT,
  `nomSpecialite` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idSpecialite`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`idSpecialite`, `nomSpecialite`) VALUES
(1, 'natation'),
(2, 'foot'),
(3, 'judo'),
(4, 'equitation'),
(5, 'volley'),
(6, 'athletisme'),
(7, 'moto bike'),
(8, 'aquaponey');

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `code` int NOT NULL,
  `libelle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`code`, `libelle`) VALUES
(1, 'Culture'),
(2, 'Sport');

-- --------------------------------------------------------

--
-- Structure de la table `titulaire`
--

DROP TABLE IF EXISTS `titulaire`;
CREATE TABLE IF NOT EXISTS `titulaire` (
  `idEntraineur` int NOT NULL,
  `dateEmbauche` date NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `titulaire`
--

INSERT INTO `titulaire` (`idEntraineur`, `dateEmbauche`) VALUES
(1, '2022-10-12'),
(3, '2020-10-12');

--
-- Déclencheurs `titulaire`
--
DROP TRIGGER IF EXISTS `insert titulaire`;
DELIMITER $$
CREATE TRIGGER `insert titulaire` BEFORE INSERT ON `titulaire` FOR EACH ROW BEGIN
	if ((SELECT count(*) from vacataire where vacataire.idEntraineur = new.idEntraineur) > 0) THEN
    	signal SQLSTATE '10006' set MESSAGE_TEXT = 'Objet déjà présent dans une autre table, table vacataire';
    end IF;
    if ((SELECT count(*) from entraineur where entraineur.idEntraineur = new.idEntraineur) < 1) THEN
    	signal SQLSTATE '10007' set MESSAGE_TEXT = 'Objet innnexistant dans la table parent, table entraineur';
    end IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `vacataire`
--

DROP TABLE IF EXISTS `vacataire`;
CREATE TABLE IF NOT EXISTS `vacataire` (
  `idEntraineur` int NOT NULL,
  `telephoneVacataire` char(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idEntraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vacataire`
--

INSERT INTO `vacataire` (`idEntraineur`, `telephoneVacataire`) VALUES
(2, '0625451215');

--
-- Déclencheurs `vacataire`
--
DROP TRIGGER IF EXISTS `insert vacataire`;
DELIMITER $$
CREATE TRIGGER `insert vacataire` BEFORE INSERT ON `vacataire` FOR EACH ROW BEGIN
	if ((SELECT count(*) from titulaire where titulaire.idEntraineur = new.idEntraineur) > 0) THEN
    	signal SQLSTATE '10006' set MESSAGE_TEXT = 'Objet déjà présent dans une autre table, table titulaire';
    end IF;
    if ((SELECT count(*) from entraineur where entraineur.idEntraineur = new.idEntraineur) < 1) THEN
    	signal SQLSTATE '10007' set MESSAGE_TEXT = 'Objet innnexistant dans la table parent, table entraineur';
    end IF;
END
$$
DELIMITER ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competent`
--
ALTER TABLE `competent`
  ADD CONSTRAINT `fk_competent_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`),
  ADD CONSTRAINT `fk_competent_specialite` FOREIGN KEY (`idSpecialite`) REFERENCES `specialite` (`idSpecialite`);

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `fk_equipe_entraineur` FOREIGN KEY (`idEntraineur`) REFERENCES `entraineur` (`idEntraineur`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_equipe_specialite` FOREIGN KEY (`idSpecialite`) REFERENCES `specialite` (`idSpecialite`);

--
-- Contraintes pour la table `nouvelle`
--
ALTER TABLE `nouvelle`
  ADD CONSTRAINT `nouvelle_ibfk_1` FOREIGN KEY (`codeTheme`) REFERENCES `theme` (`code`);

--
-- Contraintes pour la table `pouvoir`
--
ALTER TABLE `pouvoir`
  ADD CONSTRAINT `fk_pouvoir_adherent` FOREIGN KEY (`idAdherent`) REFERENCES `adherent` (`idAdherent`),
  ADD CONSTRAINT `fk_pouvoir_equipe` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`idEquipe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
