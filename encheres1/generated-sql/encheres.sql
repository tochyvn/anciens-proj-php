
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- ACHAT
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ACHAT`;

CREATE TABLE `ACHAT`
(
    `date_achat` VARCHAR(14) NOT NULL,
    `pseudo` VARCHAR(25) NOT NULL,
    `id_pack` INTEGER NOT NULL,
    PRIMARY KEY (`date_achat`,`pseudo`,`id_pack`),
    INDEX `ACHAT_fi_192d6e` (`pseudo`),
    INDEX `ACHAT_fi_401713` (`id_pack`),
    CONSTRAINT `ACHAT_fk_192d6e`
        FOREIGN KEY (`pseudo`)
        REFERENCES `USER` (`pseudo`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `ACHAT_fk_401713`
        FOREIGN KEY (`id_pack`)
        REFERENCES `PACKJETON` (`id_pack`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ARTICLE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ARTICLE`;

CREATE TABLE `ARTICLE`
(
    `id_art` INTEGER NOT NULL AUTO_INCREMENT,
    `nom_art` VARCHAR(25) NOT NULL,
    `prix` DECIMAL NOT NULL,
    `path` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_art`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ENCHERE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ENCHERE`;

CREATE TABLE `ENCHERE`
(
    `id_ench` INTEGER NOT NULL AUTO_INCREMENT,
    `date_debut` DATETIME NOT NULL,
    `date_fin` DATETIME NOT NULL,
    `id_art` INTEGER NOT NULL,
    PRIMARY KEY (`id_ench`),
    INDEX `ENCHERE_fi_1c25f7` (`id_art`),
    CONSTRAINT `ENCHERE_fk_1c25f7`
        FOREIGN KEY (`id_art`)
        REFERENCES `ARTICLE` (`id_art`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- MISE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `MISE`;

CREATE TABLE `MISE`
(
    `prix` DECIMAL NOT NULL,
    `pseudo` VARCHAR(25) NOT NULL,
    `id_ench` INTEGER NOT NULL,
    PRIMARY KEY (`prix`,`pseudo`,`id_ench`),
    INDEX `MISE_fi_192d6e` (`pseudo`),
    INDEX `MISE_fi_8a8e1d` (`id_ench`),
    CONSTRAINT `MISE_fk_192d6e`
        FOREIGN KEY (`pseudo`)
        REFERENCES `USER` (`pseudo`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `MISE_fk_8a8e1d`
        FOREIGN KEY (`id_ench`)
        REFERENCES `ENCHERE` (`id_ench`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
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
    `pseudo` VARCHAR(25) NOT NULL,
    `passwd` VARCHAR(25) NOT NULL,
    `nom` VARCHAR(25) NOT NULL,
    `prenom` VARCHAR(25) NOT NULL,
    `date_naiss` DATE NOT NULL,
    `pays` VARCHAR(25) NOT NULL,
    `adresse` VARCHAR(100) NOT NULL,
    `telephone` CHAR(10) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `role` INTEGER NOT NULL,
    PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
