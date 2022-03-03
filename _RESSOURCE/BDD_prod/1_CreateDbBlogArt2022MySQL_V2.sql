/**********************************************************************/
/* Blog des articles (BD MySQL) du cours M2203
//
// Création du script de la base de données BLOGART
//
// @Martine Bornerie    Le 22/01/22 16:22:00
//
// nom script : CreateDbBlogArt2022MySQL_OK.sql
//
*/
/**********************************************************************/
/*====================================================================*/
/*
** Format d'un article (détail tuple) :

	ILLUSTRATION / PHOTO ⇒ URL

	TITRE :			  100 caractères

	CHAPEAU :		  500 caractères

   ACCROCHE :       100 caractères

	PARAGRAPHE 1 :
     SOUS-TITRE 1 : 100 caractères
	  DÉTAIL :       1200 caractères

   PARAGRAPHE 2 :
     SOUS-TITRE 2 : 100 caractères
	  DÉTAIL :       1200 caractères

   PARAGRAPHE 3 :
	  DÉTAIL :	     1200 caractères

	CONCLUSION :	  800 caractères

	MOTS-CLÉS :		  60 caractères
**
*/
/*====================================================================*/

-- First we create the database

CREATE DATABASE BLOGART22
DEFAULT CHARACTER SET UTF8			  -- Tous les formats de caractères
DEFAULT COLLATE utf8_general_ci ;  --

-- SHOW VARIABLES;					  -- Voir les paramètres de la BD

-- Then we add a user to the database

GRANT ALL PRIVILEGES ON `BLOGART22`.* TO 'blogArt_user'@'%' IDENTIFIED BY 'blogArt_password';;
GRANT ALL PRIVILEGES ON `BLOGART22`.* TO 'blogArt_user'@'LOCALHOST' IDENTIFIED BY 'blogArt_password';;


-- Flush / Init all privileges
FLUSH PRIVILEGES;

-- Now we create the Database

-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 13 mars 2020 à 17:17
-- Version du serveur: 5.5.33
-- Version de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: BLOGART
--
USE BLOGART22;


-- --------------------------------------------------------------------
--
-- Structure de la table angle
--
/*====================================================================*/
/* Table : angle                                                	    */
/*====================================================================*/
create table angle
(
   numAngl varchar(8) not null,	-- PK numéro angle
   libAngl varchar(60) not null,	-- nom angle
   numLang varchar(8) not null,	-- FK numéro langue
   primary key (numAngl)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : ANGLE_FK                                     			       */
/*====================================================================*/
create index ANGLE_FK on angle
(
   numAngl
);


-- --------------------------------------------------------------------
--
-- Structure de la table thematique
--
/*====================================================================*/
/* Table : thematique                                                 */
/*====================================================================*/
create table thematique
(
   numThem varchar(8) not null,  -- PK numéro thématique
   libThem varchar(60) not null, -- nom thèmatique
   numLang varchar(8) not null,  -- FK numéro langue
   primary key (numThem)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : THEMATIQUE_FK                                              */
/*====================================================================*/
create index THEMATIQUE_FK on thematique
(
   NumThem
);


-- --------------------------------------------------------------------
--
-- Structure de la table langue
--
/*====================================================================*/
/* Table : langue                                                     */
/*====================================================================*/
create table langue
(
   numLang varchar(8) not null,  -- PK numéro langue
   lib1Lang varchar(30),         -- Libellé court langue
   lib2Lang varchar(60),         -- Libellé long langue
   numPays char(4) null,         -- FK sans CIR du code pays langue
   primary key (numLang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : LANGUE_FK                                                  */
/*====================================================================*/
create index LANGUE_FK on langue
(
   numLang
);


-- --------------------------------------------------------------------
--
-- Structure de la table PAYS
--
/*====================================================================*/
/* Table : PAYS                                                       */
/*====================================================================*/
create table PAYS
(
   numPays char(4) not null, -- numéro pays
   cdPays char(2) not null, -- code pays
   frPays varchar(255) not null, -- nom pays en français
   enPays varchar(255) default null, -- nom pays en anglais
   primary key (numPays)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : PAYS_FK                                                    */
/*====================================================================*/
create index PAYS_FK on PAYS
(
   numPays
);


-- --------------------------------------------------------------------
--
-- Structure de la table membre
--
/*====================================================================*/
/* Table : membre                                                     */
/*====================================================================*/
create table membre
(
   numMemb int(10) not null auto_increment, -- PK
   prenomMemb varchar(70) not null,
   nomMemb varchar(70) not null,
   pseudoMemb varchar(70) not null,
   passMemb varchar(70) not null,
   eMailMemb varchar(100) not null,
   dtCreaMemb timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   accordMemb bool DEFAULT TRUE,
   idStat int(5) not null,                  -- FK
   primary key (numMemb)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : MEMBRE_FK                                                  */
/*====================================================================*/
create index MEMBRE_FK on membre
(
   numMemb
);


-- --------------------------------------------------------------------
--
-- Structure de la table article
--
/*====================================================================*/
/* Table : article                                              	    */
/*====================================================================*/
create table article
(
   numArt int(8) not null auto_increment,   -- PK numéro article
   dtCreArt timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,	-- Date création article
   libTitrArt varchar(100),	   -- Titre article
   libChapoArt text(500),			-- Titre chapeau
   libAccrochArt varchar(100),	-- Accroche paragraphe 1
   parag1Art text(1200),			-- Paragraphe 1 chapeau
   libSsTitr1Art varchar(100),	-- Titre sous-titre 1
   parag2Art text(1200),			-- Paragraphe 2 sous-titre 2
   libSsTitr2Art varchar(100),	-- Titre sous-titre 2
   parag3Art text(1200),			-- Paragraphe 3
   libConclArt text(800),			-- Conclusion : Paragraphe conclusion
   urlPhotArt varchar(70),			-- url photo article
   numAngl varchar(8) not null,	-- FK numéro angle
   numThem varchar(8) not null,	-- FK numéro thématique
   primary key (numArt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : ARTICLE_FK                                     			    */
/*====================================================================*/
create index ARTICLE_FK on article
(
   numArt
);


-- --------------------------------------------------------------------
--
-- Structure de la table user
--
/*====================================================================*/
/* Table : user                                                 	    */
/*====================================================================*/
create table user
(
   pseudoUser varchar(60) not null,	-- PK login
   passUser varchar(60) not null,	-- PK password
   nomUser varchar(60) null,		   -- Nom facultatif
   prenomUser varchar(60) null,		-- Prénom facultatif
   eMailUser varchar(70) not null,  -- e-mail
   idStat int(5) not null,  -- FK
   primary key (pseudoUser, passUser)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : user_FK                                     				    */
/*====================================================================*/
create index user_FK on user
(
   pseudoUser,
   passUser
);


-- --------------------------------------------------------------------
--
-- Structure de la table statut
--
/*====================================================================*/
/* Table : statut                                                 	 */
/*====================================================================*/
create table statut
(
   idStat int(5) not null auto_increment,   -- PK
   libStat varchar(25) not null,
   primary key (idStat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : STATUT_FK                                     				 */
/*====================================================================*/
create index STATUT_FK on statut
(
   idStat
);


-- --------------------------------------------------------------------
--
-- Structure de la table motcle
--
/*====================================================================*/
/* Table : motcle                                                     */
/*====================================================================*/
create table motcle
(
   numMotCle int(8) not null auto_increment,   -- PK
   libMotCle varchar(60) not null,
   numLang varchar(8) not null,                -- FK
   primary key (numMotCle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : MOTCLE_FK                                                  */
/*====================================================================*/
create index MOTCLE_FK on motcle
(
   numMotCle
);


-- --------------------------------------------------------------------
--
-- Structure de la table motclearticle   (TJ)
--
/*====================================================================*/
/* Table : motclearticle                                              */
/*====================================================================*/
create table motclearticle
(
   numArt int(8) not null,    -- PK, FK
   numMotCle int(8) not null, -- PK, FK
   primary key (numArt, numMotCle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : MOTCLEARTICLE_FK                                           */
/*====================================================================*/
create index MOTCLEARTICLE_FK on motclearticle
(
   numArt
);

/*====================================================================*/
/* Index : MOTCLEARTICLE2_FK                                          */
/*====================================================================*/
create index MOTCLEARTICLE2_FK on motclearticle
(
   numMotCle
);


-- --------------------------------------------------------------------
--
-- Structure de la table comment
--
/*====================================================================*/
/* Table : comment                                                    */
/*====================================================================*/
create table comment
(
   numSeqCom int(10) not null,    -- PK (id. Relatif)
   numArt int(8) not null,        -- PK, FK
   dtCreCom timestamp DEFAULT CURRENT_TIMESTAMP, -- Date jour à la création comment
   libCom text(600) not null,     -- Au moins un caractère :-)
   attModOK bool default false,   -- Attente visa modération (Visible si true)
   dtModCom timestamp,   -- Date jour modif après modération (Visible ou pas)
   notifComKOAff text(300) default null, -- comment admin si reste Visible après modération
   delLogiq bool default false,   -- del logique comment => TRUE : Pas Affich
   numMemb int(10) not null,      -- FK
   primary key (numSeqCom, numArt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : COMMENT_FK                                                 */
/*====================================================================*/
create index COMMENT_FK on comment
(
   numSeqCom,
   numArt
);


-- --------------------------------------------------------------------
--
-- Structure de la table commentplus   (TJ)
--
/*====================================================================*/
/* Table : commentplus                                                */
/*====================================================================*/
create table commentplus
(
   numSeqCom int(10) not null,  -- PK, FK (id. Relatif)
   numArt int(8) not null,      -- PK, FK
   numSeqComR int(10) not null, -- PK, FK (id. Relatif)
   numArtR int(8) not null,     -- PK, FK
   primary key (numSeqCom, numArt, numSeqComR, numArtR)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : COMMENTPLUS_FK                                             */
/*====================================================================*/
create index COMMENTPLUS_FK on commentplus
(
   numSeqCom,
   numArt,
   numSeqComR,
   numArtR
);


-- --------------------------------------------------------------------
--
-- Structure de la table likeart   (TJ)
--
/*====================================================================*/
/* Table : likeart                                                    */
/*====================================================================*/
create table likeart
(
   numMemb int(10) not null, -- PK, FK
   numArt int(8) not null,   -- PK, FK
   likeA bool DEFAULT TRUE,
   primary key (numMemb, numArt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : LIKEART_FK                                                 */
/*====================================================================*/
create index LIKEART_FK on likeart
(
   numMemb,
   numArt
);


-- --------------------------------------------------------------------
--
-- Structure de la table likecom   (TJ)
--
/*====================================================================*/
/* Table : likecom                                                    */
/*====================================================================*/
create table likecom
(
   numMemb int(10) not null,   -- PK, FK
   numSeqCom int(10) not null, -- PK, FK (id. Relatif)
   numArt int(8) not null,     -- PK, FK
   likeC bool DEFAULT TRUE,
   primary key (numMemb, numSeqCom, numArt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*====================================================================*/
/* Index : LIKECOM_FK                                                 */
/*====================================================================*/
create index LIKECOM_FK on likecom
(
   numMemb,
   numSeqCom,
   numArt
);

-- --------------------------------------------------------------------


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
--
-- CIR : contraintes pour les tables exportées (ON RESTRICT)
--
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------


-- --------------------------------------------------------------------

alter table article add constraint FK_ASSOCIATION_1 foreign key (numAngl)
      references angle (numAngl) on delete restrict on update restrict;

alter table article add constraint FK_ASSOCIATION_2 foreign key (numThem)
      references thematique (numThem) on delete restrict on update restrict;

alter table angle add constraint FK_ASSOCIATION_3 foreign key (numLang)
      references langue (numLang) on delete restrict on update restrict;

alter table thematique add constraint FK_ASSOCIATION_4 foreign key (numLang)
      references langue (numLang) on delete restrict on update restrict;

alter table motcle add constraint FK_ASSOCIATION_5 foreign key (numLang)
      references langue (numLang) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table user add constraint FK_ASSOCIATION_6 foreign key (idStat)
      references statut (idStat) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table langue add constraint FK_ASSOCIATION_7 foreign key (numPays)
      references PAYS (numPays) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table comment add constraint FK_ASSOCIATION_8 foreign key (numArt)
      references article (numArt) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table comment add constraint FK_ASSOCIATION_9 foreign key (numMemb)
      references membre (numMemb) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table membre add constraint FK_ASSOCIATION_10 foreign key (idStat)
      references statut (idStat) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table commentplus add constraint FK_COMMENTPLUS foreign key (numSeqComR, numArtR)
      references comment (numSeqCom, numArt) on delete restrict on update restrict;

alter table commentplus add constraint FK_COMMENTPLUS2 foreign key (numSeqCom, numArt)
      references comment (numSeqCom, numArt) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table motclearticle add constraint FK_MotCleArt1 foreign key (numMotCle)
      references motcle (numMotCle) on delete restrict on update restrict;

alter table motclearticle add constraint FK_MotCleArt2 foreign key (numArt)
      references article (numArt) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table likeart add constraint FK_LIKEART foreign key (numArt)
      references article (numArt) on delete restrict on update restrict;

alter table likeart add constraint FK_LIKEART2 foreign key (numMemb)
      references membre (numMemb) on delete restrict on update restrict;

-- --------------------------------------------------------------------

alter table likecom add constraint FK_LIKECOM foreign key (numSeqCom, numArt)
      references comment (numSeqCom, numArt) on delete restrict on update restrict;

alter table likecom add constraint FK_LIKECOM2 foreign key (numMemb)
      references membre (numMemb) on delete restrict on update restrict;

-- --------------------------------------------------------------------


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------

