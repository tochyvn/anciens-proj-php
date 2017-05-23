
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- achats
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `achats`;

CREATE TABLE `achats`
(
    `date_achat` DATE DEFAULT '0000-00-00' NOT NULL,
    `id_user` INTEGER NOT NULL,
    `id_jeton` INTEGER NOT NULL,
    PRIMARY KEY (`date_achat`,`id_user`,`id_jeton`),
    INDEX `FK_Achats_id_jeton` (`id_jeton`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- enchere
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `enchere`;

CREATE TABLE `enchere`
(
    `id_enchere` INTEGER NOT NULL AUTO_INCREMENT,
    `date_debut` DATE,
    `date_fin` DATE,
    `ref_produit` INTEGER,
    PRIMARY KEY (`id_enchere`),
    INDEX `FK_Enchere_ref_produit` (`ref_produit`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- jeton
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `jeton`;

CREATE TABLE `jeton`
(
    `id_jeton` INTEGER NOT NULL AUTO_INCREMENT,
    `nom_produit` VARCHAR(25),
    PRIMARY KEY (`id_jeton`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mise
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mise`;

CREATE TABLE `mise`
(
    `date_mise` DATETIME,
    `prix_mise` DECIMAL(10,2) DEFAULT 0.00 NOT NULL,
    `id_enchere` INTEGER NOT NULL,
    `id_user` INTEGER NOT NULL,
    PRIMARY KEY (`prix_mise`,`id_enchere`,`id_user`),
    INDEX `FK_Mise_id_user` (`id_user`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- produit
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `produit`;

CREATE TABLE `produit`
(
    `ref_produit` INTEGER NOT NULL AUTO_INCREMENT,
    `produit` VARCHAR(25),
    PRIMARY KEY (`ref_produit`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id_user` INTEGER NOT NULL AUTO_INCREMENT,
    `login` VARCHAR(50),
    `nom` VARCHAR(35),
    `prenom` VARCHAR(35),
    `ville` VARCHAR(25),
    `role` INTEGER NOT NULL,
    PRIMARY KEY (`id_user`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
