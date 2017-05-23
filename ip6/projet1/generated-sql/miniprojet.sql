
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Achat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Achat`;

CREATE TABLE `Achat`
(
    `dateAcht` DATE NOT NULL,
    `email` VARCHAR(25),
    `id` INTEGER,
    PRIMARY KEY (`dateAcht`),
    INDEX `FK_historiqueAchat_email` (`email`),
    INDEX `FK_historiqueAchat_id` (`id`),
    CONSTRAINT `FK_historiqueAchat_email`
        FOREIGN KEY (`email`)
        REFERENCES `Utilisateur` (`email`),
    CONSTRAINT `FK_historiqueAchat_id`
        FOREIGN KEY (`id`)
        REFERENCES `Jetons` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Enchere
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Enchere`;

CREATE TABLE `Enchere`
(
    `id` INTEGER NOT NULL,
    `dateDebut` DATE,
    `dateFin` DATE,
    `reference` INTEGER,
    `designation` VARCHAR(25),
    PRIMARY KEY (`id`),
    INDEX `FK_enchere_reference` (`reference`),
    CONSTRAINT `FK_enchere_reference`
        FOREIGN KEY (`reference`)
        REFERENCES `Produit` (`reference`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Jetons
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Jetons`;

CREATE TABLE `Jetons`
(
    `id` INTEGER NOT NULL,
    `designation` VARCHAR(25),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Mise
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Mise`;

CREATE TABLE `Mise`
(
    `prix` INTEGER NOT NULL,
    `dateProposition` DATE,
    `email` VARCHAR(25),
    `id` INTEGER,
    PRIMARY KEY (`prix`),
    INDEX `FK_mise_email` (`email`),
    INDEX `FK_mise_id` (`id`),
    CONSTRAINT `FK_mise_email`
        FOREIGN KEY (`email`)
        REFERENCES `Utilisateur` (`email`),
    CONSTRAINT `FK_mise_id`
        FOREIGN KEY (`id`)
        REFERENCES `Enchere` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Produit
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Produit`;

CREATE TABLE `Produit`
(
    `reference` INTEGER NOT NULL,
    `designation` VARCHAR(25) NOT NULL,
    `image` VARCHAR(25),
    `prix` INTEGER,
    PRIMARY KEY (`reference`,`designation`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Utilisateur
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Utilisateur`;

CREATE TABLE `Utilisateur`
(
    `email` VARCHAR(25) NOT NULL,
    `password` VARCHAR(25),
    `pseudo` INTEGER,
    `role` INTEGER,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
