-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 04 mars 2022 à 22:33
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
-- Base de données : `blogart22`
--

-- --------------------------------------------------------

--
-- Structure de la table `angle`
--

DROP TABLE IF EXISTS `angle`;
CREATE TABLE IF NOT EXISTS `angle` (
  `numAngl` varchar(8) NOT NULL,
  `libAngl` varchar(60) NOT NULL,
  `numLang` varchar(8) NOT NULL,
  PRIMARY KEY (`numAngl`),
  KEY `ANGLE_FK` (`numAngl`),
  KEY `FK_ASSOCIATION_3` (`numLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `angle`
--

INSERT INTO `angle` (`numAngl`, `libAngl`, `numLang`) VALUES
('ANGL0102', 'Grandes figures littéraires', 'FRAN01'),
('ANGL0103', 'Happy hours', 'FRAN01'),
('ANGL0104', 'Histoire médiévale', 'FRAN01'),
('ANGL0105', 'Intelligence collective', 'FRAN01'),
('ANGL0106', 'Expérience 3.0', 'FRAN01'),
('ANGL0107', 'Chatbot et IA', 'FRAN01'),
('ANGL0108', 'Stories', 'FRAN01'),
('ANGL0109', 'Secret', 'FRAN01'),
('ANGL0110', 'We heart it', 'FRAN01'),
('ANGL0111', 'Yik Yak', 'FRAN01'),
('ANGL0112', 'Shots', 'FRAN01'),
('ANGL0113', 'Tik Tok', 'FRAN01'),
('ANGL0114', 'Recherche vocale', 'FRAN01'),
('ANGL0201', 'Handicap', 'ANGL01'),
('ANGL0202', 'Great literary figures', 'ANGL01'),
('ANGL0203', 'Happy hours', 'ANGL01'),
('ANGL0204', 'Medieval History', 'ANGL01'),
('ANGL0205', 'Collective Intelligence', 'ANGL01'),
('ANGL0206', 'Experience 3.0', 'ANGL01'),
('ANGL0207', 'Chatbot and IA', 'ANGL01'),
('ANGL0208', 'Stories', 'ANGL01'),
('ANGL0209', 'Secret', 'ANGL01'),
('ANGL0210', 'We heart it', 'ANGL01'),
('ANGL0211', 'Yik Yak', 'ANGL01'),
('ANGL0212', 'Shots', 'ANGL01'),
('ANGL0213', 'Tik Tok', 'ANGL01'),
('ANGL0214', 'Voice search', 'ANGL01'),
('ANGL0301', 'Handikap', 'ALLE01'),
('ANGL0302', 'Große literarische Persönlichkeiten', 'ALLE01'),
('ANGL0303', 'Happy hours', 'ALLE01'),
('ANGL0304', 'Mittelalterliche Geschichte', 'ALLE01'),
('ANGL0305', 'Gemeinsame Intelligenz', 'ALLE01'),
('ANGL0306', 'Erfahrung 3.0', 'ALLE01'),
('ANGL0307', 'Chatbot und KI', 'ALLE01'),
('ANGL0308', 'Geschichten', 'ALLE01'),
('ANGL0309', 'Geheimnis', 'ALLE01'),
('ANGL0310', 'Wir lieben es', 'ALLE01'),
('ANGL0311', 'Yik Yak', 'ALLE01'),
('ANGL0312', 'Aufnahmen', 'ALLE01'),
('ANGL0313', 'Tik Tok', 'ALLE01'),
('ANGL0314', 'Sprachsuche', 'ALLE01');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `numArt` int(8) NOT NULL AUTO_INCREMENT,
  `dtCreArt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `libTitrArt` varchar(100) DEFAULT NULL,
  `libChapoArt` text,
  `libAccrochArt` varchar(100) DEFAULT NULL,
  `parag1Art` text,
  `libSsTitr1Art` varchar(100) DEFAULT NULL,
  `parag2Art` text,
  `libSsTitr2Art` varchar(100) DEFAULT NULL,
  `parag3Art` text,
  `libConclArt` text,
  `urlPhotArt` varchar(70) DEFAULT NULL,
  `numAngl` varchar(8) NOT NULL,
  `numThem` varchar(8) NOT NULL,
  PRIMARY KEY (`numArt`),
  KEY `ARTICLE_FK` (`numArt`),
  KEY `FK_ASSOCIATION_1` (`numAngl`),
  KEY `FK_ASSOCIATION_2` (`numThem`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`numArt`, `dtCreArt`, `libTitrArt`, `libChapoArt`, `libAccrochArt`, `parag1Art`, `libSsTitr1Art`, `parag2Art`, `libSsTitr2Art`, `parag3Art`, `libConclArt`, `urlPhotArt`, `numAngl`, `numThem`) VALUES
(17, '2022-03-04 15:49:00', 'Comment n’avez-vous pas pu le voir ?', 'Le personnage Mimil créé par l’artiste David Selor est en effet partout dans les rues ! Impossible de le rater. Après avoir arpenté les villes du monde entier, le créateur revient dans sa ville natale. Il nous présente en exclusivité sa nouvelle exposition, nommée Fragile.', 'Découvrez-en plus sur ce personnage que vous ne connaissez que très peu…Pour l’instant !', 'Né à Cognac en 1988, David Selor est un street artist bordelais. A l’âge de 10 ans, le peintre à l’aérosol Seron Monbaton est venu graffer dans son école. C’est une révélation. [heading]Depuis ce jour, il n’a jamais oublié les graffitis[/heading] et a toujours gardé en tête le milieu du street art. Pour pouvoir signer ses créations, il choisit le pseudonyme “Selor”. Celui-ci est une simple suite de lettres dont il apprécie tout particulièrement l’enchaînement ainsi que la graphie. Peu avant de se consacrer entièrement à sa passion, il effectue en 2013 un service civique à Lisbonne, dans un centre d’accueil pour personnes autistes. Cette expérience est un véritable tournant dans sa vie. C’est en effet là qu’il crée son personnage que l’on connaît aujourd’hui : le Mimil. Par la suite, il développera ses œuvres sur les murs de la ville de Bordeaux ainsi que sur des toiles à l\'acrylique. David Selor a principalement peint dans la ville de Bordeaux ainsi que dans de nombreuses autres telles que Nantes, Marseille, Lyon et bien sûr Paris. Notre street artist traverse même les frontières en peignant les métropoles de Bruxelles, Londres, Athènes, Rome ou encore Porto.', 'Vous l’avez sûrement déjà vu. Retour sur Mimil, ce personnage qui nous replonge en enfance.', 'Imaginant l’humain dans sa forme la plus instinctive, ce personnage chimérique se balade dans les plus grandes villes d’Europe. Mi-humain mi-animal, il apparaît plus d’une centaine de fois au cours de ses tribulations, ne serait-ce que dans la métropole bordelaise. Les yeux fermés, le corps jaune pour se démarquer, une marinière bleue et blanche pour rappeler ses origines françaises, il est reconnaissable entre mille. Malgré un graphisme accrocheur, c’est bien le message qui est mis en avant. En effet, Mimil s’exprime avec un ton léger, humoristique, et s’inspire des comportements de l’être humain tout en poésie. Ainsi, ses messages, quand ils ont un sens, sont laissés ouverts à l\'interprétation, pour ceux qui prennent le temps de les lire et d’y réfléchir. Il aborde de nombreux sujets, mais revendique principalement sa liberté d’aller peindre sur les murs, dans le respect d’autrui. De véritables safaris sont organisés dans le but de capturer le plus d’apparitions de ce personnage, que ce soit sur les parpaings de Bordeaux, ou dans d’autres villes. Les Mimils, c’est la signature de David Selor, c’est la représentation de l’être humain, et c’est à vous d’en décoder les secrets.', 'Vous l’avez sûrement déjà vu. Retour sur Mimil, ce personnage qui nous replonge en enfance.', 'En ce début d’année, David Selor et son Mimil posent leurs valises à l\'institut Bernard Magrez, centre contemporain de Bordeaux convoité par l’artiste depuis quelques années. Avec Fragile, il marque un renouveau, une remise en question qui se devine ne serait-ce que par le format de l’exposition. Ce sont en effet pas moins de 20 toiles qui sont exposées. Lui qui a tendance à réaliser ses Mimils en une quinzaine de minutes sur les murs, ici, il a parfois fallu jusqu’à plusieurs semaines pour les finaliser. Fragile, comme l’éphémérité des œuvres dans la rue, qui peuvent être effacées, détruites à cause de la nature de leur support. David Selor s’exprime sur des sujets variés tels que la solitude à plusieurs, de la beauté dans l’imperfection et la dégradation, de la dualité de l’amour et la de haine, ou encore de la rue et de la toile. Tout comme avec les Mimils dans la rue, il laisse le soin aux visiteurs de tirer leur propre interprétation, de faire écho avec leur expérience personnelle qui est unique pour chacun. Que verrez-vous, vous ? Peut-être même que vous remarquerez une évolution du Mimil, mais cela, c’est si vous acceptez de la voir.', 'Vous l’aurez compris, le Mimil est l’emblème de l’artiste. Il souhaite lui donner une toute autre importance en le plaçant au sein même du patrimoine de Bordeaux. Ce personnage étant déjà très présent sur les murs de la ville, il se démocratise de plus en plus en visitant désormais les toiles. Dans les récentes réalisations de David Selor, nous pouvons citer la fresque “Je resterai éternellement… jaune” pour la ville de Bruges, s’ajoutant à l’exposition à l’institut Bernard Magrez. Cet événement est l’occasion de voir les œuvres de l’artiste sous un nouveau jour, dans le thème du renouveau. Découvrir ou redécouvrir Mimil à l’exposition Fragile ne pourra qu’enrichir la poésie de cet étrange animal, encore si mystérieux pour beaucoup.', 'imgArtecfb714c107d2894fb6dfbb6961da878.jpg', 'ANGL0102', 'THEM0101'),
(18, '2022-03-04 20:18:39', 'Une bouffee d’air frais dans le graffiti', 'Une question bien prometteuse, qui sonne comme un article vous présentant une solution miracle pour perdre 10 kilos en une semaine. Et pourtant ! C’est ce que vous propose l’association artistique et caritative Mur du Souffle, située à Bruges. Décorer son salon tout en finançant la recherche contre la mucoviscidose, c’est désormais possible en quelques clics. Bordeaux Street Art est parti à la rencontre de son président.', 'Professeur d\'arts plastiques, il dédie son temps à sa famille et à l\'association Mur du Souffle.', 'Guillaume Clément a co-fondée cette association avec sa femme Aurélie, et Kevin Bru en 2017. Baigné depuis tout petit dans le monde artistique, il se décrit comme médiateur plutôt que créateur par son envie de transmettre, en faisant le lien entre le public et les artistes. C’est via l’art et le graffiti en particulier que Mur du Souffle lutte contre la mucoviscidose, en revendant des œuvres d’artistes sur son site. [heading]L’ensemble des profits est reversé à des associations pour Vaincre la Mucoviscidose[/heading] tel que Grégory Lemarchal, qui s’occupe de financer directement la recherche, de sensibiliser et d’accompagner les patients. Le nom Mur du Souffle lie le support principal des graffeurs et des artistes exposant leur œuvres avec ce qui fait [b]défaut [/b]ux personnes atteintes de cette maladie, le souffle, (car notamment atteints aux poumons ainsi qu’aux voies digestives). De plus, les hommes préhistoriques ne soufflaient-ils pas de la peinture sur les murs des cavernes ?', '« Les administrations ne comprenaient pas ce que l’on faisait : de l’art ou du caritatif ? »', 'En plus de la vente d’éditions d\'œuvres limitées et numérotées, Mur du Souffle organise tous les deux ans depuis 2017 un festival de graffiti gratuit du même nom à Bruges, sous le pont d’Ausone. 3 jours durant, des artistes viennent peindre sur des murs gargantuesques, avec ateliers, buvette, restauration, musique. Les participants viennent tous en tant que bénévoles, apportant leur talent. Comme le dit Guillaume Clément, “les graffeurs, il y a deux choses qui les motivent, les rencontres humaines et les beaux murs”, beaucoup sont donc prêts à venir grâce à la réputation grandissante des murs, ou alors contactés sur les réseaux sociaux. Aucun thème n’étant donné lors du lancement du festival, les artistes peuvent exprimer leur univers en toute liberté, que ce soit de l’abstrait, de l\'hyper figuratif, ou tout autre style. Il est d’ailleurs intéressant de noter qu’il n’y a eu aucun vandalisme sur les murs occupés par les réalisations du festival, vous pouvez donc encore aller les admirer. Les œuvres qui prennent vie durant ces week-ends sont ensuite prises en photo, dont les tirages sont également proposés à la vente sur internet.', '« Les administrations ne comprenaient pas ce que l’on faisait : de l’art ou du caritatif ? »', 'Une question que l’on se pose en tant que néophyte est la différence entre le street art et le graffiti. D’après le président du Mur du Souffle, « le street art est une grande famille dans laquelle il y a le graffiti et d’autres formes d’expression. On pourrait presque dire que le graffiti est l’origine du street art, c’est prendre de la peinture sous forme de bombe et peindre sur les murs. » Un jeune souhaitant tester le graffiti n’ayant pas la propriété du mur de ses expérimentations, on peut affirmer que tous les graffeurs ont commencé par de l’illégal. Il existe cependant deux écoles, l’une où les artistes voient leurs réalisations financées et exposées tel David Selor, tandis que d’autres refusent de faire autre chose que de l’illégal, par la même occasion d’être photographiés. Ils considèrent les premiers comme faisant du business avec un art qui devrait rester libre, gratuit et interdit, jouant l’équilibriste avec les forces de l’ordre et leur liberté, bien qu’elles soient plus laxes qu’auparavant. Cette catégorie ne participera probablement jamais au festival, quoiqu’un graffiti dans l’ombre serait le bienvenue, ramenant plus de visibilité au lieu et à la cause.', 'Depuis la création de l’association, c’est plus de cinquante personnes qui lui ont fait confiance pour décorer leur nid douillet. Au total, Mur du Souffle a récolté pas moins de 4000 euros en trois ans et espère cette année ajouter 3000 euros de plus à cette belle cagnotte. Mais assez donné de chiffres, parlons des projets de l’association. En plus de la vente en ligne, du festival et d’ateliers de graffiti, il est possible depuis peu de contacter l’association afin qu’elle réalise un devis en faisant le lien avec un artiste, et enfin, dans un futur lointain, pourquoi pas envisager l’utilisation de NFT! Pour l’amour de l’art et de leur fille Lisa, atteinte de mucoviscidose, le couple Clément compte bien continuer à emprunter le chemin du Mur du Souffle, pourquoi pas avec vous ?', 'imgArt787ee2eba13b9796d522c8816a9f8984.jpg', 'ANGL0102', 'THEM0101');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `numSeqCom` int(10) NOT NULL,
  `numArt` int(8) NOT NULL,
  `dtCreCom` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `libCom` text NOT NULL,
  `attModOK` tinyint(1) DEFAULT '0',
  `dtModCom` timestamp NULL DEFAULT NULL,
  `notifComKOAff` text,
  `delLogiq` tinyint(1) DEFAULT '0',
  `numMemb` int(10) NOT NULL,
  PRIMARY KEY (`numSeqCom`,`numArt`),
  KEY `COMMENT_FK` (`numSeqCom`,`numArt`),
  KEY `FK_ASSOCIATION_8` (`numArt`),
  KEY `FK_ASSOCIATION_9` (`numMemb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`numSeqCom`, `numArt`, `dtCreCom`, `libCom`, `attModOK`, `dtModCom`, `notifComKOAff`, `delLogiq`, `numMemb`) VALUES
(1, 17, '2022-03-04 16:02:21', 'Trop bien! Je l\'avais souvent vu, merci d\'avoir amené un oeil sur cet artiste', 0, '2022-03-04 16:02:21', NULL, 0, 1),
(2, 17, '2022-03-04 16:02:36', '@jhondoe: Idem... jamais vraiment regardé en ville', 0, '2022-03-04 16:02:36', NULL, 0, 2),
(3, 17, '2022-03-04 16:03:28', 'Mais quoi excellent', 0, '2022-03-04 16:03:28', NULL, 0, 17),
(4, 17, '2022-03-04 16:32:29', 'C\'est cool', 0, '2022-03-04 16:32:29', NULL, 0, 17),
(5, 17, '2022-03-04 16:32:48', '@juju1989: C\'est vrai', 0, '2022-03-04 16:32:48', NULL, 0, 17),
(6, 17, '2022-03-04 20:16:24', 'Yhouuuu', 0, '2022-03-04 20:16:24', NULL, 0, 17),
(7, 17, '2022-03-04 20:16:35', '@jhondoe: ui tu as raison', 0, '2022-03-04 20:16:35', NULL, 0, 17);

-- --------------------------------------------------------

--
-- Structure de la table `commentplus`
--

DROP TABLE IF EXISTS `commentplus`;
CREATE TABLE IF NOT EXISTS `commentplus` (
  `numSeqCom` int(10) NOT NULL,
  `numArt` int(8) NOT NULL,
  `numSeqComR` int(10) NOT NULL,
  `numArtR` int(8) NOT NULL,
  PRIMARY KEY (`numSeqCom`,`numArt`,`numSeqComR`,`numArtR`),
  KEY `COMMENTPLUS_FK` (`numSeqCom`,`numArt`,`numSeqComR`,`numArtR`),
  KEY `FK_COMMENTPLUS` (`numSeqComR`,`numArtR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentplus`
--

INSERT INTO `commentplus` (`numSeqCom`, `numArt`, `numSeqComR`, `numArtR`) VALUES
(2, 17, 1, 17),
(5, 17, 2, 17),
(7, 17, 3, 17);

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `numLang` varchar(8) NOT NULL,
  `lib1Lang` varchar(30) DEFAULT NULL,
  `lib2Lang` varchar(60) DEFAULT NULL,
  `numPays` char(4) DEFAULT NULL,
  PRIMARY KEY (`numLang`),
  KEY `LANGUE_FK` (`numLang`),
  KEY `FK_ASSOCIATION_7` (`numPays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`numLang`, `lib1Lang`, `lib2Lang`, `numPays`) VALUES
('ALLE01', 'Allemand(e)', 'Langue allemande', 'ALLE'),
('ANGL01', 'Anglais(e)', 'Langue anglaise', 'ANGL'),
('BULG01', 'Bulgare', 'Langue bulgare', 'BULG'),
('ESPA01', 'Espagnol(e)', 'Langue espagnole', 'ESPA'),
('FRAN01', 'Français(e)', 'Langue française', 'FRAN'),
('ITAL01', 'Italien(ne)', 'Langue italienne', 'ITAL'),
('RUSS01', 'Russe', 'Langue russe', 'RUSS'),
('UKRA01', 'Ukrainien(ne)', 'Langue ukrainienne', 'UKRA');

-- --------------------------------------------------------

--
-- Structure de la table `likeart`
--

DROP TABLE IF EXISTS `likeart`;
CREATE TABLE IF NOT EXISTS `likeart` (
  `numMemb` int(10) NOT NULL,
  `numArt` int(8) NOT NULL,
  `likeA` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`numMemb`,`numArt`),
  KEY `LIKEART_FK` (`numMemb`,`numArt`),
  KEY `FK_LIKEART` (`numArt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likeart`
--

INSERT INTO `likeart` (`numMemb`, `numArt`, `likeA`) VALUES
(2, 17, 1),
(3, 17, 1),
(4, 17, 1),
(5, 17, 1),
(16, 17, 1),
(17, 17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `likecom`
--

DROP TABLE IF EXISTS `likecom`;
CREATE TABLE IF NOT EXISTS `likecom` (
  `numMemb` int(10) NOT NULL,
  `numSeqCom` int(10) NOT NULL,
  `numArt` int(8) NOT NULL,
  `likeC` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`numMemb`,`numSeqCom`,`numArt`),
  KEY `LIKECOM_FK` (`numMemb`,`numSeqCom`,`numArt`),
  KEY `FK_LIKECOM` (`numSeqCom`,`numArt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likecom`
--

INSERT INTO `likecom` (`numMemb`, `numSeqCom`, `numArt`, `likeC`) VALUES
(2, 1, 17, 1),
(3, 1, 17, 1),
(17, 3, 17, 1),
(17, 7, 17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `numMemb` int(10) NOT NULL AUTO_INCREMENT,
  `prenomMemb` varchar(70) NOT NULL,
  `nomMemb` varchar(70) NOT NULL,
  `pseudoMemb` varchar(70) NOT NULL,
  `passMemb` varchar(70) NOT NULL,
  `eMailMemb` varchar(100) NOT NULL,
  `dtCreaMemb` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `accordMemb` tinyint(1) DEFAULT '1',
  `confirmation_token` varchar(70) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(70) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `idStat` int(5) NOT NULL,
  PRIMARY KEY (`numMemb`),
  KEY `MEMBRE_FK` (`numMemb`),
  KEY `FK_ASSOCIATION_10` (`idStat`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`numMemb`, `prenomMemb`, `nomMemb`, `pseudoMemb`, `passMemb`, `eMailMemb`, `dtCreaMemb`, `accordMemb`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `idStat`) VALUES
(1, 'Jean', 'Dupont', 'Phil09', 'Ut!D5?h0', 'Phil09@me.com', '2020-01-09 09:13:43', 1, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Julie', 'La Rousse', 'juju1989', 'G54;Q22mi5', 'julie@gmail.com', '2020-03-15 13:33:23', 1, NULL, NULL, NULL, NULL, NULL, 3),
(3, 'David', 'Bowie', 'dav33B', 'kp09,1K4!', 'david.bowie@gmail.com', '2020-07-19 11:13:13', 1, NULL, NULL, NULL, NULL, NULL, 4),
(4, 'Phil', 'Collins', 'cols2P', 'mq3j4;6GH', 'phil.collins@me.com', '2020-11-04 16:39:09', 1, NULL, NULL, NULL, NULL, NULL, 2),
(5, 'Prince', 'Rogers Nelson dit PRINCE', 'Rogers222', 'frI3!Px;21', 'phil.collins@me.com', '2022-02-17 11:31:20', 1, NULL, NULL, NULL, NULL, NULL, 5),
(16, 'lorem_ipsum_input', 'lorem_ipsum_input', 'lorem_ipsum_input', '$2y$10$u7l5UxO1WrdJPIBXx2yarumR5zpFxGg3sBY7c7IofCxmCXy2gNVVG', 'qsdqd@gmail.com', '2022-03-03 14:16:49', 1, NULL, NULL, NULL, NULL, NULL, 3),
(17, 'Jhon', 'Doe', 'jhondoe', '$2y$10$gggjpbth2lcvK8SrVd/aaezN.Vn7Rqtybbrx2MlYeyJD3VLRUx8Lu', 'jhondoe@email.com', '2022-03-03 18:53:32', 1, NULL, NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `motcle`
--

DROP TABLE IF EXISTS `motcle`;
CREATE TABLE IF NOT EXISTS `motcle` (
  `numMotCle` int(8) NOT NULL AUTO_INCREMENT,
  `libMotCle` varchar(60) NOT NULL,
  `numLang` varchar(8) NOT NULL,
  PRIMARY KEY (`numMotCle`),
  KEY `MOTCLE_FK` (`numMotCle`),
  KEY `FK_ASSOCIATION_5` (`numLang`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `motcle`
--

INSERT INTO `motcle` (`numMotCle`, `libMotCle`, `numLang`) VALUES
(1, 'Bordeaux', 'FRAN01'),
(11, 'port de la Lune', 'FRAN01'),
(12, 'histoire', 'FRAN01'),
(13, 'Art', 'FRAN01'),
(49, 'Street', 'FRAN01'),
(50, 'Mimil', 'FRAN01'),
(51, 'Graffiti', 'FRAN01'),
(52, 'Mucoviscidose', 'FRAN01'),
(53, 'Mur', 'FRAN01'),
(54, 'Souffle', 'FRAN01'),
(55, 'David selor', 'FRAN01');

-- --------------------------------------------------------

--
-- Structure de la table `motclearticle`
--

DROP TABLE IF EXISTS `motclearticle`;
CREATE TABLE IF NOT EXISTS `motclearticle` (
  `numArt` int(8) NOT NULL,
  `numMotCle` int(8) NOT NULL,
  PRIMARY KEY (`numArt`,`numMotCle`),
  KEY `MOTCLEARTICLE_FK` (`numArt`),
  KEY `MOTCLEARTICLE2_FK` (`numMotCle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `motclearticle`
--

INSERT INTO `motclearticle` (`numArt`, `numMotCle`) VALUES
(17, 1),
(17, 12),
(17, 13),
(17, 49),
(17, 50),
(17, 51),
(17, 55),
(18, 1),
(18, 12),
(18, 13),
(18, 49),
(18, 51),
(18, 52),
(18, 53),
(18, 54),
(18, 55);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `numPays` char(4) NOT NULL,
  `cdPays` char(2) NOT NULL,
  `frPays` varchar(255) NOT NULL,
  `enPays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`numPays`),
  KEY `PAYS_FK` (`numPays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`numPays`, `cdPays`, `frPays`, `enPays`) VALUES
('AFGH', 'AF', 'Afghanistan', 'Afghanistan'),
('AFRI', 'ZA', 'Afrique du Sud', 'South Africa'),
('ALBA', 'AL', 'Albanie', 'Albania'),
('ALGE', 'DZ', 'Algérie', 'Algeria'),
('ALLE', 'DE', 'Allemagne', 'Germany'),
('ANDO', 'AD', 'Andorre', 'Andorra'),
('ANGL', 'GB', 'Royaume-Uni', 'United Kingdom'),
('ANGO', 'AO', 'Angola', 'Angola'),
('ANGU', 'AI', 'Anguilla', 'Anguilla'),
('ANTG', 'AG', 'Antigua-et-Barbuda', 'Antigua & Barbuda'),
('ANTI', 'AN', 'Antilles néerlandaises', 'Netherlands Antilles'),
('ARAB', 'SA', 'Arabie saoudite', 'Saudi Arabia'),
('ARGE', 'AR', 'Argentine', 'Argentina'),
('ARME', 'AM', 'Arménie', 'Armenia'),
('ARTA', 'AQ', 'Antarctique', 'Antarctica'),
('ARUB', 'AW', 'Aruba', 'Aruba'),
('AUST', 'AU', 'Australie', 'Australia'),
('AUTR', 'AT', 'Autriche', 'Austria'),
('AZER', 'AZ', 'Azerbaïdjan', 'Azerbaijan'),
('BAHA', 'BS', 'Bahamas', 'Bahamas, The'),
('BAHR', 'BH', 'Bahreïn', 'Bahrain'),
('BANG', 'BD', 'Bangladesh', 'Bangladesh'),
('BARB', 'BB', 'Barbade', 'Barbados'),
('BELA', 'PW', 'Belau', 'Palau'),
('BELG', 'BE', 'Belgique', 'Belgium'),
('BELI', 'BZ', 'Belize', 'Belize'),
('BENI', 'BJ', 'Bénin', 'Benin'),
('BERM', 'BM', 'Bermudes', 'Bermuda'),
('BHOU', 'BT', 'Bhoutan', 'Bhutan'),
('BIEL', 'BY', 'Biélorussie', 'Belarus'),
('BIRM', 'MM', 'Birmanie', 'Myanmar (ex-Burma)'),
('BOIN', 'IO', 'Territoire britannique de l Océan Indien', 'British Indian Ocean Territory'),
('BOLV', 'BO', 'Bolivie', 'Bolivia'),
('BOSN', 'BA', 'Bosnie-Herzégovine', 'Bosnia and Herzegovina'),
('BOTS', 'BW', 'Botswana', 'Botswana'),
('BOUV', 'BV', 'Ile Bouvet', 'Bouvet Island'),
('BRES', 'BR', 'Brésil', 'Brazil'),
('BRUN', 'BN', 'Brunei', 'Brunei Darussalam'),
('BULG', 'BG', 'Bulgarie', 'Bulgaria'),
('BURK', 'BF', 'Burkina Faso', 'Burkina Faso'),
('BURU', 'BI', 'Burundi', 'Burundi'),
('CAFR', 'CF', 'République centrafricaine', 'Central African Republic'),
('CAMB', 'KH', 'Cambodge', 'Cambodia'),
('CAME', 'CM', 'Cameroun', 'Cameroon'),
('CANA', 'CA', 'Canada', 'Canada'),
('CAYM', 'KY', 'Iles Cayman', 'Cayman Islands'),
('CHIL', 'CL', 'Chili', 'Chile'),
('CHIN', 'CN', 'Chine', 'China'),
('CHRI', 'CX', 'Ile Christmas', 'Christmas Island'),
('CHYP', 'CY', 'Chypre', 'Cyprus'),
('CNOR', 'KP', 'Corée du Nord', 'Korea, Demo. People s Rep. of'),
('COCO', 'CC', 'Iles des Cocos (Keeling)', 'Cocos (Keeling) Islands'),
('COLO', 'CO', 'Colombie', 'Colombia'),
('COMO', 'KM', 'Comores', 'Comoros'),
('CON1', 'CD', 'République démocratique du Congo', 'Congo, Democratic Rep. of the'),
('CON2', 'CG', 'Congo', 'Congo'),
('COOK', 'CK', 'Iles Cook', 'Cook Islands'),
('CROA', 'HR', 'Croatie', 'Croatia'),
('CSUD', 'KR', 'Corée du Sud', 'Korea, (South) Republic of'),
('CUBA', 'CU', 'Cuba', 'Cuba'),
('CVER', 'CV', 'Cap-Vert', 'Cape Verde'),
('DANE', 'DK', 'Danemark', 'Denmark'),
('DJIB', 'DJ', 'Djibouti', 'Djibouti'),
('DOM1', 'DM', 'Dominique', 'Dominica'),
('DOM2', 'DO', 'République dominicaine', 'Dominican Republic'),
('EGYP', 'EG', 'Égypte', 'Egypt'),
('EMIR', 'AE', 'Émirats arabes unis', 'United Arab Emirates'),
('EQUA', 'EC', 'Équateur', 'Ecuador'),
('ERYT', 'ER', 'Érythrée', 'Eritrea'),
('ESPA', 'ES', 'Espagne', 'Spain'),
('ESTO', 'EE', 'Estonie', 'Estonia'),
('ETHO', 'ET', 'Éthiopie', 'Ethiopia'),
('FALK', 'FK', 'Iles Falkland', 'Falkland Islands (Malvinas)'),
('FERO', 'FO', 'Iles Féroé', 'Faroe Islands'),
('FIDJ', 'FJ', 'Iles Fidji', 'Fiji'),
('FINL', 'FI', 'Finlande', 'Finland'),
('FRAN', 'FR', 'France', 'France'),
('GABO', 'GA', 'Gabon', 'Gabon'),
('GAMB', 'GM', 'Gambie', 'Gambia, the'),
('GANA', 'GH', 'Ghana', 'Ghana'),
('GEO1', 'GE', 'Géorgie', 'Georgia'),
('GEO2', 'GS', 'Iles Géorgie du Sud et Sandwich du Sud', 'S. Georgia and S. Sandwich Is.'),
('GIBR', 'GI', 'Gibraltar', 'Gibraltar'),
('GREC', 'GR', 'Grèce', 'Greece'),
('GREN', 'GD', 'Grenade', 'Grenada'),
('GROE', 'GL', 'Groenland', 'Greenland'),
('GUAD', 'GP', 'Guadeloupe', 'Guinea, Equatorial'),
('GUAM', 'GU', 'Guam', 'Guam'),
('GUAT', 'GT', 'Guatemala', 'Guatemala'),
('GUIB', 'GW', 'Guinée-Bissao', 'Guinea-Bissau'),
('GUIE', 'GQ', 'Guinée équatoriale', 'Equatorial Guinea'),
('GUIN', 'GN', 'Guinée', 'Guinea'),
('GUYA', 'GY', 'Guyana', 'Guyana'),
('GUYF', 'GF', 'Guyane française', 'Guiana, French'),
('HAIT', 'HT', 'Haïti', 'Haiti'),
('HEAR', 'HM', 'Iles Heard et McDonald', 'Heard and McDonald Islands'),
('HOND', 'HN', 'Honduras', 'Honduras'),
('HONG', 'HU', 'Hongrie', 'Hungary'),
('INDE', 'IN', 'Inde', 'India'),
('INDO', 'ID', 'Indonésie', 'Indonesia'),
('IRAN', 'IR', 'Iran', 'Iran, Islamic Republic of'),
('IRAQ', 'IQ', 'Iraq', 'Iraq'),
('IRLA', 'IE', 'Irlande', 'Ireland'),
('ISLA', 'IS', 'Islande', 'Iceland'),
('ISRA', 'IL', 'Israël', 'Israel'),
('ITAL', 'IT', 'Italie', 'Italy'),
('IVOI', 'CI', 'Côte d\'Ivoire', 'Ivory Coast (see Cote d\'Ivoire)'),
('JAMA', 'JM', 'Jamaïque', 'Jamaica'),
('JAPO', 'JP', 'Japon', 'Japan'),
('JORD', 'JO', 'Jordanie', 'Jordan'),
('KAZA', 'KZ', 'Kazakhstan', 'Kazakhstan'),
('KIRG', 'KG', 'Kirghizistan', 'Kyrgyzstan'),
('KIRI', 'KI', 'Kiribati', 'Kiribati'),
('KNYA', 'KE', 'Kenya', 'Kenya'),
('KONG', 'HK', 'Hong Kong', 'Hong Kong, (China)'),
('KWEI', 'KW', 'Koweït', 'Kuwait'),
('LAOS', 'LA', 'Laos', 'Lao People s Democratic Republic'),
('LEON', 'SL', 'Sierra Leone', 'Sierra Leone'),
('LESO', 'LS', 'Lesotho', 'Lesotho'),
('LETT', 'LV', 'Lettonie', 'Latvia'),
('LIBA', 'LB', 'Liban', 'Lebanon'),
('LIBE', 'LR', 'Liberia', 'Liberia'),
('LIBY', 'LY', 'Libye', 'Libyan Arab Jamahiriya'),
('LIEC', 'LI', 'Liechtenstein', 'Liechtenstein'),
('LITU', 'LT', 'Lituanie', 'Lithuania'),
('LUXE', 'LU', 'Luxembourg', 'Luxembourg'),
('MACA', 'MO', 'Macao', 'Macao, (China)'),
('MACE', 'MK', 'ex-République yougoslave de Macédoine', 'Macedonia, TFYR'),
('MADA', 'MG', 'Madagascar', 'Madagascar'),
('MALA', 'MY', 'Malaisie', 'Malaysia'),
('MALD', 'MV', 'Maldives', 'Maldives'),
('MALI', 'ML', 'Mali', 'Mali'),
('MALT', 'MT', 'Malte', 'Malta'),
('MALW', 'MW', 'Malawi', 'Malawi'),
('MARI', 'MP', 'Mariannes du Nord', 'Northern Mariana Islands'),
('MARO', 'MA', 'Maroc', 'Morocco'),
('MARS', 'MH', 'Iles Marshall', 'Marshall Islands'),
('MART', 'MQ', 'Martinique', 'Martinique'),
('MAUC', 'MU', 'Maurice', 'Mauritius'),
('MAUR', 'MR', 'Mauritanie', 'Mauritania'),
('MAYO', 'YT', 'Mayotte', 'Mayotte'),
('MEXI', 'MX', 'Mexique', 'Mexico'),
('MICR', 'FM', 'Micronésie', 'Micronesia, Federated States of'),
('MINE', 'UM', 'Iles mineures éloignées des États-Unis', 'US Minor Outlying Islands'),
('MOLD', 'MD', 'Moldavie', 'Moldova, Republic of'),
('MONA', 'MC', 'Monaco', 'Monaco'),
('MONG', 'MN', 'Mongolie', 'Mongolia'),
('MONS', 'MS', 'Montserrat', 'Montserrat'),
('MOZA', 'MZ', 'Mozambique', 'Mozambique'),
('NAMI', 'NA', 'Namibie', 'Namibia'),
('NAUR', 'NR', 'Nauru', 'Nauru'),
('NEPA', 'NP', 'Népal', 'Nepal'),
('NICA', 'NI', 'Nicaragua', 'Nicaragua'),
('NIEV', 'KN', 'Saint-Christophe-et-Niévès', 'Saint Kitts and Nevis'),
('NIGA', 'NG', 'Nigeria', 'Nigeria'),
('NIGE', 'NE', 'Niger', 'Niger'),
('NIOU', 'NU', 'Nioué', 'Niue'),
('NORF', 'NF', 'Ile Norfolk', 'Norfolk Island'),
('NORV', 'NO', 'Norvège', 'Norway'),
('NOUC', 'NC', 'Nouvelle-Calédonie', 'New Caledonia'),
('NOUZ', 'NZ', 'Nouvelle-Zélande', 'New Zealand'),
('OMAN', 'OM', 'Oman', 'Oman'),
('OUGA', 'UG', 'Ouganda', 'Uganda'),
('OUZE', 'UZ', 'Ouzbékistan', 'Uzbekistan'),
('PAKI', 'PK', 'Pakistan', 'Pakistan'),
('PANA', 'PA', 'Panama', 'Panama'),
('PAPU', 'PG', 'Papouasie-Nouvelle-Guinée', 'Papua New Guinea'),
('PARA', 'PY', 'Paraguay', 'Paraguay'),
('PBAS', 'NL', 'pays-Bas', 'Netherlands'),
('PERO', 'PE', 'Pérou', 'Peru'),
('PHIL', 'PH', 'Philippines', 'Philippines'),
('PITC', 'PN', 'Iles Pitcairn', 'Pitcairn Island'),
('POLO', 'PL', 'Pologne', 'Poland'),
('POLY', 'PF', 'Polynésie française', 'French Polynesia'),
('PORT', 'PT', 'Portugal', 'Portugal'),
('QATA', 'QA', 'Qatar', 'Qatar'),
('REUN', 'RE', 'Réunion', 'Reunion'),
('RICA', 'CR', 'Costa Rica', 'Costa Rica'),
('RICO', 'PR', 'Porto Rico', 'Puerto Rico'),
('ROUM', 'RO', 'Roumanie', 'Romania'),
('RUSS', 'RU', 'Russie', 'Russia (Russian Federation)'),
('RWAN', 'RW', 'Rwanda', 'Rwanda'),
('SAHA', 'EH', 'Sahara occidental', 'Western Sahara'),
('SALO', 'SB', 'Iles Salomon', 'Solomon Islands'),
('SALV', 'SV', 'Salvador', 'El Salvador'),
('SAMA', 'AS', 'Samoa américaines', 'American Samoa'),
('SAMO', 'WS', 'Samoa', 'Samoa'),
('SENE', 'SN', 'Sénégal', 'Senegal'),
('SEYC', 'SC', 'Seychelles', 'Seychelles'),
('SING', 'SG', 'Singapour', 'Singapore'),
('SLN_', 'SH', 'Sainte-Hélène', 'Saint Helena'),
('SLOQ', 'SK', 'Slovaquie', 'Slovakia'),
('SLOV', 'SI', 'Slovénie', 'Slovenia'),
('SLUC', 'LC', 'Sainte-Lucie', 'Saint Lucia'),
('SMAR', 'SM', 'Saint-Marin', 'San Marino'),
('SOMA', 'SO', 'Somalie', 'Somalia'),
('SOUD', 'SD', 'Soudan', 'Sudan'),
('SPIE', 'PM', 'Saint-Pierre-et-Miquelon', 'Saint Pierre and Miquelon'),
('SRIL', 'LK', 'Sri Lanka', 'Sri Lanka (ex-Ceilan)'),
('SSIE', 'VA', 'Saint-Siège ', 'Vatican City State (Holy See)'),
('SUED', 'SE', 'Suède', 'Sweden'),
('SUIS', 'CH', 'Suisse', 'Switzerland'),
('SURI', 'SR', 'Suriname', 'Suriname'),
('SVAL', 'SJ', 'Iles Svalbard et Jan Mayen', 'Svalbard and Jan Mayen Islands'),
('SVIN', 'VC', 'Saint-Vincent-et-les-Grenadines', 'Saint Vincent and the Grenadines'),
('SWAZ', 'SZ', 'Swaziland', 'Swaziland'),
('SYRY', 'SY', 'Syrie', 'Syrian Arab Republic'),
('TADJ', 'TJ', 'Tadjikistan', 'Tajikistan'),
('TAIW', 'TW', 'Taïwan', 'Taiwan'),
('TANZ', 'TZ', 'Tanzanie', 'Tanzania, United Republic of'),
('TCHA', 'TD', 'Tchad', 'Chad'),
('TCHE', 'CZ', 'République tchèque', 'Czech Republic'),
('TERR', 'TF', 'Terres australes françaises', 'French Southern Territories - TF'),
('THAI', 'TH', 'Thaïlande', 'Thailand'),
('TIMO', 'TL', 'Timor Oriental', 'Timor-Leste (East Timor)'),
('TOBA', 'TT', 'Trinité-et-Tobago', 'Trinidad & Tobago'),
('TOGO', 'TG', 'Togo', 'Togo'),
('TOKE', 'TK', 'Tokélaou', 'Tokelau'),
('TOME', 'ST', 'Sao Tomé-et-Principe', 'Sao Tome and Principe'),
('TONG', 'TO', 'Tonga', 'Tonga'),
('TUNI', 'TN', 'Tunisie', 'Tunisia'),
('TUR1', 'TC', 'Iles Turks-et-Caicos', 'Turks and Caicos Islands'),
('TUR2', 'TM', 'Turkménistan', 'Turkmenistan'),
('TURQ', 'TR', 'Turquie', 'Turkey'),
('TUVA', 'TV', 'Tuvalu', 'Tuvalu'),
('UKRA', 'UA', 'Ukraine', 'Ukraine'),
('URUG', 'UY', 'Uruguay', 'Uruguay'),
('USA_', 'US', 'États-Unis', 'United States'),
('VANU', 'VU', 'Vanuatu', 'Vanuatu'),
('VENE', 'VE', 'Venezuela', 'Venezuela'),
('VIEA', 'VI', 'Iles Vierges américaines', 'Virgin Islands, U.S.'),
('VIEB', 'VG', 'Iles Vierges britanniques', 'Virgin Islands, British'),
('VIET', 'VN', 'Viêt Nam', 'Viet Nam'),
('WALI', 'WF', 'Wallis-et-Futuna', 'Wallis and Futuna'),
('YEME', 'YE', 'Yémen', 'Yemen'),
('YOUG', 'YU', 'Yougoslavie', 'Saint Pierre and Miquelon'),
('ZAMB', 'ZM', 'Zambie', 'Zambia'),
('ZIMB', 'ZW', 'Zimbabwe', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `idStat` int(5) NOT NULL AUTO_INCREMENT,
  `libStat` varchar(25) NOT NULL,
  PRIMARY KEY (`idStat`),
  KEY `STATUT_FK` (`idStat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`idStat`, `libStat`) VALUES
(1, 'Super Administrateur'),
(2, 'Administrateur'),
(3, 'Membre niveau 1'),
(4, 'Membre niveau 2'),
(5, 'Modérateur niveau 1'),
(6, 'Modérateur niveau 2'),
(7, 'Superviseur niveau 1'),
(8, 'Superviseur niveau 2');

-- --------------------------------------------------------

--
-- Structure de la table `thematique`
--

DROP TABLE IF EXISTS `thematique`;
CREATE TABLE IF NOT EXISTS `thematique` (
  `numThem` varchar(8) NOT NULL,
  `libThem` varchar(60) NOT NULL,
  `numLang` varchar(8) NOT NULL,
  PRIMARY KEY (`numThem`),
  KEY `THEMATIQUE_FK` (`numThem`),
  KEY `FK_ASSOCIATION_4` (`numLang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thematique`
--

INSERT INTO `thematique` (`numThem`, `libThem`, `numLang`) VALUES
('THEM0101', 'L\'&eacute;v&eacute;nement', 'FRAN01'),
('THEM0102', 'L\'acteur-clé', 'FRAN01'),
('THEM0103', 'Le mouvement émergeant', 'FRAN01'),
('THEM0104', 'L\'insolite / le clin d\'oeil', 'FRAN01'),
('THEM0201', 'The event', 'ANGL01'),
('THEM0202', 'The key player', 'ANGL01'),
('THEM0203', 'The emerging movement', 'ANGL01'),
('THEM0204', 'The unusual / the wink', 'ANGL01'),
('THEM0301', 'Die Veranstaltung', 'ALLE01'),
('THEM0302', 'Der Schlüsselakteur', 'ALLE01'),
('THEM0303', 'Die entstehende Bewegung', 'ALLE01'),
('THEM0304', 'Das Ungewöhnliche / das Augenzwinkern', 'ALLE01');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `pseudoUser` varchar(60) NOT NULL,
  `passUser` varchar(60) NOT NULL,
  `nomUser` varchar(60) DEFAULT NULL,
  `prenomUser` varchar(60) DEFAULT NULL,
  `eMailUser` varchar(70) NOT NULL,
  `confirmation_token` varchar(70) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(70) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `idStat` int(5) NOT NULL,
  PRIMARY KEY (`pseudoUser`,`passUser`),
  KEY `USER_FK` (`pseudoUser`,`passUser`),
  KEY `FK_ASSOCIATION_6` (`idStat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`pseudoUser`, `passUser`, `nomUser`, `prenomUser`, `eMailUser`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `idStat`) VALUES
('adminDemo', '$2y$10$SixNAi52dBMlFyajnSOGtuyrIg7YzkYSyTuwoGPE/xLmPw52xkcn.', 'Jean', 'Peuplu', 'admin@email.com', NULL, NULL, NULL, NULL, NULL, 3),
('admini', '$2y$10$9a/ACWkCEpdECqcXUJnZWewnazU9pQeqEhyrjbJAyOegMprja3a8i', 'Star', 'Joe', 'JoeStar@free.fr', NULL, NULL, NULL, NULL, NULL, 1),
('lorem_ipsum_input', '$2y$10$vLtGi1f846ezz5tqv2rhReASDFXQuJjAnpxwq6EoLt51Y0LylttQe', 'lorem_ipsum_input', 'lorem_ipsum_input', 'qsdqd@gmail.com', NULL, NULL, NULL, NULL, NULL, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `angle`
--
ALTER TABLE `angle`
  ADD CONSTRAINT `FK_ASSOCIATION_3` FOREIGN KEY (`numLang`) REFERENCES `langue` (`numLang`);

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_ASSOCIATION_1` FOREIGN KEY (`numAngl`) REFERENCES `angle` (`numAngl`),
  ADD CONSTRAINT `FK_ASSOCIATION_2` FOREIGN KEY (`numThem`) REFERENCES `thematique` (`numThem`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_ASSOCIATION_8` FOREIGN KEY (`numArt`) REFERENCES `article` (`numArt`),
  ADD CONSTRAINT `FK_ASSOCIATION_9` FOREIGN KEY (`numMemb`) REFERENCES `membre` (`numMemb`);

--
-- Contraintes pour la table `commentplus`
--
ALTER TABLE `commentplus`
  ADD CONSTRAINT `FK_COMMENTPLUS` FOREIGN KEY (`numSeqComR`,`numArtR`) REFERENCES `comment` (`numSeqCom`, `numArt`),
  ADD CONSTRAINT `FK_COMMENTPLUS2` FOREIGN KEY (`numSeqCom`,`numArt`) REFERENCES `comment` (`numSeqCom`, `numArt`);

--
-- Contraintes pour la table `langue`
--
ALTER TABLE `langue`
  ADD CONSTRAINT `FK_ASSOCIATION_7` FOREIGN KEY (`numPays`) REFERENCES `pays` (`numPays`);

--
-- Contraintes pour la table `likeart`
--
ALTER TABLE `likeart`
  ADD CONSTRAINT `FK_LIKEART` FOREIGN KEY (`numArt`) REFERENCES `article` (`numArt`),
  ADD CONSTRAINT `FK_LIKEART2` FOREIGN KEY (`numMemb`) REFERENCES `membre` (`numMemb`);

--
-- Contraintes pour la table `likecom`
--
ALTER TABLE `likecom`
  ADD CONSTRAINT `FK_LIKECOM` FOREIGN KEY (`numSeqCom`,`numArt`) REFERENCES `comment` (`numSeqCom`, `numArt`),
  ADD CONSTRAINT `FK_LIKECOM2` FOREIGN KEY (`numMemb`) REFERENCES `membre` (`numMemb`);

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
  ADD CONSTRAINT `FK_ASSOCIATION_10` FOREIGN KEY (`idStat`) REFERENCES `statut` (`idStat`);

--
-- Contraintes pour la table `motcle`
--
ALTER TABLE `motcle`
  ADD CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (`numLang`) REFERENCES `langue` (`numLang`);

--
-- Contraintes pour la table `motclearticle`
--
ALTER TABLE `motclearticle`
  ADD CONSTRAINT `FK_MotCleArt1` FOREIGN KEY (`numMotCle`) REFERENCES `motcle` (`numMotCle`),
  ADD CONSTRAINT `FK_MotCleArt2` FOREIGN KEY (`numArt`) REFERENCES `article` (`numArt`);

--
-- Contraintes pour la table `thematique`
--
ALTER TABLE `thematique`
  ADD CONSTRAINT `FK_ASSOCIATION_4` FOREIGN KEY (`numLang`) REFERENCES `langue` (`numLang`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_ASSOCIATION_6` FOREIGN KEY (`idStat`) REFERENCES `statut` (`idStat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
