CREATE TABLE `tiksoft_db`.`AktualizacjeGrupy`
					(
						`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`sortkey` INT(10) UNSIGNED NOT NULL,
						`nazwa` VARCHAR(80) NOT NULL UNIQUE,
						 PRIMARY KEY (`id`)
				 	)
				 	ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_general_ci;"


CREATE TABLE `tiksoft_db`.`AktualizacjeProgramy`
					(
						`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`sortkey` INT(10) UNSIGNED NOT NULL UNIQUE,
						`nazwa` VARCHAR(80) NOT NULL UNIQUE,
						`active` CHAR(1) NOT NULL DEFAULT 'T',
						`fkGrupa` INT UNSIGNED NOT NULL,
						PRIMARY KEY (`id`),
						CONSTRAINT `FkGr` 
							FOREIGN KEY (`fkGrupa`)
							REFERENCES `AktualizacjeGrupy`(`id`)
							ON UPDATE CASCADE
							ON DELETE RESTRICT
				 	)
				 	ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_general_ci;"


CREATE TABLE `tiksoft_db`.`AktualizacjeOpisy`
					(
						`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						`dataWydania` DATE NOT NULL,
						`wersja` VARCHAR(25) NOT NULL,
						`opis` TEXT NOT NULL,
						`fkProgram`	INT UNSIGNED NOT NULL,
						 PRIMARY KEY (`id`),
						CONSTRAINT `FkProgr` 
							FOREIGN KEY (`fkProgram`)
							REFERENCES `AktualizacjeProgramy`(`id`)
							ON UPDATE CASCADE
							ON DELETE RESTRICT
				 	)
				 	ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `tiksoft_db`.`AktualizacjeOpisyLang`(
  	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  	`lang` VARCHAR(3) NULL ,
  	`opis` TEXT NOT NULL,
	 `FkAktualOpisy` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `FK_Akt2`
    FOREIGN KEY (`FkAktualOpisy` )
    REFERENCES `AktualizacjeOpisy`(`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


DROP TRIGGER IF EXISTS `ai_AktualizacjeOpisy`;

CREATE TRIGGER `ai_AktualizacjeOpisy` AFTER INSERT ON `AktualizacjeOpisy`
 FOR EACH ROW 
BEGIN
DECLARE lang VARCHAR(3);
DECLARE done INT DEFAULT 0;
DECLARE langCursor CURSOR FOR SELECT `ShortName` FROM `cmsLang` WHERE `ShortName` <> 'PL';
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

OPEN langCursor;

read_loop:LOOP
   FETCH langCursor INTO lang;
   
   IF done THEN 
        LEAVE read_loop;
    END IF;
   INSERT INTO `AktualizacjeOpisyLang` (`opis`,   `lang`, `FkAktualOpisy`)
   VALUES (NEW.`opis`, lang, NEW.`id`);
END LOOP;  
CLOSE langCursor;
end;
