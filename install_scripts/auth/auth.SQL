-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `pass` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sessions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `user_ip` VARCHAR(255) NOT NULL,
  `user_agent` VARCHAR(255) NOT NULL,
  `expires` BIGINT NOT NULL,
  `crated` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sessions_users_idx` (`user_id` ASC),
  UNIQUE INDEX `token_UNIQUE` (`token` ASC),
  UNIQUE INDEX `expires_UNIQUE` (`expires` ASC),
  UNIQUE INDEX `crated_UNIQUE` (`crated` ASC),
  CONSTRAINT `fk_sessions_users`
  FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user_roles` (
  `roles_id` INT UNSIGNED NOT NULL,
  `users_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`roles_id`, `users_id`),
  INDEX `fk_roles_has_users_users1_idx` (`users_id` ASC),
  INDEX `fk_roles_has_users_roles1_idx` (`roles_id` ASC),
  CONSTRAINT `fk_roles_has_users_roles1`
  FOREIGN KEY (`roles_id`)
    REFERENCES `mydb`.`roles` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  CONSTRAINT `fk_roles_has_users_users1`
  FOREIGN KEY (`users_id`)
    REFERENCES `mydb`.`users` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
