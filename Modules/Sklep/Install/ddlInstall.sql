SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `db1_galeria_h2_pl` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;

-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Kraje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Kraje` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nazwa` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Kraje` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Klienci`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Klienci` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `imie` VARCHAR(45) NULL ,
  `nazwisko` VARCHAR(45) NULL ,
  `krajId` INT UNSIGNED NOT NULL ,
  `miasto` VARCHAR(80) NOT NULL ,
  `ulica` VARCHAR(150) NOT NULL ,
  `nrDomu` VARCHAR(10) NOT NULL ,
  `nrMieszkania` VARCHAR(10) NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `kodPocztowy` VARCHAR(10) NOT NULL ,
  `nrTel` VARCHAR(10) NULL ,
  `nrTel2` VARCHAR(10) NULL ,
  `czyFirma` CHAR(1)  NOT NULL DEFAULT 'N' ,
  `nazwaFirmy` VARCHAR(200) NULL ,
  `nip` VARCHAR(20) NULL ,
  `dostKrajId` INT UNSIGNED NULL ,
  `dostMiasto` VARCHAR(80) NULL ,
  `dostUlica` VARCHAR(150) NULL ,
  `dostNrDomu` VARCHAR(10) NULL ,
  `dostNrMieszkania` VARCHAR(10) NULL ,
  `dostEmail` VARCHAR(50) NULL ,
  `dostKodPocztowy` VARCHAR(10) NULL ,
  `dostNrTel` VARCHAR(10) NULL ,
  `dostNrTel2` VARCHAR(10) NULL ,
  `dostCzyFirma` CHAR NULL DEFAULT 'N' ,
  `dostNazwaFirmy` VARCHAR(200) NULL ,
  `dostNip` VARCHAR(20) NULL ,
  `login` VARCHAR(20) NULL ,
  `pass` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Kraj`
    FOREIGN KEY (`krajId` )
    REFERENCES `db1_galeria_h2_pl`.`Kraje` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `FK_KrajDost`
    FOREIGN KEY (`dostKrajId` )
    REFERENCES `db1_galeria_h2_pl`.`Kraje` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Klienci` (`id` ASC) ;

CREATE INDEX `FK_Kraj` ON `db1_galeria_h2_pl`.`Klienci` (`krajId` ASC) ;

CREATE INDEX `FK_KrajDost` ON `db1_galeria_h2_pl`.`Klienci` (`dostKrajId` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Dostawy`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Dostawy` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `cena` DECIMAL(10,2)  NOT NULL ,
  `opis` VARCHAR(200) NULL ,
  `sortkey` INT NOT NULL ,
  `nazwa` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Dostawy` (`id` ASC) ;

CREATE UNIQUE INDEX `sortkey_UNIQUE` ON `db1_galeria_h2_pl`.`Dostawy` (`sortkey` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Platnosci`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Platnosci` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `opis` VARCHAR(250) NULL ,
  `nazwa` VARCHAR(100) NOT NULL ,
  `cena` DECIMAL(10,2)  NOT NULL ,
  `sortkey` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Platnosci` (`id` ASC) ;

CREATE UNIQUE INDEX `sortkey_UNIQUE` ON `db1_galeria_h2_pl`.`Platnosci` (`sortkey` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Zamowienia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Zamowienia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `FKKlient` INT UNSIGNED NOT NULL ,
  `FkDostawa` INT UNSIGNED NOT NULL ,
  `FKPlatnosci` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `FKKlient`) ,
  CONSTRAINT `FKKlient`
    FOREIGN KEY (`FKKlient` )
    REFERENCES `db1_galeria_h2_pl`.`Klienci` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `Fk_Dostawa`
    FOREIGN KEY (`FkDostawa` )
    REFERENCES `db1_galeria_h2_pl`.`Dostawy` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `FK_Platnosci`
    FOREIGN KEY (`FKPlatnosci` )
    REFERENCES `db1_galeria_h2_pl`.`Platnosci` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Zamowienia` (`id` ASC) ;

CREATE INDEX `FKKlient` ON `db1_galeria_h2_pl`.`Zamowienia` (`FKKlient` ASC) ;

CREATE INDEX `Fk_Dostawa` ON `db1_galeria_h2_pl`.`Zamowienia` (`FkDostawa` ASC) ;

CREATE UNIQUE INDEX `FKPlatnosci_UNIQUE` ON `db1_galeria_h2_pl`.`Zamowienia` (`FKPlatnosci` ASC) ;

CREATE INDEX `FK_Platnosci` ON `db1_galeria_h2_pl`.`Zamowienia` (`FKPlatnosci` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Towary`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Towary` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `cena` DECIMAL(10,2)  NOT NULL DEFAULT 0 ,
  `ilosc` INT UNSIGNED NOT NULL DEFAULT 1 ,
  `obrazFull` VARCHAR(180) NOT NULL ,
  `obrazMin` VARCHAR(180) NOT NULL ,
  `status` CHAR NOT NULL ,
  `zarezerwowany` CHAR NOT NULL DEFAULT 'N' ,
  `nazwa` VARCHAR(200) NOT NULL ,
  `opis` VARCHAR(300) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Towary` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`ZamowieniaTowary`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`ZamowieniaTowary` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `FkZam` INT UNSIGNED NULL ,
  `FkTow` INT UNSIGNED NULL ,
  `ilosc` INT UNSIGNED NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FKZam`
    FOREIGN KEY (`FkZam` )
    REFERENCES `db1_galeria_h2_pl`.`Zamowienia` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FKTow`
    FOREIGN KEY (`FkTow` )
    REFERENCES `db1_galeria_h2_pl`.`Towary` (`id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`ZamowieniaTowary` (`id` ASC) ;

CREATE INDEX `FKZam` ON `db1_galeria_h2_pl`.`ZamowieniaTowary` (`FkZam` ASC) ;

CREATE INDEX `FKTow` ON `db1_galeria_h2_pl`.`ZamowieniaTowary` (`FkTow` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`Oferty`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`Oferty` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tytul` VARCHAR(250) NOT NULL ,
  `opis` VARCHAR(300) NULL ,
  `FKGrupy` INT UNSIGNED NOT NULL ,
  `idStrony` INT UNSIGNED NULL ,
  `opisShort` VARCHAR(150) NULL ,
  `obrazTyt` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`Oferty` (`id` ASC) ;

CREATE UNIQUE INDEX `idStrony_UNIQUE` ON `db1_galeria_h2_pl`.`Oferty` (`idStrony` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`OfertyTowary`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`OfertyTowary` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `FKTow` INT UNSIGNED NULL ,
  `FkOferta` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Tow`
    FOREIGN KEY (`FKTow` )
    REFERENCES `db1_galeria_h2_pl`.`Towary` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_Oferta`
    FOREIGN KEY (`FkOferta` )
    REFERENCES `db1_galeria_h2_pl`.`Oferty` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`OfertyTowary` (`id` ASC) ;

CREATE INDEX `FK_Tow` ON `db1_galeria_h2_pl`.`OfertyTowary` (`FKTow` ASC) ;

CREATE INDEX `FK_Oferta` ON `db1_galeria_h2_pl`.`OfertyTowary` (`FkOferta` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`ZamowieniaHistoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`ZamowieniaHistoria` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `mod` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `idTow` INT UNSIGNED NULL ,
  `FKKlientId` INT UNSIGNED NULL ,
  `bDeleted` CHAR NOT NULL DEFAULT 'N' ,
  `FKDostawa` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
PACK_KEYS = DEFAULT;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`ZamowieniaHistoria` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`ZamowieniaTowaryHistoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`ZamowieniaTowaryHistoria` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idZT` INT UNSIGNED NULL ,
  `FKZam` INT UNSIGNED NULL ,
  `FKTow` INT UNSIGNED NULL ,
  `mod` TIMESTAMP NOT NULL ,
  `bDeleted` CHAR NOT NULL DEFAULT 'N' ,
  `ilosc` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`ZamowieniaTowaryHistoria` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`TowaryHistoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`TowaryHistoria` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `bDeleted` CHAR NOT NULL DEFAULT 'N' ,
  `mod` TIMESTAMP NOT NULL DEFAULT current_timestamp ,
  `idTow` INT UNSIGNED NULL ,
  `cena` DECIMAL(10,2)  NULL ,
  `ilosc` INT NULL ,
  `obrazFull` VARCHAR(180) NOT NULL ,
  `obrazMin` VARCHAR(180) NOT NULL ,
  `status` CHAR NULL ,
  `zarezerwowany` CHAR NULL ,
  `nazwa` VARCHAR(200) NULL ,
  `opis` VARCHAR(300) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`TowaryHistoria` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`KrajeLang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`KrajeLang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `lang` VARCHAR(3) NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `FkKraj` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Kraje2`
    FOREIGN KEY (`FkKraj` )
    REFERENCES `db1_galeria_h2_pl`.`Kraje` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`KrajeLang` (`id` ASC) ;

CREATE UNIQUE INDEX `name_UNIQUE` ON `db1_galeria_h2_pl`.`KrajeLang` (`name` ASC) ;

CREATE INDEX `FK_Kraje2` ON `db1_galeria_h2_pl`.`KrajeLang` (`FkKraj` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`PlatnosciLang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`PlatnosciLang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `lang` VARCHAR(3) NOT NULL ,
  `FKPlatnosci` INT UNSIGNED NOT NULL ,
  `opis` VARCHAR(250) NULL ,
  `nazwa` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Platnosci2`
    FOREIGN KEY (`FKPlatnosci` )
    REFERENCES `db1_galeria_h2_pl`.`Platnosci` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`PlatnosciLang` (`id` ASC) ;

CREATE UNIQUE INDEX `lang_UNIQUE` ON `db1_galeria_h2_pl`.`PlatnosciLang` (`lang` ASC) ;

CREATE INDEX `FK_Platnosci2` ON `db1_galeria_h2_pl`.`PlatnosciLang` (`FKPlatnosci` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`OfertyLang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`OfertyLang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tytul` VARCHAR(250) NOT NULL ,
  `opis` VARCHAR(300) NULL ,
  `lang` VARCHAR(3) NOT NULL ,
  `FKOferta` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Oferta2`
    FOREIGN KEY (`FKOferta` )
    REFERENCES `db1_galeria_h2_pl`.`Oferty` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`OfertyLang` (`id` ASC) ;

CREATE UNIQUE INDEX `lang_UNIQUE` ON `db1_galeria_h2_pl`.`OfertyLang` (`lang` ASC) ;

CREATE INDEX `FK_Oferta2` ON `db1_galeria_h2_pl`.`OfertyLang` (`FKOferta` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`TowaryLang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`TowaryLang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `lang` VARCHAR(3) NOT NULL ,
  `FKTow` INT UNSIGNED NOT NULL ,
  `nazwa` VARCHAR(200) NOT NULL ,
  `opis` VARCHAR(300) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Tow2`
    FOREIGN KEY (`FKTow` )
    REFERENCES `db1_galeria_h2_pl`.`Towary` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`TowaryLang` (`id` ASC) ;

CREATE UNIQUE INDEX `lang_UNIQUE` ON `db1_galeria_h2_pl`.`TowaryLang` (`lang` ASC) ;

CREATE INDEX `FK_Tow2` ON `db1_galeria_h2_pl`.`TowaryLang` (`FKTow` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`KlienciHistoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`KlienciHistoria` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `imie` VARCHAR(45) NULL ,
  `nazwisko` VARCHAR(45) NULL ,
  `krajId` INT UNSIGNED NOT NULL ,
  `miasto` VARCHAR(80) NOT NULL ,
  `ulica` VARCHAR(150) NOT NULL ,
  `nrDomu` VARCHAR(10) NOT NULL ,
  `nrMieszkania` VARCHAR(10) NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `kodPocztowy` VARCHAR(10) NOT NULL ,
  `nrTel` VARCHAR(10) NULL ,
  `nrTel2` VARCHAR(10) NULL ,
  `czyFirma` CHAR NOT NULL DEFAULT 'N' ,
  `nazwaFirmy` VARCHAR(200) NULL ,
  `nip` VARCHAR(20) NULL ,
  `dostKrajId` INT UNSIGNED NOT NULL ,
  `dostMiasto` VARCHAR(80) NULL ,
  `dostUlica` VARCHAR(150) NULL ,
  `dostNrDomu` VARCHAR(10) NULL ,
  `dostNrMieszkania` VARCHAR(10) NULL ,
  `dostEmail` VARCHAR(50) NULL ,
  `dostKodPocztowy` VARCHAR(10) NULL ,
  `dostNrTel` VARCHAR(10) NULL ,
  `dostNrTel2` VARCHAR(10) NULL ,
  `dostCzyFirma` CHAR NULL ,
  `dostNazwaFirmy` VARCHAR(200) NULL ,
  `dostNip` VARCHAR(20) NULL ,
  `mod` TIMESTAMP NOT NULL ,
  `idKli` INT UNSIGNED NOT NULL ,
  `bDeleted` CHAR NOT NULL DEFAULT 'N' ,
  `login` VARCHAR(20) NULL ,
  `pass` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`KlienciHistoria` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `db1_galeria_h2_pl`.`DostawyLang`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `db1_galeria_h2_pl`.`DostawyLang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `lang` VARCHAR(3) NOT NULL ,
  `FKDostawy` INT UNSIGNED NOT NULL ,
  `opis` VARCHAR(200) NULL ,
  `nazwa` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Dostawy2`
    FOREIGN KEY (`FKDostawy` )
    REFERENCES `db1_galeria_h2_pl`.`Dostawy` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE UNIQUE INDEX `id_UNIQUE` ON `db1_galeria_h2_pl`.`DostawyLang` (`id` ASC) ;

CREATE UNIQUE INDEX `lang_UNIQUE` ON `db1_galeria_h2_pl`.`DostawyLang` (`lang` ASC) ;

CREATE INDEX `FK_Dostawy2` ON `db1_galeria_h2_pl`.`DostawyLang` (`FKDostawy` ASC) ;


DELIMITER $$
USE `db1_galeria_h2_pl`$$
CREATE trigger ai_Zamowienia AFTER INSERT ON `Zamowienia`
FOR EACH
ROW BEGIN
INSERT INTO `ZamowieniaHistoria` ( `idTow` , `FKKlientId` , `FKDostawa` , `FKPlatnosci` , insid, Uwagi,
`status` , dataStatusu, adminId )
VALUES (
NEW.`id` , NEW.`FKKlient` , NEW.`FkDostawa` , NEW.`FKPlatnosci` , NEW.insid, NEW.Uwagi, NEW.`status` , NEW.`dataStatusu` , NEW.adminId);
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger ad_Zamowienia
after delete on `Zamowienia`
FOR EACH ROW BEGIN
   INSERT INTO `ZamowieniaHistoria` (`idTow`, `FKKlientId`, `FKDostawa`, `bDeleted`)
   VALUES (OLD.`id`, OLD.`FKKlient`, OLD.`FKDostawa`, 'T');
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger au_Zamowienia
after update on `Zamowienia`
FOR EACH ROW BEGIN
   INSERT INTO `ZamowieniaHistoria` (`idTow`, `FKKlientId`, `FKDostawa`, `FKPlatnosci` , insid, Uwagi,
`status` , `dataStatusu`, `adminId`)
   VALUES (NEW.`id`, NEW.`FKKlient`, NEW.`FKDostawa`, NEW.`FKPlatnosci` , NEW.insid, NEW.Uwagi, NEW.`status` , NEW.`dataStatusu` , NEW.adminId);
end;
$$


DELIMITER ;

DELIMITER $$
USE `db1_galeria_h2_pl`$$
create trigger ai_Towary
after insert on `Towary`
FOR EACH ROW BEGIN
   INSERT INTO `TowaryHistoria` (`idTow`, `cena`, `ilosc`, `obrazFull`, `obrazMin`, `status`, `zarezerwowany`, `nazwa`, `opis`)
   VALUES (NEW.`id`, NEW.`cena`, NEW.`ilosc`, NEW.`obrazFull`, NEW.`obrazMin`, NEW.`status`, NEW.`zarezerwowany`, NEW.`nazwa`, NEW.`opis`);
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger ad_Towary
after delete on `Towary`
FOR EACH ROW BEGIN
   INSERT INTO `TowaryHistoria` (`idTow`, `cena`, `ilosc`, `obrazFull`, `obrazMin`, `status`, `zarezerwowany`, `nazwa`, `opis`,`bDeleted`)
   VALUES (OLD.`id`, OLD.`cena`, OLD.`ilosc`, OLD.`obrazFull`, OLD.`obrazMin`, OLD.`status`, OLD.`zarezerwowany`, OLD.`nazwa`, OLD.`opis`, 'T');
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger au_Towary
after update on `Towary`
FOR EACH ROW BEGIN
   INSERT INTO `TowaryHistoria` (`idTow`, `cena`, `ilosc`, `obrazFull`, `obrazMin`, `status`, `zarezerwowany`, `nazwa`, `opis`)
   VALUES (NEW.`id`, NEW.`cena`, NEW.`ilosc`, NEW.`obrazFull`, NEW.`obrazMin`, NEW.`status`, NEW.`zarezerwowany`, NEW.`nazwa`, NEW.`opis`);
 end;
$$


DELIMITER ;

DELIMITER $$
USE `db1_galeria_h2_pl`$$
create trigger ai_ZamowieniaTowary
after insert on `ZamowieniaTowary`
FOR EACH ROW BEGIN
   INSERT INTO `ZamowieniaTowaryHistoria` (`idZT`, `FKZam`, `FKTow`, `ilosc`)
   VALUES (NEW.`id`, NEW.`FKZam`, NEW.`FKTow`, NEW.`ilosc`);
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger ad_ZamowieniaTowary
after delete on `ZamowieniaTowary`
FOR EACH ROW BEGIN
   INSERT INTO `ZamowieniaTowaryHistoria` (`idTZ`, `FKZam`, `FKTow`, `ilosc`, `bDeleted`)
   VALUES (OLD.`id`, OLD.`FKZam`, OLD.`FKTow`, OLD.`ilosc`, 'T');
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger au_ZamowieniaTowary
after update on `ZamowieniaTowary`
FOR EACH ROW BEGIN
   INSERT INTO `ZamowieniaTowaryHistoria` (`idTZ`, `FKZam`, `FKTow`, `ilosc`)
   VALUES (NEW.`id`, NEW.`FKZam`, NEW.`FKTow`, NEW.`ilosc`);
end;
$$


DELIMITER ;

DELIMITER $$
USE `db1_galeria_h2_pl`$$
create trigger ai_Klienci
after insert on `Klienci`
FOR EACH ROW BEGIN
   INSERT INTO `KlienciHistoria` (`imie`, `nazwisko`, `krajId`, `miasto`, `ulica`, `nrDomu`, 
                `nrMieszkania`, `email`, `kodPocztowy`, `nrTel`, `nrTel2`, `czyFirma`, `nazwaFirmy`, 
                `nip`, `dostKrajId`, `dostMiasto`, `dostUlica`, `dostNrDomu`, `dostNrMieszkania`, 
                `dostEmail`, `dostKodPocztowy`, `dostNrTel`, `dostNrTel2`, `dostCzyFirma`, `dostNazwaFirmy`, 
                `dostNip`,  `idKli`, `login`, `pass`) 
                VALUES 
                (new.`imie`, new.`nazwisko`, new.`krajId`, new.`miasto`, new.`ulica`, new.`nrDomu`, 
                new.`nrMieszkania`, new.`email`, new.`kodPocztowy`, new.`nrTel`, new.`nrTel2`, new.`czyFirma`, new.`nazwaFirmy`, 
                new.`nip`, new.`dostKrajId`, new.`dostMiasto`, new.`dostUlica`, new.`dostNrDomu`, new.`dostNrMieszkania`, 
                new.`dostEmail`, new.`dostKodPocztowy`, new.`dostNrTel`, new.`dostNrTel2`, new.`dostCzyFirma`, new.`dostNazwaFirmy`, 
                new.`dostNip`, new.`id`, new.`login`, new.`pass`);
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger ad_Klienci
after delete on `Klienci`
FOR EACH ROW BEGIN
   INSERT INTO `KlienciHistoria` (`imie`, `nazwisko`, `krajId`, `miasto`, `ulica`, `nrDomu`, 
                `nrMieszkania`, `email`, `kodPocztowy`, `nrTel`, `nrTel2`, `czyFirma`, `nazwaFirmy`, 
                `nip`, `dostKrajId`, `dostMiasto`, `dostUlica`, `dostNrDomu`, `dostNrMieszkania`, 
                `dostEmail`, `dostKodPocztowy`, `dostNrTel`, `dostNrTel2`, `dostCzyFirma`, `dostNazwaFirmy`, 
                `dostNip`, `idKli`, `login`, `pass`,`bDeleted`) 
                VALUES 
                (old.`imie`, old.`nazwisko`, old.`krajId`, old.`miasto`, old.`ulica`, old.`nrDomu`, 
                old.`nrMieszkania`, old.`email`, old.`kodPocztowy`, old.`nrTel`, old.`nrTel2`, old.`czyFirma`, old.`nazwaFirmy`, 
                old.`nip`, old.`dostKrajId`, old.`dostMiasto`, old.`dostUlica`, old.`dostNrDomu`, old.`dostNrMieszkania`, 
                old.`dostEmail`, old.`dostKodPocztowy`, old.`dostNrTel`, old.`dostNrTel2`, old.`dostCzyFirma`, old.`dostNazwaFirmy`, 
                old.`dostNip`, old.`id`, old.`login`, old.`pass`,'T');
end;
$$

USE `db1_galeria_h2_pl`$$

create trigger au_Klienci
after update on `Klienci`
FOR EACH ROW BEGIN
   INSERT INTO `KlienciHistoria` (`imie`, `nazwisko`, `krajId`, `miasto`, `ulica`, `nrDomu`, 
                `nrMieszkania`, `email`, `kodPocztowy`, `nrTel`, `nrTel2`, `czyFirma`, `nazwaFirmy`, 
                `nip`, `dostKrajId`, `dostMiasto`, `dostUlica`, `dostNrDomu`, `dostNrMieszkania`, 
                `dostEmail`, `dostKodPocztowy`, `dostNrTel`, `dostNrTel2`, `dostCzyFirma`, `dostNazwaFirmy`, 
                `dostNip`, `idKli`, `login`, `pass`) 
                VALUES 
                (new.`imie`, new.`nazwisko`, new.`krajId`, new.`miasto`, new.`ulica`, new.`nrDomu`, 
                new.`nrMieszkania`, new.`email`, new.`kodPocztowy`, new.`nrTel`, new.`nrTel2`, new.`czyFirma`, new.`nazwaFirmy`, 
                new.`nip`, new.`dostKrajId`, new.`dostMiasto`, new.`dostUlica`, new.`dostNrDomu`, new.`dostNrMieszkania`, 
                new.`dostEmail`, new.`dostKodPocztowy`, new.`dostNrTel`, new.`dostNrTel2`, new.`dostCzyFirma`, new.`dostNazwaFirmy`, 
                new.`dostNip`, new.`id`, new.`login`, new.`pass`);
end;
$$


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
