
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- ACHAT
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ACHAT`;

CREATE TABLE `ACHAT`
(
    `date_achat` DATETIME NOT NULL,
    `pseudo` VARCHAR(25) NOT NULL,
    `passwd` VARCHAR(25) NOT NULL,
    `id_pack` INTEGER NOT NULL,
    PRIMARY KEY (`date_achat`,`pseudo`,`passwd`,`id_pack`),
    INDEX `pseudo` (`pseudo`, `passwd`),
    INDEX `id_pack` (`id_pack`),
    CONSTRAINT `achat_ibfk_1`
        FOREIGN KEY (`pseudo`,`passwd`)
        REFERENCES `USER` (`pseudo`,`passwd`),
    CONSTRAINT `achat_ibfk_2`
        FOREIGN KEY (`id_pack`)
        REFERENCES `PACKJETON` (`id_pack`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ARTICLE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ARTICLE`;

CREATE TABLE `ARTICLE`
(
    `id_art` INTEGER NOT NULL AUTO_INCREMENT,
    `nom_art` VARCHAR(50) NOT NULL,
    `prix` DECIMAL NOT NULL,
    `path` VARCHAR(50),
    PRIMARY KEY (`id_art`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ENCHERE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ENCHERE`;

CREATE TABLE `ENCHERE`
(
    `id_ench` INTEGER NOT NULL AUTO_INCREMENT,
    `date_debut` DATE NOT NULL,
    `heure_debut` TIME NOT NULL,
    `date_fin` DATE NOT NULL,
    `heure_fin` TIME NOT NULL,
    `id_art` INTEGER NOT NULL,
    PRIMARY KEY (`id_ench`),
    INDEX `id_art` (`id_art`),
    CONSTRAINT `enchere_ibfk_1`
        FOREIGN KEY (`id_art`)
        REFERENCES `ARTICLE` (`id_art`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- MISE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `MISE`;

CREATE TABLE `MISE`
(
    `id_ench` INTEGER NOT NULL,
    `pseudo` VARCHAR(25) NOT NULL,
    `passwd` VARCHAR(25) NOT NULL,
    `prix` FLOAT NOT NULL,
    PRIMARY KEY (`id_ench`,`pseudo`,`passwd`,`prix`),
    INDEX `pseudo` (`pseudo`, `passwd`),
    CONSTRAINT `mise_ibfk_1`
        FOREIGN KEY (`pseudo`,`passwd`)
        REFERENCES `USER` (`pseudo`,`passwd`),
    CONSTRAINT `mise_ibfk_2`
        FOREIGN KEY (`id_ench`)
        REFERENCES `ENCHERE` (`id_ench`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PACKJETON
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PACKJETON`;

CREATE TABLE `PACKJETON`
(
    `id_pack` INTEGER NOT NULL AUTO_INCREMENT,
    `jetons` INTEGER NOT NULL,
    PRIMARY KEY (`id_pack`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- USER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `USER`;

CREATE TABLE `USER`
(
    `pseudo` VARCHAR(25) DEFAULT '' NOT NULL,
    `passwd` VARCHAR(25) DEFAULT '' NOT NULL,
    `nom` VARCHAR(25),
    `prenom` VARCHAR(25),
    `dateNaiss` DATE,
    `pays` VARCHAR(25),
    `adresse` VARCHAR(100),
    `telephone` CHAR(10),
    `email` VARCHAR(50),
    `role` INTEGER,
    PRIMARY KEY (`pseudo`,`passwd`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
