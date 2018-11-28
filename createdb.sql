SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `phone` ;
CREATE SCHEMA IF NOT EXISTS `phone` DEFAULT CHARACTER SET latin1 ;
USE `phone` ;

-- -----------------------------------------------------
-- Table `phone`.`config`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`config` ;

CREATE TABLE IF NOT EXISTS `phone`.`config` (
  `idConfig` INT(11) NOT NULL AUTO_INCREMENT,
  `c_move` VARCHAR(45) NOT NULL,
  `c_sens` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idConfig`),
  UNIQUE INDEX `c_move_UNIQUE` (`c_move` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`fabricants`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`fabricants` ;

CREATE TABLE IF NOT EXISTS `phone`.`fabricants` (
  `idFabricants` INT(11) NOT NULL AUTO_INCREMENT,
  `f_marque` VARCHAR(45) NOT NULL,
  `f_ean` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFabricants`),
  UNIQUE INDEX `f_marque_UNIQUE` (`f_marque` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`models`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`models` ;

CREATE TABLE IF NOT EXISTS `phone`.`models` (
  `idModels` INT(11) NOT NULL AUTO_INCREMENT,
  `m_ean` VARCHAR(45) NULL DEFAULT NULL,
  `m_gu` VARCHAR(45) NULL DEFAULT NULL,
  `m_desc` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idModels`),
  UNIQUE INDEX `m_ean` (`m_ean` ASC),
  UNIQUE INDEX `m_gu` (`m_gu` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 95
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`stock`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`stock` ;

CREATE TABLE IF NOT EXISTS `phone`.`stock` (
  `idStock` INT(11) NOT NULL AUTO_INCREMENT,
  `s_ean` VARCHAR(45) NULL DEFAULT NULL,
  `s_imei` VARCHAR(45) NULL DEFAULT NULL,
  `s_dateAjout` VARCHAR(45) NULL DEFAULT NULL,
  `s_user` INT(11) NOT NULL,
  PRIMARY KEY (`idStock`))
ENGINE = InnoDB
AUTO_INCREMENT = 766
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`mouvements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`mouvements` ;

CREATE TABLE IF NOT EXISTS `phone`.`mouvements` (
  `idMouvements` INT(11) NOT NULL,
  `mv_user` INT(11) NOT NULL,
  `mv_date` VARCHAR(45) NULL DEFAULT NULL,
  `Config_idConfig` INT(11) NOT NULL,
  `Stock_idStock` INT(11) NOT NULL,
  PRIMARY KEY (`idMouvements`, `Config_idConfig`, `Stock_idStock`),
  INDEX `fk_Mouvements_Config1_idx` (`Config_idConfig` ASC),
  INDEX `fk_Mouvements_Stock1_idx` (`Stock_idStock` ASC),
  CONSTRAINT `fk_Mouvements_Config1`
    FOREIGN KEY (`Config_idConfig`)
    REFERENCES `phone`.`config` (`idConfig`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mouvements_Stock1`
    FOREIGN KEY (`Stock_idStock`)
    REFERENCES `phone`.`stock` (`idStock`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`roles` ;

CREATE TABLE IF NOT EXISTS `phone`.`roles` (
  `idRoles` INT(11) NOT NULL AUTO_INCREMENT,
  `r_role` VARCHAR(45) NULL DEFAULT NULL,
  `r_pwd` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRoles`),
  UNIQUE INDEX `idRoles_UNIQUE` (`idRoles` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `phone`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phone`.`users` ;

CREATE TABLE IF NOT EXISTS `phone`.`users` (
  `idUsers` INT(11) NOT NULL AUTO_INCREMENT,
  `u_nom` VARCHAR(45) NOT NULL,
  `u_prenom` VARCHAR(45) NOT NULL,
  `u_codeVente` TEXT NOT NULL,
  `Roles_idRoles` INT(11) NOT NULL,
  PRIMARY KEY (`idUsers`, `Roles_idRoles`),
  INDEX `fk_Users_Roles_idx` (`Roles_idRoles` ASC),
  CONSTRAINT `fk_Users_Roles`
    FOREIGN KEY (`Roles_idRoles`)
    REFERENCES `phone`.`roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = latin1;

USE `phone` ;

-- -----------------------------------------------------
-- Placeholder table for view `phone`.`history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `phone`.`history` (`idStock` INT, `s_ean` INT, `s_imei` INT, `f_marque` INT, `m_desc` INT, `m_gu` INT, `s_user` INT, `s_dateAjout` INT, `idMouvements` INT, `mv_date` INT, `mv_user` INT, `c_move` INT, `c_sens` INT);

-- -----------------------------------------------------
-- View `phone`.`history`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `phone`.`history` ;
DROP TABLE IF EXISTS `phone`.`history`;
USE `phone`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`fnac`@`localhost` SQL SECURITY DEFINER VIEW `phone`.`history` AS select `s`.`idStock` AS `idStock`,`s`.`s_ean` AS `s_ean`,`s`.`s_imei` AS `s_imei`,`fb`.`f_marque` AS `f_marque`,`md`.`m_desc` AS `m_desc`,`md`.`m_gu` AS `m_gu`,`s`.`s_user` AS `s_user`,`s`.`s_dateAjout` AS `s_dateAjout`,`mvt`.`idMouvements` AS `idMouvements`,`mvt`.`mv_date` AS `mv_date`,`mvt`.`mv_user` AS `mv_user`,`cf`.`c_move` AS `c_move`,`cf`.`c_sens` AS `c_sens` from ((((`phone`.`stock` `s` join `phone`.`fabricants` `fb` on((left(`s`.`s_ean`,4) = `fb`.`f_ean`))) join `phone`.`models` `md` on((`s`.`s_ean` = `md`.`m_ean`))) left join `phone`.`mouvements` `mvt` on((`s`.`idStock` = `mvt`.`Stock_idStock`))) left join `phone`.`config` `cf` on((`mvt`.`Config_idConfig` = `cf`.`idConfig`))) where (isnull(`mvt`.`Stock_idStock`) or (`mvt`.`Stock_idStock` = `s`.`idStock`)) order by `s`.`idStock`;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
